<?php

namespace App\Livewire\Base;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use WireUi\Traits\WireUiActions;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseTable extends Component
{
    use WithPagination, WireUiActions;

    public string $search = '';
    public string $sortBy = 'id';
    public string $sortDirection = 'desc';
    public int $perPage = 10;

    public bool $showTable = true;
    public bool $showCreate = false;
    public bool $showUpdate = false;
    public ?int $selectedId = null;
    public array $filter = [];

    public string $title = 'Page Title';

    protected array $allowedSorts = ['id', 'created_at'];
    protected array $allowedDirections = ['asc', 'desc'];

    /** @return Builder */
    abstract protected function query(): Builder;

    /** Optional: load data for create/edit form */
    abstract public function getFormDataProperty(): array;

    public function openCreate()
    {
        $this->resetSelected();
        $this->showCreate = true;
        $this->showTable = false;
    }

    public function openEdit($id)
    {
        $this->selectedId = $id;
        $this->showUpdate = true;
        $this->showTable = false;
    }

    #[On('cancel'), On('success-created'), On('success-updated')]
    public function cancelForm(): void
    {
        $this->showCreate = false;
        $this->showUpdate = false;
        $this->showTable = true;
        $this->resetSelected();
        $this->reset();
    }

    protected function resetSelected(): void
    {
        $this->selectedId = null;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingFilter()
    {
        
        $this->resetPage();
    }

    public function clearFilter()
    {
        $this->filter = [];
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    protected function filterValue(string $key, $default = null)
    {
        return $this->filter[$key] ?? $default;
    }

    public function render()
    {
        return view($this->view(), [
            'data' => $this->query()->paginate($this->perPage),
        ]);
    }

    /** Override di child untuk menentukan view */
    abstract protected function view(): string;
}
