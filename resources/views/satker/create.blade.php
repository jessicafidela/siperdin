
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Satuan Kerja
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Informasi Satuan Kerja
                </h3>

                <form action="{{ route('satuan-kerja.store') }}" method="POST">
                    @csrf

                    {{-- Kode Satker --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Kode Satker <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="kode_satker"
                               value="{{ old('kode_satker') }}"
                               placeholder="Masukkan kode satuan kerja"
                               required
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm">

                        @error('kode_satker')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Nama Satker --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Nama Satker <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="nama_satker"
                               value="{{ old('nama_satker') }}"
                               placeholder="Masukkan nama satuan kerja"
                               required
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm">

                        @error('nama_satker')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Keterangan
                        </label>

                        <textarea name="keterangan"
                                  rows="3"
                                  placeholder="Masukkan keterangan jika diperlukan"
                                  class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('keterangan') }}</textarea>

                        @error('keterangan')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Status --}}
                    <div class="mb-6">

                        <label class="block text-sm font-medium text-gray-700">
                            Status <span class="text-red-500">*</span>
                        </label>

                        <select name="status"
                                required
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm">

                            <option value="">-- Pilih Status --</option>

                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                Nonaktif
                            </option>

                        </select>

                        @error('status')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center gap-3">

                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Simpan
                        </button>

                        <a href="{{ route('satuan-kerja.index') }}"
                           class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
