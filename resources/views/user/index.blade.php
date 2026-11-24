<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Administrasi Sistem</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Manajemen Pengguna</h2>
                <p class="mt-1 text-sm text-slate-500">Kelola akun, penempatan pegawai, role, dan status akses SIPERDIN.</p>
            </div>
            @can('users.create')
                <a href="{{ route('user.create') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 4a.75.75 0 0 1 .75.75v4.5h4.5a.75.75 0 0 1 0 1.5h-4.5v4.5a.75.75 0 0 1-1.5 0v-4.5h-4.5a.75.75 0 0 1 0-1.5h4.5v-4.5A.75.75 0 0 1 10 4Z" />
                    </svg>
                    Tambah Pengguna
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('status') === 'user-password-reset')
                <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                    Password akun berhasil direset.
                </div>
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

            <section class="grid gap-4 sm:grid-cols-3" aria-label="Ringkasan akun">
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Total akun</p>
                        <span class="rounded-lg bg-slate-100 p-2 text-slate-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m16 0v-2a4 4 0 0 0-3-3.87M14 3.13a4 4 0 0 1 0 7.75M14 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($statistics['total']) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Seluruh akun yang tersimpan</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Akun aktif</p>
                        <span class="rounded-lg bg-emerald-50 p-2 text-emerald-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" /></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($statistics['active']) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Dapat melakukan autentikasi</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-slate-500">Akun nonaktif</p>
                        <span class="rounded-lg bg-amber-50 p-2 text-amber-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path stroke-linecap="round" d="M8.5 8.5 15.5 15.5" /></svg>
                        </span>
                    </div>
                    <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">{{ number_format($statistics['inactive']) }}</p>
                    <p class="mt-1 text-xs text-slate-500">Tidak dapat masuk ke sistem</p>
                </div>
            </section>

            <section class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-200 px-5 py-4 sm:px-6">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h3 class="font-semibold text-slate-900">Daftar akun pengguna</h3>
                            <p class="mt-1 text-sm text-slate-500">Cari akun berdasarkan username, nama pegawai, NIP, atau satuan kerja.</p>
                        </div>
                        <p class="text-xs text-slate-500">{{ $users->total() }} akun ditemukan</p>
                    </div>

                    <form method="GET" action="{{ route('user.index') }}" class="mt-4 grid gap-3 md:grid-cols-12">
                        <div class="md:col-span-6">
                            <label for="q" class="sr-only">Cari pengguna</label>
                            <div class="relative">
                                <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8.5 3a5.5 5.5 0 1 0 3.478 9.76l3.631 3.63a.75.75 0 1 0 1.06-1.06l-3.63-3.631A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" clip-rule="evenodd" /></svg>
                                <input id="q" name="q" type="search" value="{{ $search }}" placeholder="Cari username, nama, NIP, atau satker..."
                                       class="w-full rounded-lg border-slate-300 py-2.5 pl-9 pr-3 text-sm text-slate-800 shadow-sm placeholder:text-slate-400 focus:border-slate-500 focus:ring-slate-500">
                            </div>
                        </div>
                        <div class="md:col-span-3">
                            <label for="role" class="sr-only">Filter role</label>
                            <select id="role" name="role" class="w-full rounded-lg border-slate-300 py-2.5 text-sm text-slate-700 shadow-sm focus:border-slate-500 focus:ring-slate-500">
                                <option value="">Semua role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" @selected($roleFilter === $role->name)>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="status" class="sr-only">Filter status</label>
                            <select id="status" name="status" class="w-full rounded-lg border-slate-300 py-2.5 text-sm text-slate-700 shadow-sm focus:border-slate-500 focus:ring-slate-500">
                                <option value="">Semua status</option>
                                <option value="aktif" @selected($statusFilter === 'aktif')>Aktif</option>
                                <option value="nonaktif" @selected($statusFilter === 'nonaktif')>Nonaktif</option>
                            </select>
                        </div>
                        <div class="flex gap-2 md:col-span-1">
                            <button type="submit" class="flex-1 rounded-lg bg-slate-800 px-3 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">Cari</button>
                        </div>
                    </form>
                    @if ($search !== '' || $roleFilter !== '' || $statusFilter !== '')
                        <div class="mt-3">
                            <a href="{{ route('user.index') }}" class="text-sm font-medium text-slate-600 underline decoration-slate-300 underline-offset-4 hover:text-slate-900">Hapus semua filter</a>
                        </div>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">No.</th>
                                <th scope="col" class="min-w-56 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Pengguna</th>
                                <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">NIP</th>
                                <th scope="col" class="min-w-48 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Satuan kerja</th>
                                <th scope="col" class="min-w-40 px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Role</th>
                                <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                                <th scope="col" class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Dibuat</th>
                                <th scope="col" class="whitespace-nowrap px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($users as $user)
                                <tr class="transition hover:bg-slate-50/80">
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">{{ $users->firstItem() + $loop->index }}</td>
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-900">{{ $user->pegawai?->nama_lengkap ?? 'Akun administratif' }}</div>
                                        <div class="mt-0.5 text-xs text-slate-500">{{ '@'.$user->username }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $user->pegawai?->nip_baru ?: ($user->pegawai?->nip ?: '—') }}</td>
                                    <td class="px-5 py-4 text-sm text-slate-600">{{ $user->pegawai?->satuanKerja?->nama_satker ?? '—' }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @forelse ($user->roles as $role)
                                                <span class="inline-flex rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700">{{ $role->name }}</span>
                                            @empty
                                                <span class="text-xs italic text-slate-400">Belum ditetapkan</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        @if ($user->isActive())
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Aktif</span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600"><span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-500">{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-right">
                                        @can('users.update')
                                            <a href="{{ route('user.edit', $user) }}" class="inline-flex items-center rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-100">Kelola akun</a>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-14 text-center">
                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m16 0v-2a4 4 0 0 0-3-3.87M14 3.13a4 4 0 0 1 0 7.75M14 7a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z" /></svg>
                                        </div>
                                        <p class="mt-3 font-semibold text-slate-900">Tidak ada akun yang ditemukan</p>
                                        <p class="mt-1 text-sm text-slate-500">Ubah kata kunci atau filter, atau tambahkan akun pengguna baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="border-t border-slate-200 px-5 py-4 sm:px-6">
                        {{ $users->links() }}
                    </div>
                @endif
            </section>

            <div class="rounded-lg border border-blue-100 bg-blue-50/70 px-4 py-3 text-sm text-blue-900">
                <span class="font-semibold">Catatan pengelolaan akses:</span>
                Role yang tersedia mengikuti matriks RBAC SIPERDIN. Halaman ini hanya mengatur akun dan penetapan role; konfigurasi permission setiap role tidak diubah dari antarmuka.
            </div>
        </div>
    </div>
</x-app-layout>
