<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full container mx-auto flex-1 flex-col gap-4 rounded-xl p-10" x-data="realTime()">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div
                class="w-full bg-[#6366f1] rounded-3xl p-10 md:p-14 flex flex-col md:flex-row items-center justify-between gap-10">
                <!-- LEFT TEXT -->
                <div class="flex-1 text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">
                        Selamat Datang
                    </h1>

                    <p class="text-white/90 max-w-md leading-relaxed mb-6">
                        Do consectetur proident proident id eiusmod deserunt consequat pariatur ad ex velit
                        do Lorem reprehenderit.
                    </p>

                    <!-- Date Badge -->
                    <div class="inline-block bg-white text-gray-600 text-sm px-4 py-2 rounded-lg shadow-sm"
                        x-text="time">
                        15 November 2025 12 : 04 : 00
                    </div>
                </div>

                <!-- LOGO -->
                <div class="flex-1 flex justify-center md:justify-end">
                    <img src="{{ asset('images/logo-polkam.png') }}" class="w-60 md:w-80 drop-shadow-lg"
                        alt="Logo Politeknik Kampar" />
                </div>
            </div>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-4">
            <div
                class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 relative">
                <!-- Konten kiri -->
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Jumlah Dosen</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-1">300</p>
                </div>
                <!-- Ikon kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </div>
            <div
                class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 relative">
                <!-- Konten kiri -->
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Program Studi</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-1">300</p>
                </div>
                <!-- Ikon kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </div>
            <div
                class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 relative">
                <!-- Konten kiri -->
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Kontrak Kuliah</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-1">300</p>
                </div>
                <!-- Ikon kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </div>
            <div
                class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-gray-100 relative">
                <!-- Konten kiri -->
                <div class="ml-4">
                    <p class="text-sm text-gray-500">RPS</p>
                    <p class="text-3xl font-semibold text-gray-900 mt-1">300</p>
                </div>
                <!-- Ikon kanan -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-16">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>

            </div>
        </div>
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
