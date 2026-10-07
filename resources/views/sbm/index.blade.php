<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data SBM
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

                    <a href="{{ route('sbm.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Tambah SBM
                    </a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Kode</th>
                            <th class="border px-4 py-2">Kategori</th>
                            <th class="border px-4 py-2">Nama Biaya</th>
                            <th class="border px-4 py-2">Nilai</th>
                            <th class="border px-4 py-2">Tahun</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sbms as $sbm)

                            <tr>
                                <td class="border px-4 py-2 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sbm->kode_sbm }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sbm->kategori }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $sbm->nama_biaya }}
                                </td>

                                <td class="border px-4 py-2">
                                    Rp {{ number_format($sbm->nilai, 0, ',', '.') }}
                                </td>

                                <td class="border px-4 py-2 text-center">
                                    {{ $sbm->tahun_anggaran }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ ucfirst($sbm->status) }}
                                </td>
                                
                                <td class="border px-4 py-2">

                                    <a href="{{ route('sbm.edit', $sbm->id) }}" class="text-blue-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('sbm.destroy', $sbm->id) }}" method="POST" class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600 ml-3" onclick="return confirm('Nonaktifkan SBM ini?')">
                                            Nonaktifkan
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="border px-4 py-4 text-center">
                                    Belum ada data.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</x-app-layout>