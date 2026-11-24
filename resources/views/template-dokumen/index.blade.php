
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Manajemen Template Dokumen
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
                        Daftar Template Dokumen
                    </h3>

                    <a href="{{ route('template-dokumen.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded">
                        + Tambah Template
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Nama Template</th>
                                <th class="border px-4 py-2">Jenis Dokumen</th>
                                <th class="border px-4 py-2">Format</th>
                                <th class="border px-4 py-2">Lokasi Template</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($templateDokumens as $templateDokumen)
                                <tr>
                                    <td class="border px-4 py-2 text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $templateDokumen->nama_template }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $templateDokumen->jenis_dokumen }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $templateDokumen->format_file ?? '—' }}
                                    </td>

                                    <td class="border px-4 py-2">
                                        {{ $templateDokumen->lokasi_template ?? '—' }}
                                    </td>

                                    <td class="border px-4 py-2 whitespace-nowrap">
                                        <a href="{{ route('template-dokumen.show', $templateDokumen) }}"
                                           class="text-green-600">
                                            Detail
                                        </a>

                                        <a href="{{ route('template-dokumen.edit', $templateDokumen) }}"
                                           class="text-blue-600 ml-2">
                                            Edit
                                        </a>

                                        <form action="{{ route('template-dokumen.destroy', $templateDokumen) }}"
                                              method="POST"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 ml-2"
                                                    onclick="return confirm('Hapus template dokumen ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="border px-4 py-4 text-center">
                                        Belum ada template dokumen.
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
