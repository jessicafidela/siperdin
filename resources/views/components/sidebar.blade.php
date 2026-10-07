<aside class="w-64 bg-white border-r min-h-screen">

    {{-- Application Identity --}}
    <div class="p-6 border-b">
        <h1 class="text-xl font-bold">
            SIPERDIN
        </h1>

        <p class="text-sm text-gray-500">
            Sistem Informasi Perjalanan Dinas
        </p>
    </div>

    {{-- Navigation Menu --}}
    <nav class="p-4 space-y-2">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-100">
            Dashboard
        </a>

        {{-- Master Data --}}
        @can('view master data')
            <div class="mt-4">

                <p class="text-xs uppercase text-gray-500 mb-2">
                    Master Data
                </p>

                <a href="{{ route('pegawai.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Data Pegawai
                </a>

                <a href="{{ route('satker.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Data Satuan Kerja
                </a>

                <a href="{{ route('place.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Data Tempat
                </a>

                <a href="{{ route('sbm.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Data SBM
                </a>

            </div>
        @endcan

        {{-- Perjalanan Dinas --}}
        @can('view own travel')
            <div class="mt-4">

                <p class="text-xs uppercase text-gray-500 mb-2">
                    Perjalanan Dinas
                </p>

                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Perjalanan Saya
                </a>

                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Buat Perjalanan
                </a>

            </div>
        @endcan

        {{-- Monitoring --}}
        @can('view all travel')
            <div class="mt-4">

                <p class="text-xs uppercase text-gray-500 mb-2">
                    Monitoring
                </p>

                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Semua Perjalanan
                </a>

            </div>
        @endcan

        {{-- Keuangan --}}
        @can('verify travel')
            <div class="mt-4">

                <p class="text-xs uppercase text-gray-500 mb-2">
                    Keuangan
                </p>

                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Pengajuan Masuk
                </a>

                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Verifikasi
                </a>

            </div>
        @endcan

        {{-- User Management --}}
        @can('view users')
            <div class="mt-4">

                <p class="text-xs uppercase text-gray-500 mb-2">
                    Pengaturan
                </p>

                <a href="{{ route('user.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100">
                    Manajemen Pengguna
                </a>

            </div>
        @endcan

    </nav>

</aside>
