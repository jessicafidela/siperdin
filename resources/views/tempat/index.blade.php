
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Tempat
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

                @if(session('error'))
                    <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-4">

                    <h3 class="text-lg font-semibold">
                        Daftar Tempat
                    </h3>

                    <a href="{{ route('tempat.create') }}"
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                        + Tambah Tempat
                    </a>

                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300">

                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama Tempat</th>
                                <th class="border px-4 py-2">Jenis Tempat</th>
                                <th class="border px-4 py-2">Wilayah</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($tempats as $tempat)

                                <tr class="hover:bg-gray-50">

                                    <td class="border px-4 py-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $tempat->nama_tempat }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $tempat->jenis_tempat ?? '—' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $tempat->wilayah ?? '—' }}
                                    </td>

                                    <td class="border px-4 py-2 text-center">
                                        @if(strtolower($tempat->status ?? '') === 'aktif')
                                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="border px-4 py-2 text-center whitespace-nowrap">

                                        <a href="{{ route('tempat.edit', $tempat->id_tempat) }}"
                                           class="text-blue-600 hover:text-blue-800">
                                            Edit
                                        </a>

                                        <form action="{{ route('tempat.destroy', $tempat->id_tempat) }}"
                                              method="POST"
                                              class="inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 ml-3"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data tempat ini?')">
                                                Hapus
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="border px-4 py-4 text-center text-gray-500">
                                        Belum ada data tempat.
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
