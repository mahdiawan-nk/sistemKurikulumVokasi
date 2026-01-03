<div>

    <x-ui.pages.title :title="$title" />
    @if ($showTable)
        <section>
            <x-ui.table.header title="Capaian Pembelajaran Lulusan" wire-search="search">
                @can('filter', [App\Models\KontrakKuliah::class, ['Kaprodi', 'Dosen']])
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
                @endcan
                @can('create', [App\Models\BahanKajian::class, ['Dosen']])
                    <x-slot name="action">
                        <flux:button href="{{ route('perangkat-ajar.kontrak-kuliah.create') }}" variant="primary"
                            color="blue" size="sm">
                            Create</flux:button>
                    </x-slot>
                @endcan
            </x-ui.table.header>
            @php
                $columnHeaders = ['No', 'Program Studi', 'Matakuliah', 'Tahun AKD', 'Dosen Pengampu', 'Created At'];
                $show = Gate::any(
                    ['update', 'delete'],
                    [App\Models\CapaianPembelajaranLulusan::class, ['Kaprodi', 'Dosen']],
                );
                if ($show) {
                    unset($columnHeaders[1]);
                }
            @endphp
            <x-ui.table.index :columns="$columnHeaders" :showAction="$show">
                @forelse ($data as $row)
                    <x-ui.table.row>
                        <td class="p-4">{{ $loop->iteration }}</td>
                        @if (!$show)
                            <td class="p-4 max-w-[75px]">
                                {{ $row->programStudis->name }}
                            </td>
                        @endif
                        <td class="p-4">
                            <div class="flex flex-col">
                                <span class="font-bold">{{ $row->matakuliah->name }}</span>
                                <span>Semester {{ $row->matakuliah->semester }}</span>
                                <span>{{ $row->matakuliah->sks }} SKS</span>
                            </div>
                        </td>
                        <td class="p-4">{{ $row->tahun_akademik }}</td>
                        <td class="p-4">{{ $row->dosen->name }}</td>
                        <td class="p-4">{{ $row->created_at }}</td>
                        <x-ui.table.action :row="$row">
                            @can('update', [App\Models\KontrakKuliah::class, [ 'Dosen']])
                                <flux:button variant="primary" icon="pencil" href="{{ route('perangkat-ajar.kontrak-kuliah.update',['id'=>$row->id]) }}"
                                    size="sm" wire:navigate/>
                            @endcan
                            @can('delete', [App\Models\KontrakKuliah::class, [ 'Dosen']])
                                <flux:button variant="danger" icon="trash" wire:click="openDelete({{ $row->id }})" size="sm" />
                            @endcan
                                {{-- <flux:button variant="danger" icon="trash" :href="route('pdf.preview')" size="sm" /> --}}
                        </x-ui.table.action>
                    </x-ui.table.row>
                @empty
                    <x-ui.table.empty :searchValue="$search" :FilterValue="$this->filterValue('prodi')" stateFilter="clearFilter"
                        stateSearch="clearSearch" stateAdd="openCreate" colspan="6"/>
                @endforelse
            </x-ui.table.index>
            <x-ui.table.pagination :paginator="$data" />
        </section>
    @endif

</div>
