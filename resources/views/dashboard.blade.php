<x-layouts.app :title="__('Dashboard')">
    <div class="container mx-auto px-4 py-6" x-data="realTime()">
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-500 
           dark:from-indigo-700 dark:to-indigo-600 p-8 md:p-12 shadow-lg">

            <div class="flex flex-col md:flex-row items-center gap-10">
                <!-- TEXT -->
                <div class="flex-1 text-white">
                    <h1 class="text-3xl md:text-4xl font-bold mb-3">
                        Dashboard e-Kurikulum
                    </h1>

                    <p class="text-white/90 max-w-xl leading-relaxed mb-6">
                        Terwujudnya Politeknik yang Unggul, Inovatif dan Terkemuka Berbasis Teknologi Terapan pada Tahun
                        2032"


                    </p>

                    <div class="inline-flex items-center gap-2 bg-white/90 text-gray-700 
                       dark:bg-gray-900 dark:text-gray-200
                       text-sm px-4 py-2 rounded-lg shadow"
                        x-text="time">
                    </div>
                </div>

                <!-- LOGO -->
                <div class="flex-1 flex justify-center md:justify-end">
                    <img src="{{ asset('images/logo-polkam.png') }}" class="w-44 md:w-60 drop-shadow-xl"
                        alt="Logo Politeknik Kampar">
                </div>
            </div>
        </div>

        <livewire:widget.crad-statistik />
        {{-- <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-2 gap-4">
            <div
                class="flex items-center gap-4 rounded-xl bg-white dark:bg-gray-800
           border border-gray-100 dark:border-gray-700
           p-5 shadow-sm hover:shadow-md transition">

                <!-- Icon -->
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg
               bg-indigo-50 text-indigo-600
               dark:bg-indigo-900/40 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 6.75a3 3 0 1 1-6 0
                     3 3 0 0 1 6 0ZM19.5 20.25
                     a7.5 7.5 0 0 0-15 0" />
                    </svg>
                </div>

                <!-- Text -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Jumlah Dosen
                    </p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                        300
                    </p>
                </div>
            </div>

            <div
                class="flex items-center gap-4 rounded-xl bg-white dark:bg-gray-800
           border border-gray-100 dark:border-gray-700
           p-5 shadow-sm hover:shadow-md transition">

                <!-- Icon -->
                <div
                    class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg
               bg-indigo-50 text-indigo-600
               dark:bg-indigo-900/40 dark:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 19.5h15M4.5 15h15M6 10.5h12M7.5 6h9" />
                    </svg>
                </div>

                <!-- Text -->
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Program Studi
                    </p>
                    <p class="text-3xl font-semibold text-gray-900 dark:text-white">
                        12
                    </p>
                </div>
            </div>

            <div
                class="flex flex-col justify-between rounded-xl bg-white dark:bg-gray-800
           border border-gray-100 dark:border-gray-700 p-5 shadow-sm
           hover:shadow-md transition">

                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total Kurikulum
                        </p>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-white mt-1">
                            300
                        </p>
                    </div>

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-lg
                   bg-indigo-50 text-indigo-600
                   dark:bg-indigo-900/40 dark:text-indigo-400">
                        <!-- Icon Kurikulum -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.966 8.966 0 0 0 3 3.75v14.25A8.966 8.966 0 0 1 12 20.25
                         a8.966 8.966 0 0 1 9-2.25V3.75
                         A8.966 8.966 0 0 0 12 6.042Z" />
                        </svg>
                    </div>
                </div>

                <!-- Status Breakdown -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-2 text-sm">

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300">
                            Published
                        </span>
                        <span class="font-medium text-green-600 dark:text-green-400">
                            180
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300">
                            Draft
                        </span>
                        <span class="font-medium text-yellow-600 dark:text-yellow-400">
                            90
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-gray-600 dark:text-gray-300">
                            Archived
                        </span>
                        <span class="font-medium text-gray-500 dark:text-gray-400">
                            30
                        </span>
                    </div>

                </div>
            </div>

            <div
                class="flex flex-col justify-between rounded-xl bg-white dark:bg-gray-800
           border border-gray-100 dark:border-gray-700 p-5 shadow-sm
           hover:shadow-md transition">

                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total Perangkat Ajar
                        </p>
                        <p class="text-3xl font-semibold text-gray-900 dark:text-white mt-1">
                            300
                        </p>
                    </div>

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-lg
                   bg-indigo-50 text-indigo-600
                   dark:bg-indigo-900/40 dark:text-indigo-400">
                        <!-- Icon Academic -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.966 8.966 0 0 0 3 3.75v14.25A8.966 8.966 0 0 1 12 20.25
                         a8.966 8.966 0 0 1 9-2.25V3.75
                         A8.966 8.966 0 0 0 12 6.042Z" />
                        </svg>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600 dark:text-gray-300">
                        <span>RPS</span>
                        <span class="font-medium">120</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-300">
                        <span>Kontrak Kuliah</span>
                        <span class="font-medium">100</span>
                    </div>
                    <div class="flex justify-between text-gray-600 dark:text-gray-300">
                        <span>RS</span>
                        <span class="font-medium">80</span>
                    </div>
                </div>
            </div>

        </div> --}}
    </div>
    <script>
        function realTime() {
            return {
                time: '',
                timer: null,

                init() {
                    this.updateTime();

                    // Cegah double interval saat Alpine reload
                    if (this.timer) clearInterval(this.timer);

                    this.timer = setInterval(() => {
                        this.updateTime();
                    }, 1000);
                },

                updateTime() {
                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];

                    const d = new Date();

                    const day = String(d.getDate()).padStart(2, '0');
                    const month = months[d.getMonth()];
                    const year = d.getFullYear();

                    const hh = String(d.getHours()).padStart(2, '0');
                    const mm = String(d.getMinutes()).padStart(2, '0');
                    const ss = String(d.getSeconds()).padStart(2, '0');

                    this.time = `${day} ${month} ${year}   ${hh} : ${mm} : ${ss}`;
                }
            };
        }
    </script>

</x-layouts.app>
