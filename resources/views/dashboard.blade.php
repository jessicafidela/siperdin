<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <h2>
                Dashboard SIPERDIN
            </h2>


            @role('Superadmin')
                <p>
                    Selamat datang Superadmin.
                </p>
            @endrole


            @role('Operator Data')
                <p>
                    Selamat datang Operator Data.
                </p>
            @endrole


            @role('Operator Satker')
                <p>
                    Selamat datang Operator Satker.
                </p>
            @endrole


            @role('Admin Keuangan')
                <p>
                    Selamat datang Admin Keuangan.
                </p>
            @endrole


        </div>
    </div>

</x-app-layout>
