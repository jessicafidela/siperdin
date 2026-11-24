<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Pegawai
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

                {{-- Header --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        Daftar Pegawai
                    </h3>

                    <a href="{{ route('pegawai.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded">
                        Tambah Pegawai
                    </a>
                </div>

                {{-- Table --}}
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">NIP</th>
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Satker</th>
                            <th class="border px-4 py-2">Jabatan</th>
                            <th class="border px-4 py-2">Golongan</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
<tbody>
    @forelse ($pegawais as $pegawai)
        <tr>
            <td class="border px-4 py-2 text-center">
                {{ $loop->iteration }}
            </td>

            <td class="border px-4 py-2">
                {{ $pegawai->nip }}
            </td>

            <td class="border px-4 py-2">
                {{ $pegawai->nama_lengkap }}
            </td>

            <td class="border px-4 py-2">
                {{ $pegawai->satuanKerja?->nama_satker ?? '—' }}
            </td>

            <td class="border px-4 py-2">
                {{ $pegawai->tampil_jabatan ?? '—' }}
            </td>

            <td class="border px-4 py-2">
                {{ $pegawai->gol_ruang ?? '—' }}
            </td>

            <td class="border px-4 py-2">

                <a href="{{ route('pegawai.edit', $pegawai->id_pegawai) }}"
                   class="text-blue-600">
                    Edit
                </a>

                <form action="{{ route('pegawai.destroy', $pegawai->id_pegawai) }}"
                      method="POST"
                      class="inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="text-red-600 ml-3"
                            onclick="return confirm('Hapus data pegawai?')">
                        Hapus
                    </button>

                </form>

            </td>
        </tr>

    @empty

        <tr>
            <td colspan="7" class="border px-4 py-4 text-center">
                Belum ada data pegawai.
            </td>
        </tr>

    @endforelse
</tbody>
                </table>

            </div>
        </div>
    </div>

</x-app-layout>