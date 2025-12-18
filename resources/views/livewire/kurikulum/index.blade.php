<div class="container mx-auto py-3">

    <x-ui.pages.title :title="$title" />
    @if ($showTable)
        <section>
            <x-ui.table.header title="Capaian Pembelajaran Lulusan" wire-search="search">
                <x-slot name="filter">
                    <flux:dropdown>
                        <flux:button icon:trailing="chevron-down">Program Studi</flux:button>

                        <flux:menu>
                            <flux:menu.radio.group wire:model.change="filter.prodi">
                                @foreach ($this->getProdiOptionsProperty() as $ps)
                                    <flux:menu.radio wire:model="filter.prodi" value="{{ $ps->id }}">
                                        {{ $ps->jenjang }} - {{ $ps->name }}</flux:menu.radio>
                                @endforeach
                            </flux:menu.radio.group>

                        </flux:menu>
                    </flux:dropdown>
                </x-slot>
                <x-slot name="action">
                    <button wire:click="openCreate"
                        class="inline-flex items-center gap-2 rounded-sm bg-sky-500 px-4 py-2 text-sm text-white hover:opacity-75">
                        + Create
                    </button>
                </x-slot>
            </x-ui.table.header>

            <x-ui.table.index :columns="['No', 'Program Studi', 'Kurikulum', 'Tahun', 'Version', 'Type', 'Status', 'Di Buat Oleh']">
                @forelse ($data as $row)
                    <x-ui.table.row>
                        <td class="p-4">{{ $loop->iteration }}</td>
                        <td class="p-4">
                            {{ $row->programStudis->name }}
                        </td>
                        <td class="p-4">{{ $row->name }}</td>
                        <td class="p-4">{{ $row->year }}</td>
                        <td class="p-4">{{ $row->version }}</td>
                        <td class="p-4">{{ $row->type }}</td>
                        <td class="p-4">{{ $row->status }}</td>
                        <td class="p-4">{{ $row->creator->name }}</td>
                        <x-ui.table.action edit="openEdit({{ $row->id }})"
                            delete="openDelete({{ $row->id }})" />
                    </x-ui.table.row>
                @empty
                    <x-ui.table.empty :searchValue="$search" :colspan="9" :FilterValue="$this->filterValue('prodi')" stateFilter="clearFilter"
                        stateSearch="clearSearch" stateAdd="openCreate" />
                @endforelse
            </x-ui.table.index>
            <x-ui.table.pagination :paginator="$data" />
        </section>
    @endif


    @if ($showCreate)
        {{-- <div class="grid grid-cols-12 grid-rows-1 gap-4 mt-2"> --}}
        {{-- <div class="col-span-2 col-start-3"> --}}
        <livewire:kurikulum.create-update wire:key="create" />
        {{-- </div> --}}
        {{-- </div> --}}
    @endif

    @if ($showUpdate)
        <livewire:kurikulum.create-update wire:key="update-{{ $selectedId }}" :id="$selectedId" />
    @endif
</div>
