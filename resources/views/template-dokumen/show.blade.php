
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Detail Template Dokumen
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-6">
                    Informasi Template
                </h3>

                <div class="space-y-5">

                    <div>
                        <label class="text-sm font-medium text-gray-500">
                            Nama Template
                        </label>
                        <p class="text-gray-800">
                            {{ $templateDokumen->nama_template }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">
                            Jenis Dokumen
                        </label>
                        <p class="text-gray-800">
                            {{ $templateDokumen->jenis_dokumen }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">
                            Format File
                        </label>
                        <p class="text-gray-800">
                            {{ $templateDokumen->format_file ?? '—' }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">
                            Struktur Dokumen
                        </label>
                        <div class="mt-1 p-3 bg-gray-50 rounded whitespace-pre-wrap">
                            {{ $templateDokumen->struktur_dokumen ?? 'Belum tersedia.' }}
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">
                            Aturan Penomoran
                        </label>
                        <div class="mt-1 p-3 bg-gray-50 rounded whitespace-pre-wrap">
                            {{ $templateDokumen->aturan_penomoran ?? 'Belum tersedia.' }}
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500">
                            Lokasi Template
                        </label>
                        <p class="text-gray-800 break-all">
                            {{ $templateDokumen->lokasi_template ?? '—' }}
                        </p>
                    </div>

                </div>

                <div class="mt-6 flex gap-3">

                    <a href="{{ route('template-dokumen.edit', $templateDokumen) }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded">
                        Edit
                    </a>

                    <a href="{{ route('template-dokumen.index') }}"
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded">
                        Kembali
                    </a>

                </div>

            </div>
        </div>
    </div>

</x-app-layout>
