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

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        Daftar Tempat
                    </h3>

                    <a href="{{ route('place.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Tambah Tempat
                    </a>
                </div>

                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Nama Tempat</th>
                            <th class="border px-4 py-2">Provinsi</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($places as $place)

                            <tr>
                                <td class="border px-4 py-2 text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $place->nama_tempat }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $place->provinsi }}
                                </td>

                                <td class="border px-4 py-2">

                                    <a href="{{ route('place.edit', $place->id) }}" class="text-blue-600">
                                        Edit
                                    </a>

                                    <form action="{{ route('place.destroy', $place->id) }}" method="POST" class="inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="text-red-600 ml-3" onclick="return confirm('Hapus data tempat?')">
                                            Hapus
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="border px-4 py-4 text-center">
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