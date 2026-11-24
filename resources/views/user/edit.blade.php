<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('user.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">← Manajemen Pengguna</a>
                <p class="mt-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Administrasi Sistem</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Kelola Akun Pengguna</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $user->pegawai?->nama_lengkap ?? 'Akun administratif' }} · {{ '@'.$user->username }}</p>
            </div>
            @if ($user->isActive())
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700"><span class="h-2 w-2 rounded-full bg-emerald-500"></span>Akun aktif</span>
            @else
                <span class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-sm font-semibold text-slate-600"><span class="h-2 w-2 rounded-full bg-slate-400"></span>Akun nonaktif</span>
            @endif
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">{{ session('success') }}</div>
            @endif
            @if (session('status') === 'user-password-reset')
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">Password akun berhasil direset. Sampaikan password baru kepada pemilik akun melalui saluran yang aman.</div>
            @endif
            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                    <p class="font-semibold">Terdapat data yang perlu diperiksa.</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="font-semibold text-slate-900">Informasi akun</h3>
                    <p class="mt-1 text-sm text-slate-500">Perbarui username atau hubungan akun dengan data pegawai.</p>
                </div>
                <form action="{{ route('user.update', $user) }}" method="POST" class="space-y-5 p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="username" class="mb-1.5 block text-sm font-medium text-slate-700">Username <span class="text-rose-600">*</span></label>
                            <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" maxlength="50" required
                                   class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @error('username') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="id_pegawai" class="mb-1.5 block text-sm font-medium text-slate-700">Data pegawai @if ($user->hasAnyRole(['Operator Satker', 'Admin Keuangan']))<span class="text-rose-600">*</span>@endif</label>
                            <select id="id_pegawai" name="id_pegawai" @required($user->hasAnyRole(['Operator Satker', 'Admin Keuangan']))
                                    class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                                <option value="">Tidak dihubungkan dengan pegawai</option>
                                @foreach ($pegawais as $pegawai)
                                    <option value="{{ $pegawai->id_pegawai }}" @selected((string) old('id_pegawai', $user->id_pegawai) === (string) $pegawai->id_pegawai)>
                                        {{ $pegawai->nama_lengkap }} — {{ $pegawai->nip_baru ?: ($pegawai->nip ?: 'Tanpa NIP') }} — {{ $pegawai->satuanKerja?->nama_satker ?? 'Satker tidak tersedia' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_pegawai') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-slate-500">Pegawai hanya dapat dihubungkan ke satu akun. Operator Satker dan Admin Keuangan wajib memiliki penautan pegawai untuk pembatasan cakupan satuan kerja.</p>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">Simpan informasi akun</button>
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="font-semibold text-slate-900">Penetapan role</h3>
                    <p class="mt-1 text-sm text-slate-500">Pilih satu role internal. Hak akses setiap role mengikuti matriks RBAC yang telah ditetapkan.</p>
                </div>
                <form action="{{ route('user.role', $user) }}" method="POST" class="space-y-5 p-6">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="role" class="mb-1.5 block text-sm font-medium text-slate-700">Role pengguna <span class="text-rose-600">*</span></label>
                        <select id="role" name="role" required @disabled(auth()->user()->is($user))
                                class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500 disabled:bg-slate-100 disabled:text-slate-500">
                            <option value="">Pilih role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role', $user->getRoleNames()->first()) === $role->name)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                        @if (auth()->user()->is($user))
                            <p class="mt-1.5 text-xs text-amber-700">Role akun Superadmin yang sedang digunakan dikunci untuk mencegah kehilangan akses administratif.</p>
                        @else
                            <p class="mt-1.5 text-xs text-slate-500">Perubahan role langsung mengubah permission efektif akun sesuai konfigurasi sistem.</p>
                        @endif
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" @disabled(auth()->user()->is($user)) class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:bg-slate-300">Simpan role</button>
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="font-semibold text-slate-900">Status akun</h3>
                    <p class="mt-1 text-sm text-slate-500">Akun nonaktif tidak dapat melakukan autentikasi ke SIPERDIN. Riwayat akun tetap disimpan.</p>
                </div>
                <form action="{{ route('user.status', $user) }}" method="POST" class="space-y-5 p-6" onsubmit="return confirm('Simpan perubahan status akun ini?')">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="mb-1.5 block text-sm font-medium text-slate-700">Status pengguna <span class="text-rose-600">*</span></label>
                        <select id="status" name="status" required @disabled(auth()->user()->is($user))
                                class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500 disabled:bg-slate-100 disabled:text-slate-500">
                            <option value="aktif" @selected(old('status', $user->status) === 'aktif')>Aktif</option>
                            <option value="nonaktif" @selected(old('status', $user->status) === 'nonaktif')>Nonaktif</option>
                        </select>
                        @error('status') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                        @if (auth()->user()->is($user))
                            <p class="mt-1.5 text-xs text-amber-700">Akun yang sedang digunakan tidak dapat dinonaktifkan dari sesi ini.</p>
                        @endif
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" @disabled(auth()->user()->is($user)) class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700 disabled:cursor-not-allowed disabled:bg-slate-300">Simpan status</button>
                    </div>
                </form>
            </section>

            <section class="overflow-hidden rounded-xl border border-amber-200 bg-white shadow-sm">
                <div class="border-b border-amber-100 bg-amber-50/70 px-6 py-5">
                    <h3 class="font-semibold text-slate-900">Reset password</h3>
                    <p class="mt-1 text-sm text-slate-600">Atur password baru untuk pengguna ini. Password tidak dikirim melalui email.</p>
                </div>
                <form action="{{ route('user.reset-password', $user) }}" method="POST" class="space-y-5 p-6">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password baru <span class="text-rose-600">*</span></label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                   class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @error('password') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-slate-500">Minimal 12 karakter.</p>
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi password baru <span class="text-rose-600">*</span></label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                   class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        </div>
                    </div>
                    @if (auth()->user()->is($user))
                        <p class="rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-800">Untuk mengganti password akun sendiri, gunakan menu Profil Akun.</p>
                    @else
                        <div class="flex justify-end">
                            <button type="submit" onclick="return confirm('Reset password pengguna ini?')" class="rounded-lg bg-amber-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-800">Reset password pengguna</button>
                        </div>
                    @endif
                </form>
            </section>

            <div class="flex flex-col gap-2 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>ID akun: {{ $user->id_user }} · Dibuat: {{ $user->created_at?->format('d M Y H:i') ?? '—' }}</p>
                <a href="{{ route('user.index') }}" class="font-semibold text-slate-700 underline decoration-slate-300 underline-offset-4 hover:text-slate-900">Kembali ke daftar pengguna</a>
            </div>
        </div>
    </div>
</x-app-layout>
