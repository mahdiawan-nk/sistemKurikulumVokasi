<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\UserRole;
class Update extends Component
{
    public $name, $email, $password;
    public $role = [];
    public $listRoles = [];
    public $isEditPassword = false;

    public $userId;

    public function mount($userId)
    {
        $user = User::find($userId);
        $this->userId = $user?->id;

        $this->name = $user?->name;
        $this->email = $user?->email;

        // Konversi role array -> boolean map
        $this->role = $user->roles->pluck('id')->toArray();

        $this->listRoles = UserRole::all();
    }


    public function update()
    {
        $user = User::find($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->isEditPassword ? bcrypt($this->password) : $user->password,
        ]);

        $user->roles()->sync($this->role);
        $this->dispatch('updated');
    }
    public function render()
    {
        return view('pages.users.update');
    }
}
