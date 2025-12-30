<div>

    <x-ui.pages.title :title="$title" />
    @if ($showTable)
        <section>
            <x-ui.table.header title="Capaian Pembelajaran Lulusan" wire-search="search">
                {{-- @can('filter', [App\Models\BahanKajian::class, ['Kaprodi','Dosen']]) --}}
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
                {{-- @endcan --}}
                {{-- @can('create', [App\Models\BahanKajian::class, ['Kaprodi']]) --}}
                    <x-slot name="action">
                        <flux:button type="button" wire:click="openSample" variant="primary" color="indigo" size="sm">
                            Sampel Data</flux:button>
                        <flux:button href="{{ route('perangkat-ajar.kontrak-kuliah.create') }}" variant="primary" color="blue" size="sm">
                            Create</flux:button>
                    </x-slot>
                {{-- @endcan --}}
            </x-ui.table.header>
            @php
                $columnHeaders = ['No', 'Program Studi', 'Matakuliah','Tahun AKD','Dosen Pengampu','Created At'];
                // if (Gate::allows('create', [App\Models\CapaianPembelajaranLulusan::class, ['Kaprodi']])) {
                //     unset($columnHeaders[1]);
                // }
            @endphp
            <x-ui.table.index :columns="$columnHeaders" >
                @forelse ($data as $row)
                    <x-ui.table.row>
                        <td class="p-4">{{ $loop->iteration }}</td>
                            <td class="p-4 max-w-[75px]">
                                {{ $row->programStudis->name }}
                            </td>
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
                        <x-ui.table.action edit="openEdit({{ $row->id }})" delete="openDelete({{ $row->id }})"
                            :row="$row"  />
                    </x-ui.table.row>
                @empty
                    <x-ui.table.empty :searchValue="$search" :FilterValue="$this->filterValue('prodi')" stateFilter="clearFilter"
                        stateSearch="clearSearch" stateAdd="openCreate" />
                @endforelse
            </x-ui.table.index>
            <x-ui.table.pagination :paginator="$data" />
        </section>
    @endif

</div>
