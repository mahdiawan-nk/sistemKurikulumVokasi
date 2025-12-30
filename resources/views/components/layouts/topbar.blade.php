<section class="relative w-full px-4 py-2 bg-[#efb034] text-gray-700" data-tails-scripts="//unpkg.com/alpinejs">
    <div class="container mx-auto max-w-7xl flex items-center justify-between">

        <!-- BRAND -->
        <a href="#_" class="flex items-center space-x-2 font-extrabold select-none text-black">

            <!-- Mobile: Logo Only -->
            <img src="{{ asset('images/logo-polkam.png') }}" class="w-10 h-10 object-cover rounded-md md:hidden">

            <!-- Desktop: Logo + Brand Name -->
            <span class="hidden md:flex items-center space-x-2 text-2xl">
                <img src="{{ asset('images/logo-polkam.png') }}" class="w-10 h-10 rounded-md">
                <span>Politeknik Kampar</span>
            </span>
        </a>

        <!-- USER MENU -->
        <div x-data="{ open: false }" class="relative font-sans">
            <button @click="open = !open"
                class="group flex items-center gap-3 p-1.5 rounded-full md:rounded-lg transition-all duration-200 hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-200"
                :class="open ? 'bg-neutral-100' : ''">

                <div class="relative w-9 h-9">
                    <img src="{{ asset('images/logo-polkam.png') }}"
                        class="w-full h-full object-cover rounded-full border border-neutral-200 shadow-sm"
                        alt="Profile">
                    <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full">
                    </div>
                </div>

                <div class="hidden md:flex flex-col text-left leading-tight min-w-[100px]">
                    <span class="text-sm font-semibold text-neutral-800 tracking-tight">
                        {{ auth()->user()->name }}
                    </span>
                    <span class="text-[11px] font-medium text-neutral-500 uppercase tracking-wider">
                        {{ session('active_role', 'No Role') }}
                    </span>
                </div>

                <svg class="hidden md:block w-4 h-4 text-neutral-400 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.away="open = false" x-cloak x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-64 rounded-xl bg-white shadow-xl border border-neutral-200/60 p-2 z-50">

                <div class="px-3 py-2 mb-1">
                    <p class="text-xs font-semibold text-neutral-400 uppercase tracking-widest">Account</p>
                </div>

                <div class="space-y-1 mb-2">
                   <livewire:actions.switch-roles />
                </div>

                <div class="h-px bg-neutral-100 mx-2 mb-2"></div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}" wire:navigate
                        class="flex items-center px-3 py-2 text-sm text-neutral-600 rounded-lg hover:bg-neutral-50 transition-colors group">
                        <svg class="w-4 h-4 mr-3 text-neutral-400 group-hover:text-neutral-600" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Manage Profile
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex w-full items-center px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 transition-colors group">
                            <svg class="w-4 h-4 mr-3 text-red-400 group-hover:text-red-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
