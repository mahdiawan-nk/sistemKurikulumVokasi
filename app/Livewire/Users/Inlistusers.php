<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\UserRole;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\On;
class Inlistusers extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $perPage = 10;
    public $search = '';
    public $selectedId;

    public $showModalCreate = false;
    public $showModalUpdate = false;
    public $showModalDelete = false;
    public $listRoles = [];

    public function mount()
    {
        $this->listRoles = UserRole::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModalCreate()
    {
        // $this->showModalCreate = true;
        $this->modal('create-modal')->show();
        // dd($this->showModalCreate);
    }

    public function openModalEdit($id)
    {
        $this->selectedId = $id;
        $this->showModalUpdate = true;
        $this->modal('update-modal')->show();
    }

    public function openModalDelete($id)
    {
        $this->selectedId = $id;
        $this->showModalDelete = true;
        $this->modal('delete-modal')->show();

    }

   #[On('created'), On('updated')]
    public function closeModal(){
        $this->selectedId = null;
        $this->showModalCreate = false;
        $this->showModalUpdate = false;
        $this->showModalDelete = false;
        $this->modal('create-modal')->close();
        $this->modal('update')->close();
        $this->modal('delete')->close();
    }

    public function delete()
    {
        $user = User::find($this->selectedId);
        $user->delete();
        $this->closeModal();
    }
    public function render()
    {
        $data = User::query()
            ->with('roles')
            ->when($this->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->paginate($this->perPage);
        return view('pages.users.list', compact('data'));
    }
}
