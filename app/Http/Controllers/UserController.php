<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Role;
use App\Models\User;
use App\Support\Rbac\PermissionMatrix;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /** Display and filter internal user accounts. */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $roleFilter = (string) $request->query('role', '');
        $statusFilter = (string) $request->query('status', '');
        $roleNames = array_keys(PermissionMatrix::roles());

        $query = User::query()
            ->with(['pegawai.satuanKerja', 'roles']);

        if ($search !== '') {
            $query->where(function (Builder $userQuery) use ($search): void {
                $like = '%'.$search.'%';

                $userQuery
                    ->where('username', 'like', $like)
                    ->orWhereHas('pegawai', function (Builder $pegawaiQuery) use ($like): void {
                        $pegawaiQuery
                            ->where('nama_lengkap', 'like', $like)
                            ->orWhere('nip', 'like', $like)
                            ->orWhere('nip_baru', 'like', $like)
                            ->orWhereHas('satuanKerja', function (Builder $satkerQuery) use ($like): void {
                                $satkerQuery->where('nama_satker', 'like', $like);
                            });
                    });
            });
        }

        if (in_array($roleFilter, $roleNames, true)) {
            $query->whereHas('roles', function (Builder $roleQuery) use ($roleFilter): void {
                $roleQuery
                    ->where('guard_name', PermissionMatrix::GUARD)
                    ->where('name', $roleFilter);
            });
        }

        if (in_array($statusFilter, ['aktif', 'nonaktif'], true)) {
            $query->where('status', $statusFilter);
        }

        $users = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id_user')
            ->paginate(15)
            ->withQueryString();

        $roles = $this->availableRoles();
        $statistics = [
            'total' => User::count(),
            'active' => User::where('status', 'aktif')->count(),
            'inactive' => User::where('status', 'nonaktif')->count(),
        ];

        return view('user.index', compact(
            'users',
            'roles',
            'statistics',
            'search',
            'roleFilter',
            'statusFilter'
        ));
    }

    /** Show the account creation form. */
    public function create(): View
    {
        $roles = $this->availableRoles();
        $pegawais = Pegawai::query()
            ->with('satuanKerja')
            ->whereDoesntHave('user')
            ->whereHas('satuanKerja', fn (Builder $query) => $query->where('status', 'aktif'))
            ->orderBy('nama_lengkap')
            ->get();

        return view('user.create', compact('roles', 'pegawais'));
    }

    /** Create an account and assign exactly one approved internal role. */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9._-]+$/',
                Rule::unique('users', 'username'),
            ],
            'id_pegawai' => [
                Rule::requiredIf($this->roleRequiresEmployee((string) $request->input('role'))),
                'nullable',
                'integer',
                'exists:pegawai,id_pegawai',
                Rule::unique('users', 'id_pegawai'),
            ],
            'role' => ['required', Rule::in($this->activeRoleNames())],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, titik, garis bawah, dan tanda hubung.',
            'id_pegawai.required' => 'Pilih data pegawai untuk role Operator Satker atau Admin Keuangan.',
            'id_pegawai.unique' => 'Pegawai tersebut sudah terhubung dengan akun lain.',
            'role.in' => 'Role yang dipilih tidak tersedia atau sedang tidak aktif.',
        ], [
            'id_pegawai' => 'pegawai',
        ]);

        $user = DB::transaction(function () use ($validated, $request): User {
            $user = User::create([
                'id_pegawai' => $validated['id_pegawai'] ?? null,
                'username' => $validated['username'],
                'password' => $validated['password'],
                'status' => 'aktif',
            ]);

            $user->syncRoles([$validated['role']]);

            $this->recordActivity(
                $request->user(),
                'buat_akun_pengguna',
                'Membuat akun '.$user->username.' dengan role '.$validated['role'].'.'
            );

            return $user;
        });

        return redirect()
            ->route('user.edit', $user)
            ->with('success', 'Akun pengguna berhasil dibuat. Pastikan kredensial awal disampaikan secara aman kepada pemilik akun.');
    }

    /** Show account details and administrative actions. */
    public function edit(User $user): View
    {
        $user->load(['pegawai.satuanKerja', 'roles']);
        $roles = $this->availableRoles();

        $pegawais = Pegawai::query()
            ->with('satuanKerja')
            ->where(function (Builder $query) use ($user): void {
                $query
                    ->whereDoesntHave('user')
                    ->orWhere('id_pegawai', $user->id_pegawai);
            })
            ->orderBy('nama_lengkap')
            ->get();

        return view('user.edit', compact('user', 'roles', 'pegawais'));
    }

    /** Update account identity fields; role and status have separate permission gates. */
    public function update(Request $request, User $user): RedirectResponse
    {
        $requiresEmployee = $user->hasAnyRole(['Operator Satker', 'Admin Keuangan']);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9._-]+$/',
                Rule::unique('users', 'username')->ignore($user->id_user, 'id_user'),
            ],
            'id_pegawai' => [
                Rule::requiredIf($requiresEmployee),
                'nullable',
                'integer',
                'exists:pegawai,id_pegawai',
                Rule::unique('users', 'id_pegawai')->ignore($user->id_user, 'id_user'),
            ],
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, titik, garis bawah, dan tanda hubung.',
            'id_pegawai.required' => 'Pilih data pegawai untuk akun Operator Satker atau Admin Keuangan.',
            'id_pegawai.unique' => 'Pegawai tersebut sudah terhubung dengan akun lain.',
        ], [
            'id_pegawai' => 'pegawai',
        ]);

        DB::transaction(function () use ($request, $user, $validated): void {
            $before = $user->username;

            $user->update([
                'username' => $validated['username'],
                'id_pegawai' => $validated['id_pegawai'] ?? null,
            ]);

            $this->recordActivity(
                $request->user(),
                'ubah_akun_pengguna',
                'Memperbarui informasi akun '.$before.' menjadi '.$user->username.'.'
            );
        });

        return redirect()
            ->route('user.edit', $user)
            ->with('success', 'Informasi akun berhasil diperbarui.');
    }

    /** Assign one of the four approved internal roles. */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::in($this->activeRoleNames())],
        ], [
            'role.in' => 'Role yang dipilih tidak tersedia atau sedang tidak aktif.',
        ]);

        $newRole = $validated['role'];

        if ($request->user()->is($user) && $newRole !== 'Superadmin') {
            throw ValidationException::withMessages([
                'role' => 'Role Superadmin pada akun yang sedang digunakan tidak dapat diubah dari halaman ini.',
            ]);
        }

        if ($this->roleRequiresEmployee($newRole) && $user->id_pegawai === null) {
            throw ValidationException::withMessages([
                'role' => 'Hubungkan akun dengan data pegawai terlebih dahulu sebelum menetapkan role Operator Satker atau Admin Keuangan.',
            ]);
        }

        if ($user->hasRole('Superadmin') && $user->isActive() && $newRole !== 'Superadmin') {
            $this->ensureAnotherActiveSuperadminExists($user, 'role');
        }

        $oldRoles = $user->getRoleNames()->implode(', ');

        DB::transaction(function () use ($request, $user, $newRole, $oldRoles): void {
            $user->syncRoles([$newRole]);

            $this->recordActivity(
                $request->user(),
                'ubah_role_pengguna',
                'Mengubah role akun '.$user->username.' dari '.($oldRoles ?: 'belum ditetapkan').' menjadi '.$newRole.'.'
            );
        });

        return redirect()
            ->route('user.edit', $user)
            ->with('success', 'Role pengguna berhasil diperbarui. Hak akses mengikuti matriks RBAC yang telah ditetapkan.');
    }

    /** Activate or deactivate an account without deleting its history. */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $newStatus = $validated['status'];

        if ($request->user()->is($user) && $newStatus === 'nonaktif') {
            throw ValidationException::withMessages([
                'status' => 'Akun Superadmin yang sedang digunakan tidak dapat dinonaktifkan dari sesi ini.',
            ]);
        }

        if ($user->hasRole('Superadmin') && $user->isActive() && $newStatus === 'nonaktif') {
            $this->ensureAnotherActiveSuperadminExists($user, 'status');
        }

        $oldStatus = $user->status;

        DB::transaction(function () use ($request, $user, $newStatus, $oldStatus): void {
            $user->forceFill([
                'status' => $newStatus,
                'remember_token' => $newStatus === 'nonaktif' ? Str::random(60) : $user->remember_token,
            ])->save();

            $this->recordActivity(
                $request->user(),
                'ubah_status_pengguna',
                'Mengubah status akun '.$user->username.' dari '.$oldStatus.' menjadi '.$newStatus.'.'
            );
        });

        return redirect()
            ->route('user.edit', $user)
            ->with('success', 'Status akun berhasil diperbarui.');
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, Role> */
    private function availableRoles()
    {
        return Role::query()
            ->where('guard_name', PermissionMatrix::GUARD)
            ->where('status', 'aktif')
            ->whereIn('name', array_keys(PermissionMatrix::roles()))
            ->orderBy('id')
            ->get();
    }

    /** @return list<string> */
    private function activeRoleNames(): array
    {
        return $this->availableRoles()->pluck('name')->all();
    }

    private function roleRequiresEmployee(string $role): bool
    {
        return in_array($role, ['Operator Satker', 'Admin Keuangan'], true);
    }

    private function ensureAnotherActiveSuperadminExists(User $target, string $errorField): void
    {
        $otherActiveSuperadmins = User::query()
            ->role('Superadmin')
            ->where('status', 'aktif')
            ->where('id_user', '!=', $target->id_user)
            ->count();

        if ($otherActiveSuperadmins < 1) {
            throw ValidationException::withMessages([
                $errorField => 'Perubahan ditolak karena sistem harus memiliki minimal satu akun Superadmin aktif.',
            ]);
        }
    }

    private function recordActivity(User $actor, string $activity, string $description): void
    {
        DB::table('activity_log')->insert([
            'id_user' => $actor->id_user,
            'waktu' => now(),
            'aktivitas' => $activity,
            'keterangan' => $description,
        ]);
    }
}
