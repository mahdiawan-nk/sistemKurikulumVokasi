<?php

namespace App\Livewire\PerangkatAjar\RealisasiAjar\Section;

use Livewire\Component;
use App\Models\RealisasiPengajaranEvaluasi;
use App\Models\RealisasiPengajaranMetode;
use App\Models\RealisasiPengajaranReferensi;
class Footer extends Component
{
    public $form = [
        'metode' => [
            'kuliah' => [
                'jam' => ''
            ],
            'tutorial' => [
                'jam' => ''
            ],
            'laboratorium' => [
                'jam' => ''
            ]
        ],
        'evaluasi' => [
            'tugas_persen' => '',
            'kuis_persen' => '',
            'ujian_persen' => '',
        ]
    ];

    public $lisJenisReferensi = ['buku', 'modul', 'diktat'];
    public $referensi = [];

    public ?int $selectedId = null;
    public $isEdit = false;
    public $isView = false;

    protected $listeners = ['requestFormData'];

    public function requestFormData()
    {
        $this->validate([
            'form.metode.kuliah.jam' => ['required', 'integer', 'min:0'],
            'form.metode.tutorial.jam' => ['required', 'integer', 'min:0'],
            'form.metode.laboratorium.jam' => ['required', 'integer', 'min:0'],
            'form.evaluasi.tugas_persen' => ['required', 'integer', 'min:0'],
            'form.evaluasi.kuis_persen' => ['required', 'integer', 'min:0'],
            'form.evaluasi.ujian_persen' => ['required', 'integer', 'min:0'],
            'referensi' => ['required', 'array', 'min:1'],
            'referensi.*.jenis' => ['required', 'string'],
            'referensi.*.judul' => ['required', 'string'],
            'referensi.*.penerbit' => ['required', 'string'],
        ]);
        $this->form['referensi'] = $this->referensi;

        $this->dispatch(
            'formDataReady',
            section: 'footer',
            data: $this->form
        );
    }

    // public function editData($id)
    // {
    //     $this->selectedId = $id;
    //     $this->isEdit = true;
    //     $this->openEdit();
    // }

    public function openEdit()
    {
        $metodeData = RealisasiPengajaranMetode::where('realisasi_id', $this->selectedId)->get();
        $evaluasiData = RealisasiPengajaranEvaluasi::where('realisasi_id', $this->selectedId)->first();
        $referensiData = RealisasiPengajaranReferensi::where('realisasi_id', $this->selectedId)->get();
        foreach ($metodeData as $metode) {
            $this->form['metode'][$metode->jenis]['jam'] = $metode->jam;
        }
        $this->form['evaluasi']['tugas_persen'] = (int) $evaluasiData->tugas_persen;
        $this->form['evaluasi']['kuis_persen'] = (int) $evaluasiData->kuis_persen;
        $this->form['evaluasi']['ujian_persen'] = (int) $evaluasiData->ujian_persen;

        foreach ($referensiData as $referensi) {
            $this->referensi[] = [
                'uid' => uniqid(),
                'jenis' => $referensi->jenis,
                'judul' => $referensi->judul,
                'penerbit' => $referensi->penerbit,
            ];
        }
        
    }

    public function mount(int $selectedId = null, bool $isEdit = false, bool $isView = false)
    {
        if ($selectedId && ($isEdit || $isView)) {
            $this->selectedId = $selectedId;
            $this->isEdit = $isEdit;
            $this->isView = $isView;
            $this->openEdit();
        } else {
            $this->addReferensi();

        }
    }
    public function addReferensi()
    {
        $this->referensi[] = [
            'uid' => uniqid(),
            'jenis' => '',
            'judul' => '',
            'penerbit' => '',
        ];
    }

    public function removeReferensi($index)
    {
        if (count($this->referensi) <= 1) {
            return;
        }

        unset($this->referensi[$index]);
        $this->referensi = array_values($this->referensi);
    }
    public function render()
    {
        return view('livewire.perangkat-ajar.realisasi-ajar.section.footer');
    }
}
