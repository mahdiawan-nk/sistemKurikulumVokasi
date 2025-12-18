<div>

    <x-ui.pages.title :title="$title" />
    @if ($showTable)
        <section>
            <x-ui.table.header title="Capaian Pembelajaran Lulusan" wire-search="search">
                <x-slot name="filter">
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down">Program Studi</flux:button>

                        <flux:menu>
                            <flux:menu.radio.group wire:model.change="filter.prodi">
                                <flux:menu.radio wire:model="filter.prodi" value="">Semua Program Studi</flux:menu.radio>
                                @foreach ($this->getProdiOptionsProperty() as $ps)
                                    <flux:menu.radio wire:model="filter.prodi" value="{{ $ps->id }}">
                                        {{ $ps->jenjang }} - {{ $ps->name }}</flux:menu.radio>
                                @endforeach
                            </flux:menu.radio.group>

                        </flux:menu>
                    </flux:dropdown>
                </x-slot>
                <x-slot name="action">
                    <flux:button  type="button" wire:click="openSample" variant="primary" color="indigo" size="sm">Sampel Data</flux:button>
                    <button wire:click="openCreate"
                        class="inline-flex items-center gap-2 rounded-sm bg-sky-500 px-4 py-2 text-sm text-white hover:opacity-75">
                        + Create
                    </button>
                </x-slot>
            </x-ui.table.header>

            <x-ui.table.index :columns="['No', 'Program Studi', 'Kode MK', 'Nama MK', 'SKS', 'Semester', 'Jenis', 'Deskripsi']">
                @forelse ($data as $row)
                    <x-ui.table.row>
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4">
                            {{ $row->programStudis->map(fn($prodi) => $prodi->jenjang . ' - ' . $prodi->name)->implode(', ') }}
                        </td>
                        <td class="p-4">{{ $row->code }}</td>
                        <td class="p-4">{{ $row->name }}</td>
                        <td class="p-4">{{ $row->sks }}</td>
                        <td class="p-4">{{ $row->semester }}</td>
                        <td class="p-4">{{ $row->jenis }}</td>
                        <td class="p-4">{{ $row->description }}</td>
                        <x-ui.table.action edit="openEdit({{ $row->id }})"
                            delete="openDelete({{ $row->id }})" />
                    </x-ui.table.row>
                @empty
                    <x-ui.table.empty :searchValue="$search" colspan="9" :FilterValue="$this->filterValue('prodi')" stateFilter="clearFilter"
                        stateSearch="clearSearch" stateAdd="openCreate" />
                @endforelse
            </x-ui.table.index>
            <x-ui.table.pagination :paginator="$data" />
        </section>
    @endif


    @if ($showCreate)
        <div class="grid grid-cols-6 grid-rows-1 gap-4 mt-2">
            <div class="col-span-2 col-start-3">
                <livewire:master.matakuliah.create-update wire:key="create" />
            </div>
        </div>
    @endif

    @if ($showUpdate)
        <div class="grid grid-cols-6 grid-rows-1 gap-4 mt-2">
            <div class="col-span-2 col-start-3">
                <livewire:master.matakuliah.create-update wire:key="update-{{ $selectedId }}" :id="$selectedId" />
            </div>
        </div>
    @endif
</div>
