
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Standar Biaya Masukan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('standar-biaya-masukan.update', $standarBiayaMasukan->id_sbm) }}"
                    method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Tahun Berlaku</label>
                        <input type="number" name="tahun_berlaku"
                            value="{{ old('tahun_berlaku', $standarBiayaMasukan->tahun_berlaku) }}"
                            min="1901" max="2155"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('tahun_berlaku')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Jenis Biaya</label>
                        <input type="text" name="jenis_biaya"
                            value="{{ old('jenis_biaya', $standarBiayaMasukan->jenis_biaya) }}"
                            maxlength="50"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('jenis_biaya')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Golongan Ruang</label>
                        <input type="text" name="gol_ruang"
                            value="{{ old('gol_ruang', $standarBiayaMasukan->gol_ruang) }}"
                            maxlength="20"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('gol_ruang')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Lokasi</label>
                        <input type="text" name="lokasi"
                            value="{{ old('lokasi', $standarBiayaMasukan->lokasi) }}"
                            maxlength="100"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('lokasi')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nilai Biaya (Rp)</label>
                        <input type="number" name="nilai_biaya"
                            value="{{ old('nilai_biaya', $standarBiayaMasukan->nilai_biaya) }}"
                            step="0.01" min="0"
                            class="mt-1 block w-full rounded border-gray-300">

                        @error('nilai_biaya')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium">Keterangan</label>
                        <textarea name="keterangan"
                            class="mt-1 block w-full rounded border-gray-300">{{ old('keterangan', $standarBiayaMasukan->keterangan) }}</textarea>

                        @error('keterangan')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                        Update
                    </button>

                    <a href="{{ route('standar-biaya-masukan.index') }}"
                        class="ml-3 text-gray-600">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>
