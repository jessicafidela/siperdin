
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Standar Biaya Masukan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        Daftar SBM
                    </h3>

                    <a href="{{ route('standar-biaya-masukan.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded">
                        Tambah SBM
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Tahun</th>
                                <th class="border px-4 py-2">Jenis Biaya</th>
                                <th class="border px-4 py-2">Golongan</th>
                                <th class="border px-4 py-2">Lokasi</th>
                                <th class="border px-4 py-2">Nilai Biaya</th>
                                <th class="border px-4 py-2">Keterangan</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sbms as $sbm)
                                <tr>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-4 py-2 text-center">
                                        {{ $sbm->tahun_berlaku }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $sbm->jenis_biaya }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $sbm->gol_ruang ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $sbm->lokasi ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2 text-right">
                                        Rp {{ number_format((float) $sbm->nilai_biaya, 2, ',', '.') }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $sbm->keterangan ?? '-' }}
                                    </td>

                                    <td class="border px-4 py-2 whitespace-nowrap">

                                        <a href="{{ route('standar-biaya-masukan.edit', $sbm->id_sbm) }}"
                                            class="text-blue-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('standar-biaya-masukan.destroy', $sbm->id_sbm) }}"
                                            method="POST" class="inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="text-red-600 ml-3"
                                                onclick="return confirm('Yakin ingin menghapus data SBM ini?')">
                                                Hapus
                                            </button>

                                        </form>

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="border px-4 py-4 text-center">
                                        Belum ada data SBM.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
