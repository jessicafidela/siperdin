<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Pegawai
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('pegawai.store') }}" method="POST">
                    @csrf

                    {{-- Satker --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Satuan Kerja
                        </label>

                        <select name="satker_id" class="mt-1 block w-full rounded border-gray-300">
                            <option value="">-- Pilih Satker --</option>

                            @foreach ($satkers as $satker)
                                <option value="{{ $satker->id }}" {{ old('satker_id') == $satker->id ? 'selected' : '' }}>
                                    {{ $satker->nama_satker }}
                                </option>
                            @endforeach

                        </select>

                        @error('satker_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            NIP
                        </label>

                        <input type="text" name="nip" value="{{ old('nip') }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('nip')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Nama Pegawai
                        </label>

                        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai') }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('nama_pegawai')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Jabatan
                        </label>

                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('jabatan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Golongan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">
                            Golongan
                        </label>

                        <input type="text" name="golongan" value="{{ old('golongan') }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('golongan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Simpan
                    </button>

                    <a href="{{ route('pegawai.index') }}" class="ml-3 text-gray-600">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>