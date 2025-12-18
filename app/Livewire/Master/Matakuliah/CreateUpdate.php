<?php

namespace App\Livewire\Master\Matakuliah;

use App\Livewire\Base\BaseForm;
use App\Models\ProgramStudi;
use App\Models\Matakuliah as MK;

class CreateUpdate extends BaseForm
{
    protected array $relations = ['programStudis'];

    public function mount($id = null)
    {
        if ($id) {
            $this->openEdit($id);
        }


    }
    protected function model(): string
    {
        return MK::class;
    }

    public function rules(): array
    {
        return [
            'form.code' => 'required|string|unique:capaian_pembelajaran_matakuliahs,code,' . $this->selectedId,
            'form.name' => 'required|string',
            'form.sks' => 'required|integer',
            'form.semester' => 'required|integer',
            'form.jenis' => 'required|string',
            'form.description' => 'required|string',
            'form.programStudis' => 'required|min:1',
            'form.programStudis.*' => 'exists:program_studis,id',
        ];
    }

    public function getProdiProperty()
    {
        return ProgramStudi::all();
    }
    public function render()
    {
        return view('livewire.master.matakuliah.create-update');
    }
}
