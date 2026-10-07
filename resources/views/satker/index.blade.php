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

                        <a href="{{ route('satker.create') }}"
                        class="bg-blue-600 text-white px-4 py-2 rounded">
                            Tambah Satker
                        </a>

                    </div>

                    @if(session('success'))
                        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">
                                    No
                                </th>

                                <th class="border px-4 py-2">
                                    Kode Satker
                                </th>

                                <th class="border px-4 py-2">
                                    Nama Satker
                                </th>

                                <th class="border px-4 py-2">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($satkers as $satker)
                                <tr>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $satker->kode_satker }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $satker->nama_satker }}
                                    </td>

                                    <td class="border px-4 py-2">

                                        <a href="{{ route('satker.edit', $satker->id) }}" class="text-blue-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('satker.destroy', $satker->id) }}" method="POST"
                                            class="inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-red-600 ml-3"
                                                onclick="return confirm('Hapus data?')">

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
    </div>

</x-app-layout>
