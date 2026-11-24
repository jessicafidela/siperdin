
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Tempat
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Perbarui Informasi Tempat
                </h3>

                <form action="{{ route('tempat.update', $tempat->id_tempat) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- Nama Tempat --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Nama Tempat <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="nama_tempat"
                               value="{{ old('nama_tempat', $tempat->nama_tempat) }}"
                               required
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm">

                        @error('nama_tempat')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Jenis Tempat --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Jenis Tempat
                        </label>

                        <input type="text"
                               name="jenis_tempat"
                               value="{{ old('jenis_tempat', $tempat->jenis_tempat) }}"
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm">

                        @error('jenis_tempat')
                            <p class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Wilayah --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium text-gray-700">
                            Wilayah
                        </label>

                        <input type="text"
                               name="wilayah"
                               value="{{ old('wilayah', $tempat->wilayah) }}"
                               class="mt-1 block w-full rounded border-gray-300 shadow-sm">

                        @error('wilayah')
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
                                  class="mt-1 block w-full rounded border-gray-300 shadow-sm">{{ old('keterangan', $tempat->keterangan) }}</textarea>

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

                            <option value="aktif"
                                {{ old('status', $tempat->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif
                            </option>

                            <option value="nonaktif"
                                {{ old('status', $tempat->status) == 'nonaktif' ? 'selected' : '' }}>
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
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('tempat.index') }}"
                           class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>
