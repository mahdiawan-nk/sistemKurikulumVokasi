<?php

namespace App\Livewire\PerangkatAjar\KontrakKuliah;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\KontrakKuliah;
use App\Models\ProgramStudi;

#[Layout('components.layouts.sidebar')]
class Index extends BaseTable
{

    public string $title = 'Perangkat Ajar Kontrak Kuliah';
    /* ----------------------------------------
     | Model & View
     |---------------------------------------- */
    protected static string $model = KontrakKuliah::class;
    protected static string $view = 'livewire.perangkat-ajar.kontrak-kuliah.index';

    /* ----------------------------------------
     | Table Config
     |---------------------------------------- */
    public array $relations = ['programStudis'];

    /**
     * daftar filter yang didukung
     * cara kerja:
     *  - type `relation` → auto whereHas
     *  - column opsional → jika pivot / custom field
     */
    protected array $filterable = [
        'prodi' => [
            'type' => 'relation',
            'relation' => 'programStudis',
            'column' => 'program_studis.id',
        ],
    ];

    /**
     * daftar kolom pencarian
     */
    protected array $searchable = ['name', 'code'];

    /**
     * nilai default filter
     */
    public array $filter = [
        'prodi' => null,
    ];

    public function getProdiOptionsProperty()
    {
        return ProgramStudi::query()
            ->orderBy('name')
            ->get(['id', 'name', 'jenjang']);
    }

}
