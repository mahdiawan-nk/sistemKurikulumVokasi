<?php

namespace App\Livewire\Master\Matakuliah;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use Faker\Factory as Faker;

use App\Models\ProgramStudi;
use App\Models\Matakuliah as MK;

#[Title('Matakuliah')]
#[Layout('components.layouts.sidebar')]

class Index extends BaseTable
{

    public array $filter = [
        'prodi' => null
    ];

    protected function model(): string
    {
        return MK::class;
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
                        ->orWhere('name', 'like', "%{$search}%");
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
        $jenjangRules = [
            'D2' => [
                'max_semester' => 2,
                'mk_min' => 8,
                'mk_max' => 10,
            ],
            'D3' => [
                'max_semester' => 6,
                'mk_min' => 8,
                'mk_max' => 12,
            ],
            'D4' => [
                'max_semester' => 8,
                'mk_min' => 8,
                'mk_max' => 12,
            ],
        ];
        $faker = Faker::create('id_ID');
        $prodis = ProgramStudi::all();

        foreach ($prodis as $prodi) {

            // skip jika jenjang tidak dikenali
            if (!isset($jenjangRules[$prodi->jenjang])) {
                continue;
            }

            $rule = $jenjangRules[$prodi->jenjang];

            // loop semester berdasarkan jenjang
            for ($semester = 1; $semester <= $rule['max_semester']; $semester++) {

                $totalMk = rand($rule['mk_min'], $rule['mk_max']);

                for ($i = 1; $i <= $totalMk; $i++) {

                    $mk = MK::create([
                        'code' => sprintf(
                            'MK-%s-S%s-%02d',
                            $prodi->code,
                            $semester,
                            $i
                        ),
                        'name' => $faker->sentence(3),
                        'sks' => rand(1, 3),
                        'semester' => $semester,
                        'description' => 'Mata kuliah '
                            . $prodi->name
                            . ' semester '
                            . $semester
                            . ' - '
                            . $faker->sentence(10),
                    ]);

                    // relasi ke prodi
                    $mk->programStudis()->attach($prodi->id);
                }
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
        return 'livewire.master.matakuliah.index';
    }
}
