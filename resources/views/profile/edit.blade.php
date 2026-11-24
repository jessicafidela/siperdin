<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Akun
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900">Informasi Akun</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Identitas akun dan data kepegawaian dikelola oleh administrator SIPD.
                </p>

                <dl class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <dt class="text-sm text-gray-500">Username</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $user->username }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Nama lengkap</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $user->pegawai?->nama_lengkap ?? 'Belum terhubung dengan data pegawai' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">NIP</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $user->pegawai?->nip_baru ?? $user->pegawai?->nip ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Satuan kerja</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $user->pegawai?->satuanKerja?->nama_satker ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Role</dt>
                        <dd class="mt-1 font-medium text-gray-900">
                            {{ $roles->isNotEmpty() ? $roles->implode(', ') : 'Belum ditetapkan' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Status akun</dt>
                        <dd class="mt-1 font-medium {{ $user->isActive() ? 'text-green-700' : 'text-red-700' }}">
                            {{ ucfirst($user->status) }}
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
