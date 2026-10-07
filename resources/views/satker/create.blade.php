<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Satuan Kerja
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('satker.store') }}" method="POST">
                    @csrf

                    {{-- Kode Satker --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Kode Satker
                        </label>

                        <input type="text"
                            name="kode_satker"
                            value="{{ old('kode_satker') }}"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('kode_satker')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Nama Satker --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Nama Satker
                        </label>

                        <input type="text"
                            name="nama_satker"
                            value="{{ old('nama_satker') }}"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('nama_satker')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>

                    <a href="{{ route('satker.index') }}"
                       class="ml-3 text-gray-600">
                        Kembali
                    </a>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>