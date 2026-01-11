<?php

namespace App\Livewire\PerangkatAjar\Rps;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\ProgramStudi;
use App\Models\Rps;


#[Layout('components.layouts.sidebar')]
class Index extends BaseTable
{

    public string $title = 'RPS';
    protected static string $model = Rps::class;
    protected static string $view = 'livewire.perangkat-ajar.rps.index';

    protected array $filterable = [
        'prodi' => [
            'type' => 'column',
            'column' => 'program_studi_id'
        ]
    ];

    protected array $searchable = [
        'matakuliah' => [
            'type' => 'relation',
            'relation' => 'matakuliah',
            'column' => 'matakuliah.name'
        ],
        'dosen' => [
            'type' => 'relation',
            'relation' => 'dosen',
            'column' => 'dosen.name'
        ]
    ];

    public array $filter = [
        'prodi' => null,
    ];

    public function getProdiOptionsProperty()
    {
        return ProgramStudi::query()
            ->orderBy('name')
            ->get(['id', 'name', 'jenjang']);
    }

    protected function beforeSetFilterProdi(): void
    {
        if (session('active_role') == 'Dosen') {

            $programStudi = auth()->user()
                    ?->dosens()
                    ?->with('programStudis')
                    ?->first()
                    ?->programStudis()
                    ?->first();

            $this->filter['prodi'] = $programStudi?->id;

            return;
        }
    }

    protected function beforeDelete()
    {
        $rpsData = Rps::find($this->selectedId);
        $rpsData->pertemuans()->delete();
        $rpsData->referensis()->delete();
        $rpsData->penilaians()->delete();
        $rpsData->rpsApprovals()->delete();
    }
}
