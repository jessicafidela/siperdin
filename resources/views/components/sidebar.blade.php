<aside class="w-64 bg-white border-r min-h-screen shrink-0">
    <div class="p-6 border-b">
        <h1 class="text-xl font-bold text-gray-900">SIPERDIN</h1>
        <p class="text-sm text-gray-500">Sistem Informasi Perjalanan Dinas</p>
    </div>

    <nav class="p-4 space-y-2" aria-label="Navigasi utama">
        @can('dashboard.view')
            <a href="{{ route('dashboard') }}"
               class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                Dashboard
            </a>
        @endcan

        @can('master-data.view')
            <div class="mt-5 space-y-1">
                <p class="px-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Data Master
                </p>
                <a href="{{ route('satuan-kerja.index') }}" class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Data Satuan Kerja
                </a>
                <a href="{{ route('pegawai.index') }}" class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Data Pegawai
                </a>
                <a href="{{ route('tempat.index') }}" class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Data Tempat
                </a>
                <a href="{{ route('standar-biaya-masukan.index') }}" class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Standar Biaya Masukan
                </a>
                <a href="{{ route('template-dokumen.index') }}" class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Template Dokumen
                </a>
            </div>
        @endcan

        @can('users.view')
            <div class="mt-5 space-y-1">
                <p class="px-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Administrasi Sistem
                </p>
                <a href="{{ route('user.index') }}" class="block rounded px-4 py-2 text-gray-700 hover:bg-gray-100">
                    Manajemen Pengguna
                </a>
            </div>
        @endcan

        @can('travel.grouping.view')
            <div class="mt-5 space-y-1">
                <p class="px-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Perjalanan Dinas
                </p>
                <span class="block rounded px-4 py-2 text-gray-400" aria-disabled="true">
                    Pengelolaan Perjalanan Dinas — modul berikutnya
                </span>
                <span class="block rounded px-4 py-2 text-gray-400" aria-disabled="true">
                    Dokumen dan Pertanggungjawaban — modul berikutnya
                </span>
            </div>
        @endcan

        @can('submissions.view')
            <div class="mt-5 space-y-1">
                <p class="px-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Keuangan
                </p>
                <span class="block rounded px-4 py-2 text-gray-400" aria-disabled="true">
                    Verifikasi dan Pencairan — modul berikutnya
                </span>
            </div>
        @endcan

        @can('travel.monitor.all')
            <div class="mt-5 space-y-1">
                <p class="px-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Monitoring dan Audit
                </p>
                <span class="block rounded px-4 py-2 text-gray-400" aria-disabled="true">
                    Monitoring Lintas Satker — modul berikutnya
                </span>
                @can('activity-log.view')
                    <span class="block rounded px-4 py-2 text-gray-400" aria-disabled="true">
                        Riwayat Aktivitas — modul berikutnya
                    </span>
                @endcan
            </div>
        @elsecan('travel.monitor.satker')
            <div class="mt-5 space-y-1">
                <p class="px-4 pb-1 text-xs font-semibold uppercase tracking-wide text-gray-500">
                    Monitoring
                </p>
                <span class="block rounded px-4 py-2 text-gray-400" aria-disabled="true">
                    Monitoring Satker — modul berikutnya
                </span>
            </div>
        @endcan
    </nav>
</aside>
