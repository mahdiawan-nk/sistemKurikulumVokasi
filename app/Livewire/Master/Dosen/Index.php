<?php

namespace App\Livewire\Master\Dosen;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ProgramStudi;
use App\Models\Dosen as DSN;
use App\Models\User;
#[Title('Dosen')]
#[Layout('components.layouts.sidebar')]

class Index extends BaseTable
{
    public array $filter = [
        'prodi' => null
    ];

    protected function model(): string
    {
        return DSN::class;
    }

    public string $title = 'Dosen';

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
                    $q->where('nrp', 'like', "%{$search}%")
                        ->orWhere('nidn', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
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
        User::whereHas('dosens', fn($q) => $q->where('dosens.id', $this->selectedId))->delete();    
        $this->model()::findOrFail($this->selectedId)->delete();
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success Notification!',
            'description' => 'Data Berhasil Dihapus',
            'timeout' => 2500
        ]);
        $this->reset();
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
        return 'livewire.master.dosen.index';
    }
}
