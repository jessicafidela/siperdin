
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Satuan Kerja
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">
                            Daftar Satuan Kerja
                        </h3>

                        <a href="{{ route('satuan-kerja.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            + Tambah Satker
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-800">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse border border-gray-300">

                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-4 py-3">No</th>
                                    <th class="border px-4 py-3">Kode Satker</th>
                                    <th class="border px-4 py-3">Nama Satker</th>
                                    <th class="border px-4 py-3">Status</th>
                                    <th class="border px-4 py-3">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse ($satuanKerjas as $satuanKerja)

                                    <tr class="hover:bg-gray-50">

                                        <td class="border px-4 py-3 text-center">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="border px-4 py-3">
                                            {{ $satuanKerja->kode_satker }}
                                        </td>

                                        <td class="border px-4 py-3">
                                            {{ $satuanKerja->nama_satker }}
                                        </td>

                                        <td class="border px-4 py-3 text-center">
                                            @if(strtolower($satuanKerja->status) === 'aktif')
                                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border px-4 py-3 text-center whitespace-nowrap">

                                            <a href="{{ route('satuan-kerja.edit', $satuanKerja->id_satker) }}"
                                               class="text-blue-600 hover:text-blue-800">
                                                Edit
                                            </a>

                                            <form action="{{ route('satuan-kerja.destroy', $satuanKerja->id_satker) }}"
                                                  method="POST"
                                                  class="inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-600 hover:text-red-800 ml-3"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data satuan kerja ini?')">
                                                    Hapus
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5" class="border px-4 py-6 text-center text-gray-500">
                                            Belum ada data satuan kerja.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
