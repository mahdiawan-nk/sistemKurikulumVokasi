<x-layouts.app :title="$title ?? null">
    <div x-data="{ showSidebar: false }" class="relative flex w-full flex-col md:flex-row">
        <!-- This allows screen readers to skip the sidebar and go directly to the main content. -->
        <a class="sr-only" href="#main-content">skip to the main content</a>

        <!-- dark overlay for when the sidebar is open on smaller screens  -->
        <div x-cloak x-show="showSidebar" class="fixed inset-0 z-10 bg-neutral-950/10 backdrop-blur-xs md:hidden"
            aria-hidden="true" x-on:click="showSidebar = false" x-transition.opacity></div>

        <nav x-cloak
            class="fixed left-0 z-20 flex min-h-[85vh] w-60 shrink-0 flex-col border-r border-neutral-300 bg-neutral-50 p-4 transition-transform duration-300 md:w-87 md:max-w-xl md:translate-x-0 md:relative dark:border-neutral-700 dark:bg-neutral-900"
            x-bind:class="showSidebar ? 'translate-x-0' : '-translate-x-60'" aria-label="sidebar navigation">
            @php
                $menuMaster = [
                    [
                        'name' => 'Profile Lulusan',
                        'url' => route('master.pl.index'),
                        'active' => request()->routeIs('master.pl.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\ProfileLulusan::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Capaian Pembelajaran Lulusan',
                        'url' => route('master.cpl.index'),
                        'active' => request()->routeIs('master.cpl.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\CapaianPembelajaranLulusan::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Bahan Kajian',
                        'url' => route('master.bk.index'),
                        'active' => request()->routeIs('master.bk.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\BahanKajian::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Capaian Pembelajaran Matakuliah',
                        'url' => route('master.cpmk.index'),
                        'active' => request()->routeIs('master.cpmk.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\CapaianPembelajaranMatakuliah::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Sub Capaian Pembelajaran Matakuliah',
                        'url' => route('master.subcpmk.index'),
                        'active' => request()->routeIs('master.subcpmk.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\SubCapaianPembelajaranMatakuliah::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Matakuliah',
                        'url' => route('master.matkul.index'),
                        'active' => request()->routeIs('master.matkul.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\Matakuliah::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Program Studi',
                        'url' => route('master.program-studi.index'),
                        'active' => request()->routeIs('master.program-studi.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\ProgramStudi::class,
                        'block' => ['Dosen', 'WADIR 1', 'BPM', 'Direktur', 'Kaprodi'],
                    ],
                    [
                        'name' => 'Dosen',
                        'url' => route('master.dosen.index'),
                        'active' => request()->routeIs('master.dosen.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\Dosen::class,
                        'block' => ['Dosen'],
                    ],
                ];

                $menuPerangkatAjar = [
                    [
                        'name' => 'Dashboard',
                        'url' => route('perangkat-ajar.index'),
                        'active' => request()->routeIs('perangkat-ajar.index'),
                        'gate' => 'viewAny',
                        'models' => App\Models\KontrakKuliah::class,
                        'block' => [],
                    ],
                    [
                        'name' => 'Kontrak Kuliah',
                        'url' => route('perangkat-ajar.kontrak-kuliah.index'),
                        'active' => request()->routeIs('perangkat-ajar.kontrak-kuliah.*'),
                        'gate' => 'viewAny',
                        'models' => App\Models\KontrakKuliah::class,
                        'block' => [],
                    ],
                ];
            @endphp
            <!-- sidebar links  -->
            <div class="flex flex-col gap-2 overflow-y-auto pb-6">
                @if (request()->routeIs('master.*'))
                    @foreach ($menuMaster as $label => $item)
                        @can($item['gate'], [$item['models'], $item['block']])
                            <a href="{{ $item['url'] }}" wire:navigate
                                class="@activeClassSide($item['active']) flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium  underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>

                                <span>{{ $item['name'] }}</span>
                            </a>
                        @endcan
                    @endforeach
                @endif
                @if (request()->routeIs('perangkat-ajar.*'))
                    @foreach ($menuPerangkatAjar as $label => $item)
                        {{-- @can($item['gate'], [$item['models'], $item['block']]) --}}
                            <a href="{{ $item['url'] }}" wire:navigate
                                class="@activeClassSide($item['active']) flex items-center rounded-sm gap-2 px-2 py-1.5 text-sm font-medium  underline-offset-2 hover:bg-black/5 hover:text-neutral-900 focus-visible:underline focus:outline-hidden ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>

                                <span>{{ $item['name'] }}</span>
                            </a>
                        {{-- @endcan --}}
                    @endforeach
                @endif

            </div>
        </nav>

        <!-- main content  -->
        <div id="main-content" class="w-full overflow-y-auto p-4 bg-white dark:bg-zinc-800">
            {{-- @yield('content') --}}
            {{ $slot }}
        </div>

        <button
            class="fixed right-4 bottom-4 z-20 rounded-full bg-black p-4 md:hidden text-neutral-100 dark:bg-white dark:text-black"
            x-on:click="showSidebar = ! showSidebar">
            <svg x-show="showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                class="size-5" aria-hidden="true">
                <path
                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
            </svg>
            <svg x-show="! showSidebar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                class="size-5" aria-hidden="true">
                <path
                    d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm5-1v12h9a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zM4 2H2a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h2z" />
            </svg>
            <span class="sr-only">sidebar toggle</span>
        </button>
    </div>
</x-layouts.app>
