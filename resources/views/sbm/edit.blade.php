<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit SBM
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('sbm.update', $sbm->id) }}" method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Kode SBM --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Kode SBM</label>

                        <input type="text" name="kode_sbm" value="{{ old('kode_sbm', $sbm->kode_sbm) }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('kode_sbm')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Kategori</label>

                        <input type="text" name="kategori" value="{{ old('kategori', $sbm->kategori) }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('kategori')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Biaya --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nama Biaya</label>

                        <input type="text" name="nama_biaya" value="{{ old('nama_biaya', $sbm->nama_biaya) }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('nama_biaya')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Satuan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Satuan</label>

                        <input type="text" name="satuan" value="{{ old('satuan', $sbm->satuan) }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('satuan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nilai --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nilai</label>

                        <input type="number" name="nilai" value="{{ old('nilai', $sbm->nilai) }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('nilai')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jenis Batas --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Jenis Batas</label>

                        <select name="jenis_batas" class="mt-1 block w-full rounded border-gray-300">

                            <option value="batas_tertinggi" {{ old('jenis_batas', $sbm->jenis_batas) == 'batas_tertinggi' ? 'selected' : '' }}>
                                Batas Tertinggi
                            </option>

                            <option value="dapat_dilampaui" {{ old('jenis_batas', $sbm->jenis_batas) == 'dapat_dilampaui' ? 'selected' : '' }}>
                                Dapat Dilampaui
                            </option>

                        </select>

                        @error('jenis_batas')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tahun Anggaran --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Tahun Anggaran</label>

                        <input type="number" name="tahun_anggaran" value="{{ old('tahun_anggaran', $sbm->tahun_anggaran) }}" class="mt-1 block w-full rounded border-gray-300">

                        @error('tahun_anggaran')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Update
                    </button>

                    <a href="{{ route('sbm.index') }}" class="ml-3 text-gray-600">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>