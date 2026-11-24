
<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800">
                Tambah Pegawai
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Tambahkan data pegawai ke dalam sistem SIPERDIN.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf

                    {{-- INFORMASI KEPEGAWAIAN --}}
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">
                        Informasi Kepegawaian
                    </h3>

                    {{-- Satuan Kerja --}}
                    <div class="mb-5">
                        <label for="id_satker"
                            class="block text-sm font-medium text-gray-700">
                            Satuan Kerja <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="id_satker"
                            id="id_satker"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        >
                            <option value="">-- Pilih Satuan Kerja --</option>

                            @foreach ($satuanKerjas as $satker)
                                <option
                                    value="{{ $satker->id_satker }}"
                                    {{ old('id_satker') == $satker->id_satker ? 'selected' : '' }}
                                >
                                    {{ $satker->nama_satker }}
                                </option>
                            @endforeach
                        </select>

                        @if ($satuanKerjas->isEmpty())
                            <p class="text-sm text-amber-600 mt-1">
                                Belum ada data satuan kerja. Tambahkan data satuan
                                kerja terlebih dahulu.
                            </p>
                        @endif

                        @error('id_satker')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="mb-5">
                        <label for="nip"
                            class="block text-sm font-medium text-gray-700">
                            NIP <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nip"
                            id="nip"
                            value="{{ old('nip') }}"
                            required
                            maxlength="30"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Masukkan NIP"
                        >

                        @error('nip')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIP BARU --}}
                    <div class="mb-5">
                        <label for="nip_baru"
                            class="block text-sm font-medium text-gray-700">
                            NIP Baru
                        </label>

                        <input
                            type="text"
                            name="nip_baru"
                            id="nip_baru"
                            value="{{ old('nip_baru') }}"
                            maxlength="30"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Masukkan NIP baru jika tersedia"
                        >

                        @error('nip_baru')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NAMA LENGKAP --}}
                    <div class="mb-5">
                        <label for="nama_lengkap"
                            class="block text-sm font-medium text-gray-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_lengkap"
                            id="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            required
                            maxlength="100"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Masukkan nama lengkap pegawai"
                        >

                        @error('nama_lengkap')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PANGKAT --}}
                    <div class="mb-5">
                        <label for="pangkat"
                            class="block text-sm font-medium text-gray-700">
                            Pangkat
                        </label>

                        <input
                            type="text"
                            name="pangkat"
                            id="pangkat"
                            value="{{ old('pangkat') }}"
                            maxlength="50"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Contoh: Pembina"
                        >

                        @error('pangkat')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- GOLONGAN RUANG --}}
                    <div class="mb-5">
                        <label for="gol_ruang"
                            class="block text-sm font-medium text-gray-700">
                            Golongan / Ruang
                        </label>

                        <input
                            type="text"
                            name="gol_ruang"
                            id="gol_ruang"
                            value="{{ old('gol_ruang') }}"
                            maxlength="20"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Contoh: IV/a"
                        >

                        @error('gol_ruang')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- JABATAN --}}
                    <h3 class="text-lg font-semibold text-gray-800 mt-8 mb-4">
                        Informasi Jabatan
                    </h3>

                    {{-- TIPE JABATAN --}}
                    <div class="mb-5">
                        <label for="tipe_jabatan"
                            class="block text-sm font-medium text-gray-700">
                            Tipe Jabatan
                        </label>

                        <input
                            type="text"
                            name="tipe_jabatan"
                            id="tipe_jabatan"
                            value="{{ old('tipe_jabatan') }}"
                            maxlength="50"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Masukkan tipe jabatan"
                        >

                        @error('tipe_jabatan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TAMPIL JABATAN --}}
                    <div class="mb-5">
                        <label for="tampil_jabatan"
                            class="block text-sm font-medium text-gray-700">
                            Nama Jabatan
                        </label>

                        <input
                            type="text"
                            name="tampil_jabatan"
                            id="tampil_jabatan"
                            value="{{ old('tampil_jabatan') }}"
                            maxlength="100"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Masukkan nama jabatan"
                        >

                        @error('tampil_jabatan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- KETERANGAN --}}
                    <div class="mb-6">
                        <label for="keterangan"
                            class="block text-sm font-medium text-gray-700">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            id="keterangan"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                            placeholder="Tambahkan keterangan jika diperlukan"
                        >{{ old('keterangan') }}</textarea>

                        @error('keterangan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- TOMBOL --}}
                    <div class="flex items-center justify-end gap-3 border-t pt-5">

                        <a
                            href="{{ route('pegawai.index') }}"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                        >
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                        >
                            Simpan Pegawai
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
