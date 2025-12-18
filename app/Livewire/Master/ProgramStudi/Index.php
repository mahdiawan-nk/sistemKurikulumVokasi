<?php

namespace App\Livewire\Master\ProgramStudi;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

use App\Models\ProgramStudi;
use App\Models\ProgramStudi as PRODI;

#[Title('Program Studi')]
#[Layout('components.layouts.sidebar')]

class Index extends BaseTable
{

    protected function model(): string
    {
        return PRODI::class;
    }

    public string $title = 'Program Studi';

    protected function query(): Builder
    {
        return $this->model()::query()
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
        return 'livewire.master.program-studi.index';
    }
}
