<nav class="bg-white border-b border-gray-100">

    <div class="max-w-full mx-auto px-6">
        <div class="flex justify-between h-16">

            {{-- Left Section --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-gray-800">
                    SIPERDIN
                </a>
            </div>


            {{-- Right Section --}}
            <div class="flex items-center">

                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">

                            <div class="text-right mr-3">
                                <div>
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    {{ Auth::user()->getRoleNames()->first() }}
                                </div>
                            </div>

                            <div>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>

                        </button>
                    </x-slot>


                    <x-slot name="content">

                        {{-- Profile --}}
                        <x-dropdown-link href="{{ route('profile.edit') }}">
                            Profil
                        </x-dropdown-link>


                        {{-- Logout --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>

                        </form>

                    </x-slot>

                </x-dropdown>

            </div>

        </div>
    </div>

</nav>
