<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Tempat
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('place.store') }}" method="POST">
                    @csrf

                    {{-- Nama Tempat --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Nama Tempat
                        </label>

                        <input type="text" name="nama_tempat" value="{{ old('nama_tempat') }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('nama_tempat')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Provinsi --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Provinsi
                        </label>

                        <input type="text" name="provinsi" value="{{ old('provinsi') }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('provinsi')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>

                    <a href="{{ route('place.index') }}" class="ml-3 text-gray-600">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>