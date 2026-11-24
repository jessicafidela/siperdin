<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('user.index') }}" class="text-sm font-medium text-slate-500 transition hover:text-slate-800">← Manajemen Pengguna</a>
            <p class="mt-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Administrasi Sistem</p>
            <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Tambah Pengguna</h2>
            <p class="mt-1 text-sm text-slate-500">Buat akun internal dan tetapkan satu role sesuai tanggung jawab pengguna.</p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-slate-50 py-8">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                    <p class="font-semibold">Akun belum dapat disimpan.</p>
                    <ul class="mt-1 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.store') }}" method="POST" class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm" x-data="{ selectedRole: @js(old('role', '')) }">
                @csrf
                <div class="border-b border-slate-200 px-6 py-5">
                    <h3 class="font-semibold text-slate-900">Informasi akun</h3>
                    <p class="mt-1 text-sm text-slate-500">Isi identitas login dan hubungkan akun dengan data pegawai apabila diperlukan.</p>
                </div>

                <div class="space-y-6 p-6">
                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="username" class="mb-1.5 block text-sm font-medium text-slate-700">Username <span class="text-rose-600">*</span></label>
                            <input id="username" name="username" type="text" value="{{ old('username') }}" maxlength="50" autocomplete="off" required
                                   placeholder="contoh: nama.pengguna"
                                   class="w-full rounded-lg border-slate-300 text-sm shadow-sm placeholder:text-slate-400 focus:border-slate-500 focus:ring-slate-500">
                            @error('username') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-slate-500">Gunakan huruf, angka, titik, garis bawah, atau tanda hubung. Maksimal 50 karakter.</p>
                        </div>

                        <div>
                            <label for="role" class="mb-1.5 block text-sm font-medium text-slate-700">Role pengguna <span class="text-rose-600">*</span></label>
                            <select id="role" name="role" x-model="selectedRole" required
                                    class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                                <option value="">Pilih role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="id_pegawai" class="mb-1.5 block text-sm font-medium text-slate-700">Data pegawai <span class="text-rose-600" x-show="selectedRole === 'Operator Satker' || selectedRole === 'Admin Keuangan'">*</span></label>
                        <select id="id_pegawai" name="id_pegawai" :required="selectedRole === 'Operator Satker' || selectedRole === 'Admin Keuangan'"
                                class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            <option value="">Tidak dihubungkan dengan pegawai</option>
                            @foreach ($pegawais as $pegawai)
                                <option value="{{ $pegawai->id_pegawai }}" @selected((string) old('id_pegawai') === (string) $pegawai->id_pegawai)>
                                    {{ $pegawai->nama_lengkap }} — {{ $pegawai->nip_baru ?: ($pegawai->nip ?: 'Tanpa NIP') }} — {{ $pegawai->satuanKerja?->nama_satker ?? 'Satker tidak tersedia' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_pegawai') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                        <p class="mt-1.5 text-xs text-slate-500">Akun Operator Satker dan Admin Keuangan wajib terhubung dengan data pegawai untuk menentukan cakupan satuan kerja. Role Superadmin dan Operator Data dapat menggunakan akun tanpa penautan pegawai.</p>
                        @if ($pegawais->isEmpty())
                            <p class="mt-2 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-800">Tidak ada data pegawai aktif yang belum memiliki akun. Tambahkan data pegawai terlebih dahulu atau buat akun Superadmin tanpa penautan pegawai.</p>
                        @endif
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                        <h4 class="text-sm font-semibold text-slate-800">Kewenangan role</h4>
                        <div class="mt-3 grid gap-3 sm:grid-cols-2">
                            @foreach ($roles as $role)
                                <div class="rounded-lg border border-slate-200 bg-white p-3">
                                    <p class="text-sm font-semibold text-slate-800">{{ $role->name }}</p>
                                    <p class="mt-1 text-xs leading-5 text-slate-500">{{ $role->deskripsi }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div>
                            <label for="password" class="mb-1.5 block text-sm font-medium text-slate-700">Password awal <span class="text-rose-600">*</span></label>
                            <input id="password" name="password" type="password" autocomplete="new-password" required
                                   class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                            @error('password') <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p> @enderror
                            <p class="mt-1.5 text-xs text-slate-500">Minimal 12 karakter. Jangan gunakan password yang sama dengan akun lain.</p>
                        </div>
                        <div>
                            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Konfirmasi password <span class="text-rose-600">*</span></label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                   class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-slate-500 focus:ring-slate-500">
                        </div>
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <a href="{{ route('user.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Batal</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">Simpan Pengguna</button>
                </div>
            </form>

            <div class="rounded-lg border border-blue-100 bg-blue-50/70 px-4 py-3 text-sm text-blue-900">
                Password awal disimpan dalam bentuk hash. Proses pemulihan password dilakukan oleh Superadmin melalui fitur reset password, bukan melalui email.
            </div>
        </div>
    </div>
</x-app-layout>
