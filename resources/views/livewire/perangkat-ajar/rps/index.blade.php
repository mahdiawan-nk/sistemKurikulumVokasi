<div class="flex flex-col gap-2">

    <x-card title="Identitas Matakuliah">
        <div class="space-y-4 text-sm">

            <!-- Mata Kuliah -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2 items-start">
                <div class="md:col-span-3 font-medium text-neutral-600 dark:text-neutral-300">
                    Mata Kuliah
                </div>
                <div class="md:col-span-9 flex gap-2 items-center">
                    <span class="hidden md:block text-neutral-400">:</span>
                    <flux:select wire:model.change="form.matakuliah_id" class="w-full">
                        <flux:select.option value="">Pilih Matakuliah</flux:select.option>
                        @foreach ($listMk as $mk)
                            <flux:select.option value="{{ $mk->id }}">
                                {{ $mk->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>

            <!-- Kode Matakuliah -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                <div class="md:col-span-3 font-medium text-neutral-600 dark:text-neutral-300">
                    Kode Matakuliah
                </div>
                <div class="md:col-span-9 flex gap-2 items-center">
                    <span class="hidden md:block text-neutral-400">:</span>
                    <span class="font-semibold text-neutral-800 dark:text-neutral-100">
                        {{ optional($indentitasMk)->code ?? '-' }}
                    </span>
                </div>
            </div>

            <!-- Jumlah SKS -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                <div class="md:col-span-3 font-medium text-neutral-600 dark:text-neutral-300">
                    Jumlah SKS
                </div>
                <div class="md:col-span-9 flex gap-2 items-center">
                    <span class="hidden md:block text-neutral-400">:</span>
                    <span class="font-semibold text-neutral-800 dark:text-neutral-100">
                        {{ optional($indentitasMk)->sks ?? '-' }}
                    </span>
                </div>
            </div>

            <!-- Semester -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                <div class="md:col-span-3 font-medium text-neutral-600 dark:text-neutral-300">
                    Semester
                </div>
                <div class="md:col-span-9 flex gap-2 items-center">
                    <span class="hidden md:block text-neutral-400">:</span>
                    <span class="font-semibold text-neutral-800 dark:text-neutral-100">
                        {{ optional($indentitasMk)->semester ?? '-' }}
                    </span>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-2">
                <div class="md:col-span-3 font-medium text-neutral-600 dark:text-neutral-300">
                    Deskripsi Matakuliah
                </div>
                <div class="md:col-span-9 flex gap-2">
                    <span class="hidden md:block text-neutral-400 mt-1">:</span>
                    <p class="text-neutral-700 dark:text-neutral-200 leading-relaxed text-justify">
                        {{ optional($indentitasMk)->description ?? '-' }}
                    </p>
                </div>
            </div>

        </div>

    </x-card>

    <x-card title="Capaian Pembelajaran Lulusan">
        <div class="w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900">

            <!-- Header -->
            <div class="px-4 py-3 border-b border-neutral-300 dark:border-neutral-700">
                <h3 class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">
                    A. CPL Prodi yang Dibebankan pada MK
                </h3>
            </div>

            <!-- Content -->
            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                <!-- Item -->
                @if (!empty($dataKurikulum?->pivotCplMk))
                    @foreach ($dataKurikulum?->pivotCplMk as $cpl)
                        <div class="grid grid-cols-1 sm:grid-cols-6 gap-2 px-4 py-3">
                            <div class="sm:col-span-1 font-medium text-neutral-700 dark:text-neutral-300">
                                {{ $cpl->cpl->code }}
                            </div>

                            <div class="hidden sm:block sm:col-span-5 text-neutral-500">
                                <span class="flex gap-4 items-center">
                                    <span class="text-neutral-700 dark:text-neutral-300">:</span>
                                    <p>
                                        {{ $cpl->cpl->description }}
                                    </p>
                                </span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
        <div class="mt-2 w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900">

            <!-- Header -->
            <div class="px-4 py-3 border-b border-neutral-300 dark:border-neutral-700">
                <h3 class="text-sm font-semibold text-neutral-800 dark:text-neutral-100">
                    B. Capaian Pembelajaran Mata Kuliah (CPMK)
                </h3>
            </div>

            <!-- Content -->
            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @if (!empty($dataKurikulum?->pivotCpmkMk))
                    @foreach ($dataKurikulum?->pivotCpmkMk as $cpmk)
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 px-4 py-4">
                            <!-- Label -->
                            <div
                                class="sm:col-span-2 font-medium text-neutral-700 dark:text-neutral-300 flex items-center">
                                {{ $cpmk->cpmk->code }}
                            </div>

                            <!-- Separator -->
                            <div class="hidden col-span-1 sm:flex sm:col-span-8 justify-center text-neutral-500">
                                <span class="flex gap-4 items-center">
                                    <span class="text-neutral-700 dark:text-neutral-300">:</span>
                                    <p>
                                        {{ $cpmk->cpmk->description }}
                                    </p>
                                </span>
                            </div>

                            <!-- Weight -->
                            <div
                                class="sm:col-span-2 text-right font-semibold text-neutral-800 dark:text-neutral-100 flex items-center justify-end">
                                <flux:input class="max-w-20" class:input="font-mono" />
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
        </div>


    </x-card>


</div>
