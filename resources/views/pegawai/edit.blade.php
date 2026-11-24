
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Pegawai
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Perbarui Informasi Pegawai
                </h3>

                <form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Satuan Kerja --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Satuan Kerja <span class="text-red-600">*</span>
                        </label>

                        <select name="id_satker"
                                class="mt-1 block w-full rounded border-gray-300">

                            <option value="">-- Pilih Satuan Kerja --</option>

                            @foreach ($satuanKerjas as $satuanKerja)
                                <option value="{{ $satuanKerja->id_satker }}"
                                    {{ old('id_satker', $pegawai->id_satker) == $satuanKerja->id_satker ? 'selected' : '' }}>

                                    {{ $satuanKerja->nama_satker }}

                                </option>
                            @endforeach

                        </select>

                        @error('id_satker')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            NIP <span class="text-red-600">*</span>
                        </label>

                        <input type="text"
                               name="nip"
                               value="{{ old('nip', $pegawai->nip) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('nip')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- NIP Baru --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            NIP Baru
                        </label>

                        <input type="text"
                               name="nip_baru"
                               value="{{ old('nip_baru', $pegawai->nip_baru) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('nip_baru')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Nama Lengkap --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Nama Lengkap <span class="text-red-600">*</span>
                        </label>

                        <input type="text"
                               name="nama_lengkap"
                               value="{{ old('nama_lengkap', $pegawai->nama_lengkap) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('nama_lengkap')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Pangkat --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Pangkat
                        </label>

                        <input type="text"
                               name="pangkat"
                               value="{{ old('pangkat', $pegawai->pangkat) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('pangkat')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Golongan Ruang --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Golongan / Ruang
                        </label>

                        <input type="text"
                               name="gol_ruang"
                               value="{{ old('gol_ruang', $pegawai->gol_ruang) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('gol_ruang')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tipe Jabatan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Tipe Jabatan
                        </label>

                        <input type="text"
                               name="tipe_jabatan"
                               value="{{ old('tipe_jabatan', $pegawai->tipe_jabatan) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('tipe_jabatan')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tampil Jabatan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Jabatan
                        </label>

                        <input type="text"
                               name="tampil_jabatan"
                               value="{{ old('tampil_jabatan', $pegawai->tampil_jabatan) }}"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('tampil_jabatan')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Keterangan
                        </label>

                        <textarea name="keterangan"
                                  rows="3"
                                  class="mt-1 block w-full rounded border-gray-300">{{ old('keterangan', $pegawai->keterangan) }}</textarea>

                        @error('keterangan')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex gap-3 mt-6">

                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('pegawai.index') }}"
                           class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
