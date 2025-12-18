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
        <div x-data="{ open: false }" class="relative">
            <!-- Mobile: Photo Only -->
            <button @click="open = !open"
                class="md:hidden flex items-center w-10 h-10 rounded-full overflow-hidden border border-neutral-200">
                <img src="{{ asset('images/logo-polkam.png') }}" class="object-cover w-full h-full">
            </button>

            <!-- Desktop: Photo + Name + Email -->
            <button @click="open = !open"
                class="hidden md:flex items-center py-2 pr-12 pl-3 h-12 text-sm font-medium transition-colors text-neutral-700">

                <img src="{{ asset('images/logo-polkam.png') }}"
                    class="object-cover w-8 h-8 rounded-full border border-neutral-200" />

                <span class="flex flex-col ml-2 leading-none">
                    <span>{{ auth()->user()->name }}</span>
                    <span class="text-xs font-light text-neutral-800">{{ auth()->user()->email }}</span>
                </span>

                <svg class="absolute right-0 mr-3 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                </svg>
            </button>

            <!-- DROPDOWN -->
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 mt-3 w-56 rounded-md bg-white shadow-md border border-neutral-200/70 p-1 z-50"
                x-cloak>

                <div class="px-2 py-1.5 text-sm font-semibold">My Account</div>
                <div class="h-px bg-neutral-200 my-1"></div>

                <a href="{{ route('profile.edit') }}" wire:navigate
                    class="flex items-center px-2 py-1.5 text-sm rounded hover:bg-neutral-100">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                        stroke="currentColor" stroke-width="2" class="mr-2">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    Profile
                </a>

                <div class="h-px bg-neutral-200 my-1"></div>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center px-2 py-1.5 text-sm rounded hover:bg-neutral-100">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            stroke="currentColor" stroke-width="2" class="mr-2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" x2="9" y1="12" y2="12"></line>
                        </svg>
                        Log out
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>
