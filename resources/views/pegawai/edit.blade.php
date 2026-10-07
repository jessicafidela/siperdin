<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Pegawai
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Satker --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Satuan Kerja</label>

                        <select name="satker_id" class="mt-1 block w-full rounded border-gray-300">
                            @foreach ($satkers as $satker)
                                <option value="{{ $satker->id }}" {{ old('satker_id', $pegawai->satker_id) == $satker->id ? 'selected' : '' }}>
                                    {{ $satker->nama_satker }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- NIP --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">NIP</label>

                        <input type="text" name="nip" value="{{ old('nip', $pegawai->nip) }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Nama Pegawai</label>

                        <input type="text" name="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>

                    {{-- Jabatan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Jabatan</label>

                        <input type="text" name="jabatan" value="{{ old('jabatan', $pegawai->jabatan) }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>

                    {{-- Golongan --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium">Golongan</label>

                        <input type="text" name="golongan" value="{{ old('golongan', $pegawai->golongan) }}" class="mt-1 block w-full rounded border-gray-300">
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Update
                    </button>

                    <a href="{{ route('pegawai.index') }}" class="ml-3 text-gray-600">
                        Kembali
                    </a>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>