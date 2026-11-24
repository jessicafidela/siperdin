
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Template Dokumen
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('template-dokumen.store') }}"
                      method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Nama Template
                        </label>

                        <input type="text"
                               name="nama_template"
                               value="{{ old('nama_template') }}"
                               required
                               maxlength="100"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('nama_template')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Jenis Dokumen
                        </label>

                        <input type="text"
                               name="jenis_dokumen"
                               value="{{ old('jenis_dokumen') }}"
                               required
                               maxlength="50"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('jenis_dokumen')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Format File
                        </label>

                        <input type="text"
                               name="format_file"
                               value="{{ old('format_file') }}"
                               placeholder="Contoh: docx, pdf"
                               maxlength="20"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('format_file')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Struktur Dokumen
                        </label>

                        <textarea name="struktur_dokumen"
                                  rows="4"
                                  class="mt-1 block w-full rounded border-gray-300">{{ old('struktur_dokumen') }}</textarea>

                        @error('struktur_dokumen')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Aturan Penomoran
                        </label>

                        <textarea name="aturan_penomoran"
                                  rows="4"
                                  class="mt-1 block w-full rounded border-gray-300">{{ old('aturan_penomoran') }}</textarea>

                        @error('aturan_penomoran')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium">
                            Lokasi Template
                        </label>

                        <input type="text"
                               name="lokasi_template"
                               value="{{ old('lokasi_template') }}"
                               maxlength="255"
                               placeholder="Masukkan lokasi atau path template"
                               class="mt-1 block w-full rounded border-gray-300">

                        @error('lokasi_template')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>

                    <a href="{{ route('template-dokumen.index') }}"
                       class="ml-3 text-gray-600">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
