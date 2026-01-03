<?php

namespace App\Livewire\PerangkatAjar\Rps;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Matakuliah;
use App\Models\Kurikulum;
use App\Models\CapaianPembelajaranLulusan as Cpl;
use App\Models\CapaianPembelajaranMatakuliah as Cpmk;

#[Title('Data Kurikulum')]
#[Layout('components.layouts.sidebar')]
class Index extends Component
{

    public $listMk = [];

    public $activeProdi = null;

    public $form = [
        'matakuliah_id' => null
    ];

    public $indentitasMk = [];
    public $dataKurikulum = [];

    public $matriksCplCpmk = [
        'cpl' => [],
        'cpmk' => []
    ];

    public function mount()
    {
        $this->setFilterProdi();
        $this->listMk = $this->getListMatakuliah()->get();

    }

    protected function getListMatakuliah()
    {

        return Matakuliah::query()
            ->with(['programStudis', 'MkCpmk.cpmk', 'MkCpl.cpl'])
            ->when($this->activeProdi, function ($q) {
                $q->whereHas('programStudis', function ($q) {
                    $q->where('program_studis.id', $this->activeProdi);
                });
            });
    }

    protected function getKurikulumPublishedByMk($matakuliahId)
    {
        return Kurikulum::query()
            ->where('status', 'published')
            ->when(
                $this->activeProdi,
                fn($q) =>
                $q->whereHas(
                    'programStudis',
                    fn($q) =>
                    $q->where('program_studis.id', $this->activeProdi)
                )
            )
            ->whereHas(
                'pivotCpmkMk',
                fn($q) =>
                $q->where('pivot_cpmk_mks.mk_id', $matakuliahId)
            )
            ->with([
                'pivotCpmkMk' => fn($q) =>
                    $q->where('mk_id', $matakuliahId)->with('cpmk'),
                'pivotCplMk' => fn($q) =>
                    $q->where('mk_id', $matakuliahId)->with('cpl'),
            ])
            ->first();
    }

    protected function setFilterProdi(): void
    {
        if (in_array(session('active_role'), ['Dosen', 'Kaprodi'])) {

            $programStudi = auth()->user()
                    ?->dosens()
                    ?->with('programStudis')
                    ?->first()
                    ?->programStudis()
                    ?->first();

            $this->activeProdi = $programStudi?->id;
            return;
        }

    }
    protected function matriksCplCpmk($mkId)
    {
        
    }
    public function updating($key, $value)
    {
        // $this->form[$key] = $value;
        if ($key == 'form.matakuliah_id') {
            $this->indentitasMk = $this->getListMatakuliah()->find($value);
            $this->dataKurikulum = $this->getKurikulumPublishedByMk($value);
            $this->matriksCplCpmk($value);
        }
    }
    public function render()
    {
        return view('livewire.perangkat-ajar.rps.index');
    }
}
