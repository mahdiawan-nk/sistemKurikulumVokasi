<?php

namespace App\Livewire\Master\SubCpmk;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use Faker\Factory as Faker;

use App\Models\ProgramStudi;
use App\Models\SubCapaianPembelajaranMatakuliah as SUBCPMK;

#[Title('Capaian Pembelajaran Matakuliah')]
#[Layout('components.layouts.sidebar')]

class Index extends BaseTable
{
    public array $filter = [
        'prodi' => null
    ];

    protected function model(): string
    {
        return SUBCPMK::class;
    }

    public string $title = 'Bahan Kajian';

    protected function query(): Builder
    {
        return $this->model()::query()
            ->with('programStudis')
            ->when($this->filterValue('prodi'), function ($query, $prodi) {
                $query->whereHas(
                    'programStudis',
                    fn($q) =>
                    $q->where('program_studis.id', $prodi)
                );
            })
            ->when(
                $this->search,
                fn($query, $search) =>
                $query->where(function ($q) use ($search) {
                    $q->where('code', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                })
            );
    }

    public function openDelete($id)
    {
        $this->selectedId = $id;
        $this->dialog()->confirm([
            'width' => 'w-md',
            'title' => 'Are you Sure?',
            'description' => 'Data Akan Dihapus?',
            'acceptLabel' => 'Yes, Delete it!',
            'method' => 'confirmDelete',
        ]);
    }

    public function confirmDelete(): void
    {
        $this->model()::findOrFail($this->selectedId)->delete();
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success Notification!',
            'description' => 'Data Berhasil Dihapus',
            'timeout' => 2500
        ]);
        $this->reset();
    }

    public function openSample(): void
    {
        $this->dialog()->confirm([
            'title' => 'Are you Sure?',
            'description' => 'Akan Generate Data ' . $this->title . '? 5 data Per Program Studi',
            'acceptLabel' => 'Yes, Generate it!',
            'method' => 'confirmGenerate',
        ]);
    }

    public function confirmGenerate(): void
    {
        $prodi = ProgramStudi::all();
        $faker = Faker::create('id_ID');
        foreach ($prodi as $item) {
            foreach (range(1, 10) as $index) {
                $pl = SUBCPMK::create([
                    'code' => 'SUBCPMK-' . $index . '-' . $item->code,
                    'description' => 'Sub Capaian Pembelajaran Matakuliah ' . $item->name . ' ' . $index . '-' . $faker->sentence(12),
                ]);

                $pl->programStudis()->attach($item->id);
            }
        }
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success Notification!',
            'description' => 'Data Berhasil Di Generate',
            'timeout' => 2500
        ]);
    }

    public function getFormDataProperty(): array
    {
        throw new \Exception('Not implemented');
    }

    public function getProdiOptionsProperty()
    {
        return ProgramStudi::all();
    }
    public function view(): string
    {
        return 'livewire.master.sub-cpmk.index';
    }
}
