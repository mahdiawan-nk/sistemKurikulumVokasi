<?php

namespace App\Livewire\Kurikulum;

use App\Livewire\Base\BaseForm;
use App\Models\ProgramStudi;
use App\Models\Kurikulum;
use App\Models\ProfileLulusan;
use App\Models\CapaianPembelajaranLulusan;
use App\Models\BahanKajian;
use App\Models\CapaianPembelajaranMatakuliah;
use App\Models\SubCapaianPembelajaranMatakuliah;
use App\Models\Matakuliah;
use Illuminate\Support\Collection;

class CreateUpdate extends BaseForm
{
    protected array $relations = ['programStudis'];

    public array $tabName = [
        0 => 'Metadata Kurikulum',
        1 => 'CPL - PL',
        2 => 'BK - CPL',
        3 => 'BK - MK',
        4 => 'CPMK - SubCPMK',
        5 => 'MK - CPL',
        6 => 'CPMK - MK',
        7 => 'CPL - BK - MK',
        8 => 'CPL - CPMK - MK',
    ];

    public int $tabActive = 0;
    public int $maxTab = 8;
    public bool $showModalCplBkMK = false;
    public bool $showModalCplCpmkMK = false;
    public bool $showModalBkMK = false;
    public bool $showModalCpmkMK = false;


    public array $tempSelectCplBkMK = [
        'cpl' => [
            'id' => null,
            'code' => null
        ],
        'bk' => [
            'id' => null,
            'code' => null
        ]
    ];

    public array $tempSelectCplCpmkMK = [
        'cpl' => [
            'id' => null,
            'code' => null
        ],
        'cpmk' => [
            'id' => null,
            'code' => null
        ]
    ];

    // Temp data yang sedang diedit
    public array $tempSelectBkMK = [
        'bk' => [
            'id' => null,
            'code' => null,
            'name' => null,
        ],
    ];

    public array $tempSelectCpmkMK = [
        'cpmk' => [
            'id' => null,
            'code' => null,
        ],
    ];

    public array $setTempSelectCpmkMK = [];

    public ?int $selectedId = null;
    // Penyimpanan sementara (preview di tabel)
    public array $setTempSelectBkMK = [];
    public $setTempSelectCplBkMK = [];
    public $setTempSelectCplCpmkMK = [];
    public array $form = [
        'programStudis' => [],
        'cpl_pl' => [],
        'bk_cpl' => [],
        'bk_mk' => [],
        'cpmk_subcpmk' => [],
        'mk_cpl' => [],
        'cpmk_mk' => [],
        'cpl_bk_mk' => [],
        'cpl_cpmk_mk' => [],
    ];
    public $programStudis = null;

    public function setTabActive($key)
    {
        $this->tabActive = $key;
    }

    protected function rulesByStep(): array
    {
        return match ($this->tabActive) {
            0 => [
                'form.programStudis' => 'required',
                'form.name' => 'required|string',
                'form.year' => 'required',
                'form.version' => 'required|numeric',
                'form.type' => 'required',
            ],

            // TAB 1 – CPL ↔ PL
            1 => [
                'form.cpl_pl' => 'required|array|min:1',
            ],

            // TAB 2 – BK ↔ CPL
            2 => [
                'form.bk_cpl' => 'required|array|min:1',
            ],

            // TAB 3 – BK ↔ MK
            3 => [
                'form.bk_mk' => 'required|array|min:1',
            ],

            // TAB 4 – CPMK ↔ SubCPMK
            4 => [
                'form.cpmk_subcpmk' => 'required|array|min:1',
            ],

            // TAB 5 – MK ↔ CPL
            5 => [
                'form.mk_cpl' => 'required|array|min:1',
            ],

            // TAB 6 – CPMK ↔ MK
            6 => [
                'form.cpmk_mk' => 'required|array|min:1',
            ],

            // TAB 7 – CPL ↔ BK ↔ MK
            7 => [
                'form.cpl_bk_mk' => 'required|array|min:1',
            ],

            // TAB 8 – CPL ↔ CPMK ↔ MK
            8 => [
                'form.cpl_cpmk_mk' => 'required|array|min:1',
            ],

            default => [],
        };
    }
    public function nextStep()
    {
        $this->validate($this->rulesByStep());

        if ($this->tabActive < $this->maxTab) {
            $this->tabActive++;
        }
    }

    public function prevStep()
    {
        if ($this->tabActive > 0) {
            $this->tabActive--;
        }
    }
    protected function selectedProdiIds(): array
    {
        $prodi = $this->form['programStudis'] ?? [];

        if (empty($prodi)) {
            return [];
        }

        return is_array($prodi) ? $prodi : [$prodi];
    }

    protected function loadByProdi(string $model, array $with = ['programStudis'])
    {
        $prodiIds = $this->selectedProdiIds();

        return $model::with($with)
            ->when(
                count($prodiIds) > 0,
                fn($q) => $q->whereHas(
                    'programStudis',
                    fn($query) =>
                    $query->whereIn('program_studis.id', $prodiIds)
                ),
                fn($q) => $q->whereRaw('1 = 0')
            )
            ->get();
    }

    public function updatedFormProgramStudis($value)
    {
        // $this->form['programStudis'] = array_filter($this->form['programStudis']);
        $this->form['programStudis'] = (array) $value;
        $this->getProfileLulusansProperty();
        $this->getMatakuliahsProperty();
        $cpls = $this->getCapaianPembelajaranLulusansProperty();
        $bk = $this->getBahanKajiansProperty();
        $mk = $this->getMatakuliahsProperty();
        $cpmk = $this->getCapaianPembelajaranMatakuliahsProperty();
        $subcpmk = $this->getSubCapaianPembelajaranMatakuliahsProperty();

        // reset dan init mapping cpl => []
        $this->form['cpl_pl'] = [];
        $this->form['bk_cpl'] = [];
        $this->form['bk_mk'] = [];
        $this->form['cpmk_subcpmk'] = [];
        $this->form['mk_cpl'] = [];
        $this->form['cpmk_mk'] = [];
        $this->form['cpl_bk_mk'] = [];
        $this->form['cpl_cpmk_mk'] = [];

        foreach ($cpls as $cpl) {
            $this->form['cpl_pl'][$cpl->id] = [];
            foreach ($cpmk as $item) {
                $this->form['cpl_cpmk_mk'][$item->id][$cpl->id] = [];
            }

        }


        foreach ($bk as $b) {
            foreach ($cpls as $cpl) {
                $this->form['cpl_bk_mk'][$b->id][$cpl->id] = [];

            }
        }
        foreach ($bk as $b) {
            $this->form['bk_cpl'][$b->id] = [];
            $this->form['bk_mk'][$b->id] = [];
        }

        foreach ($mk as $m) {
            $this->form['mk_cpl'][$m->id] = [];

        }
        foreach ($cpmk as $cpmks) {
            $this->form['cpmk_subcpmk'][$cpmks->id] = [];
            $this->form['cpmk_mk'][$cpmks->id] = [];
        }
    }

    public function getProfileLulusansProperty()
    {
        return $this->loadByProdi(ProfileLulusan::class);
    }

    public function getCapaianPembelajaranLulusansProperty()
    {
        return $this->loadByProdi(CapaianPembelajaranLulusan::class);
    }

    public function getBahanKajiansProperty()
    {
        return $this->loadByProdi(BahanKajian::class);
    }

    public function getCapaianPembelajaranMatakuliahsProperty()
    {
        return $this->loadByProdi(CapaianPembelajaranMatakuliah::class);
    }

    public function getSubCapaianPembelajaranMatakuliahsProperty()
    {
        return $this->loadByProdi(SubCapaianPembelajaranMatakuliah::class);
    }

    public function getMatakuliahsProperty()
    {
        return $this->loadByProdi(Matakuliah::class)
            ->map(function ($mk) {
                $mk->description = $mk->programStudis
                    ->pluck('nama')
                    ->join(', ');
                return $mk;
            });
    }


    public function getMaktulSelectProperty()
    {
        return $this->loadByProdi(Matakuliah::class)
            ->map(function ($mk) {
                return [
                    'id' => $mk->id,
                    'code' => $mk->code,
                    'semester' => $mk->semester,
                    'name' => $mk->name,
                    'sks' => $mk->sks,
                    'description' => $mk->programStudis
                        ->pluck('nama')
                        ->join(', '),
                ];
            })
            ->groupBy(fn($mk) => 'Semester ' . $mk['semester'])
            ->map(fn($items, $semester) => [
                'name' => $semester,
                'options' => $items->values(),
            ])
            ->values()
            ->toArray();
    }

    public function openAddRelation(string $type, ?int $primaryId = null, ?int $secondaryId = null)
    {
        // Tentukan nama property modal & tempSelect & form mapping berdasarkan type
        $modalProperty = match ($type) {
            'cpl_bk_mk' => 'showModalCplBkMK',
            'cpl_cpmk_mk' => 'showModalCplCpmkMK',
            'cpmk_mk' => 'showModalCpmkMK',
            'bk_mk' => 'showModalBkMK',
            default => null
        };

        $tempProperty = match ($type) {
            'cpl_bk_mk' => 'tempSelectCplBkMK',
            'cpl_cpmk_mk' => 'tempSelectCplCpmkMK',
            'cpmk_mk' => 'tempSelectCpmkMK',
            'bk_mk' => 'tempSelectBkMK',
            default => null
        };

        if (!$modalProperty || !$tempProperty) {
            return;
        }

        // Aktifkan modal
        $this->$modalProperty = true;

        // Ambil data dari model sesuai tipe
        $primary = null;
        $secondary = null;

        switch ($type) {
            case 'cpl_bk_mk':
                $primary = $this->getCapaianPembelajaranLulusansProperty()->firstWhere('id', $primaryId);
                $secondary = $this->getBahanKajiansProperty()->firstWhere('id', $secondaryId);
                $this->$tempProperty = [
                    'cpl' => ['id' => $primary?->id, 'code' => $primary?->code],
                    'bk' => ['id' => $secondary?->id, 'code' => $secondary?->code],
                ];
                break;

            case 'cpl_cpmk_mk':
                $primary = $this->getCapaianPembelajaranLulusansProperty()->firstWhere('id', $secondaryId);
                $secondary = $this->getCapaianPembelajaranMatakuliahsProperty()->firstWhere('id', $primaryId);
                $this->$tempProperty = [
                    'cpl' => ['id' => $secondary?->id, 'code' => $secondary?->code],
                    'cpmk' => ['id' => $primary?->id, 'code' => $primary?->code],
                ];
                break;

            case 'cpmk_mk':
                $primary = $this->getCapaianPembelajaranMatakuliahsProperty()->firstWhere('id', $primaryId);
                $this->$tempProperty = [
                    'cpmk' => ['id' => $primary?->id, 'code' => $primary?->code],
                ];
                break;

            case 'bk_mk':
                $primary = $this->getBahanKajiansProperty()->firstWhere('id', $primaryId);
                $this->$tempProperty = [
                    'bk' => ['id' => $primary?->id, 'code' => $primary?->code, 'name' => $primary?->name],
                ];
                break;
        }

        // Inject data lama dari setTempSelect
        switch ($type) {
            case 'cpl_bk_mk':
                $this->form['cpl_bk_mk'][$secondaryId][$primaryId] =
                    $this->setTempSelectCplBkMK[$secondaryId][$primaryId]['id'] ?? [];
                break;
            case 'cpl_cpmk_mk':
                $this->form['cpl_cpmk_mk'][$secondaryId][$primaryId]
                    = $this->setTempSelectCplCpmkMK[$primaryId][$secondaryId]['id'] ?? [];
                break;
            case 'cpmk_mk':
                $this->form['cpmk_mk'][$primaryId] =
                    $this->setTempSelectCpmkMK[$primaryId]['id'] ?? [];
                break;
            case 'bk_mk':
                $this->form['bk_mk'][$primaryId] =
                    $this->setTempSelectBkMK[$primaryId]['id'] ?? [];
                break;
        }
    }


    public function openAddCplBkMk($cplId = null, $bkId = null)
    {
        $this->showModalCplBkMK = true;

        $cpl = $this->getCapaianPembelajaranLulusansProperty()
            ->firstWhere('id', $cplId);

        $bk = $this->getBahanKajiansProperty()
            ->firstWhere('id', $bkId);

        $this->tempSelectCplBkMK = [
            'cpl' => [
                'id' => $cpl?->id,
                'code' => $cpl?->code,
            ],
            'bk' => [
                'id' => $bk?->id,
                'code' => $bk?->code,
            ],
        ];

        /**
         * 🔥 INJECT DATA YANG SUDAH DIPILIH
         */
        if (
            isset($this->setTempSelectCplBkMK[$bkId][$cplId]['id'])
        ) {
            $this->form['cpl_bk_mk'][$bkId][$cplId]
                = $this->setTempSelectCplBkMK[$bkId][$cplId]['id'];
        } else {
            // reset jika belum ada data
            $this->form['cpl_bk_mk'][$bkId][$cplId] = [];
        }
    }

    public function openAddCplCpmkMk($cpmkId = null, $cplId = null)
    {
        $this->showModalCplCpmkMK = true;

        $cpl = $this->getCapaianPembelajaranLulusansProperty()
            ->firstWhere('id', $cplId);

        $cpmk = $this->getCapaianPembelajaranMatakuliahsProperty()
            ->firstWhere('id', $cpmkId);

        $this->tempSelectCplCpmkMK = [
            'cpl' => [
                'id' => $cpl?->id,
                'code' => $cpl?->code,
            ],
            'cpmk' => [
                'id' => $cpmk?->id,
                'code' => $cpmk?->code,
            ],
        ];

        // 🔥 inject data lama
        if (isset($this->setTempSelectCplCpmkMK[$cpmkId][$cplId]['id'])) {
            $this->form['cpl_cpmk_mk'][$cpmkId][$cplId]
                = $this->setTempSelectCplCpmkMK[$cpmkId][$cplId]['id'];
        } else {
            $this->form['cpl_cpmk_mk'][$cpmkId][$cplId] = [];
        }

    }


    public function openAddCpmkMK($cpmkId = null)
    {
        $this->showModalCpmkMK = true;

        $cpmk = $this->getCapaianPembelajaranMatakuliahsProperty()
            ->firstWhere('id', $cpmkId);

        $this->tempSelectCpmkMK = [
            'cpmk' => [
                'id' => $cpmk?->id,
                'code' => $cpmk?->code,
            ],
        ];

        /**
         * 🔥 inject data lama
         */
        if (isset($this->setTempSelectCpmkMK[$cpmkId]['id'])) {
            $this->form['cpmk_mk'][$cpmkId]
                = $this->setTempSelectCpmkMK[$cpmkId]['id'];
        } else {
            $this->form['cpmk_mk'][$cpmkId] = [];
        }
    }

    public function openAddBkMk($bkId)
    {
        $this->showModalBkMK = true;

        $bk = $this->getBahanKajiansProperty()
            ->firstWhere('id', $bkId);

        $this->tempSelectBkMK = [
            'bk' => [
                'id' => $bk?->id,
                'code' => $bk?->code,
                'name' => $bk?->name,
            ],
        ];

        /**
         * 🔥 Inject data lama jika ada
         */
        if (isset($this->setTempSelectBkMK[$bkId]['id'])) {
            $this->form['bk_mk'][$bkId]
                = $this->setTempSelectBkMK[$bkId]['id'];
        } else {
            $this->form['bk_mk'][$bkId] = [];
        }
    }
    public function setCpmkMK()
    {
        $cpmkId = $this->tempSelectCpmkMK['cpmk']['id'];

        $selectedMkIds = $this->form['cpmk_mk'][$cpmkId] ?? [];

        $selectedMks = $this->getMatakuliahsProperty()
            ->whereIn('id', $selectedMkIds);

        $this->setTempSelectCpmkMK[$cpmkId] = [
            'id' => $selectedMkIds,
            'code' => $selectedMks->pluck('code')->values()->toArray(),
        ];

        $this->showModalCpmkMK = false;
    }
    public function setBkMk()
    {
        $bkId = $this->tempSelectBkMK['bk']['id'];

        $selectedMkIds = $this->form['bk_mk'][$bkId] ?? [];

        $selectedMks = $this->getMatakuliahsProperty()
            ->whereIn('id', $selectedMkIds);

        $this->setTempSelectBkMK[$bkId] = [
            'id' => $selectedMkIds,
            'code' => $selectedMks->pluck('code')->values()->toArray(),
        ];

        // Close modal
        $this->showModalBkMK = false;
    }
    public function setCplBkMK()
    {

        $bkId = $this->tempSelectCplBkMK['bk']['id'];
        $cplId = $this->tempSelectCplBkMK['cpl']['id'];

        $selectedMkIds = $this->form['cpl_bk_mk'][$bkId][$cplId] ?? [];

        $selectedMks = $this->getMatakuliahsProperty()
            ->whereIn('id', $selectedMkIds);

        $this->setTempSelectCplBkMK[$bkId][$cplId] = [
            'id' => $selectedMkIds,
            'code' => $selectedMks->pluck('code')->values()->toArray(),
        ];

        // ✅ close modal
        $this->showModalCplBkMK = false;
    }

    public function setCplCpmkMK()
    {
        $cpmkId = $this->tempSelectCplCpmkMK['cpmk']['id'];
        $cplId = $this->tempSelectCplCpmkMK['cpl']['id'];
        $selectedMkIds = $this->form['cpl_cpmk_mk'][$cpmkId][$cplId] ?? [];

        $selectedMks = $this->getMatakuliahsProperty()
            ->whereIn('id', $selectedMkIds);

        $this->setTempSelectCplCpmkMK[$cpmkId][$cplId] = [
            'id' => $selectedMkIds,
            'code' => $selectedMks->pluck('code')->values()->toArray(),
        ];

        $this->showModalCplCpmkMK = false;
    }

    public function mount($id = null)
    {
        // $this->form['programStudis'] = [1];
        $this->selectedId = $id;
        if ($id) {
            $this->openEdits($this->selectedId);
        }

    }
    protected function model(): string
    {
        return Kurikulum::class;
    }

    public function rules(): array
    {
        return [
            'form.name' => 'required|string',
            'form.year' => 'required|string',
            'form.version' => 'required|string',
            'form.type' => 'required|string',
            'form.programStudis' => 'required|min:1',
            'form.programStudis.*' => 'exists:program_studis,id',
            // 'form.cpl_pl' => 'required|array|min:1',
            // 'form.cpl_pl.*' => 'required',
        ];
    }
    protected function openEdits(int $id): void
    {
        $kurikulum = Kurikulum::with([
            'programStudis:id,name,code',
            'pivotPlCpl:id,kurikulum_id,pl_id,cpl_id',
            'pivotCplBk:id,kurikulum_id,bk_id,cpl_id',
            'pivotBkMk:id,kurikulum_id,bk_id,mk_id',
            'pivotCpmkSubCpmk:id,kurikulum_id,cpmk_id,subcpmk_id',
            'pivotCplMk:id,kurikulum_id,cpl_id,mk_id',
            'pivotCpmkMk:id,kurikulum_id,cpmk_id,mk_id',
            'pivotCplBkMk:id,kurikulum_id,cpl_id,bk_id,mk_id',
            'pivotCplCpmkMk:id,kurikulum_id,cpl_id,cpmk_id,mk_id',
        ])->findOrFail($id);

        // dump($kurikulum->programStudis->id);

        // Bind metadata ke form
        $this->form['name'] = $kurikulum->name;
        $this->form['year'] = $kurikulum->year;
        $this->form['version'] = $kurikulum->version;
        $this->form['type'] = $kurikulum->type;
        $this->form['status'] = $kurikulum->status;
        $this->form['created_by'] = $kurikulum->created_by;
        $this->form['programStudis'] = $kurikulum->programStudis->id;

        // Reset pivot forms
        $this->form['cpl_pl'] = [];
        $this->form['bk_cpl'] = [];
        $this->form['bk_mk'] = [];
        $this->form['cpmk_subcpmk'] = [];
        $this->form['mk_cpl'] = [];
        $this->form['cpmk_mk'] = [];
        $this->form['cpl_bk_mk'] = [];
        $this->form['cpl_cpmk_mk'] = [];
        // Bind pivot CPL ↔ PL
        foreach ($kurikulum->pivotPlCpl as $pivot) {
            $this->form['cpl_pl'][$pivot->cpl_id][] = $pivot->pl_id;
        }

        // Bind pivot BK ↔ CPL
        foreach ($kurikulum->pivotCplBk as $pivot) {
            $this->form['bk_cpl'][$pivot->bk_id][] = $pivot->cpl_id;
        }

        // Bind pivot BK ↔ MK
        foreach ($kurikulum->pivotBkMk as $pivot) {
            $this->form['bk_mk'][$pivot->bk_id][] = $pivot->mk_id;
        }

        dump($this->form['bk_mk']);

        // Bind pivot CPMK ↔ SubCPMK
        foreach ($kurikulum->pivotCpmkSubCpmk as $pivot) {
            $this->form['cpmk_subcpmk'][$pivot->cpmk_id][] = $pivot->subcpmk_id;
        }

        // Bind pivot MK ↔ CPL
        foreach ($kurikulum->pivotCplMk as $pivot) {
            $this->form['mk_cpl'][$pivot->mk_id][] = $pivot->cpl_id;
        }

        // Bind pivot CPMK ↔ MK
        foreach ($kurikulum->pivotCpmkMk as $pivot) {
            $this->form['cpmk_mk'][$pivot->cpmk_id][] = $pivot->mk_id;
        }

        // Bind pivot CPL ↔ BK ↔ MK
        foreach ($kurikulum->pivotCplBkMk as $pivot) {
            $this->form['cpl_bk_mk'][$pivot->bk_id][$pivot->cpl_id][] = $pivot->mk_id;
        }

        // Bind pivot CPL ↔ CPMK ↔ MK
        $kurikulum->pivotCplCpmkMk()
            ->where('kurikulum_id', $id)
            ->get()
            ->each(function ($pivot) {
                $this->form['cpl_cpmk_mk'][$pivot->cpmk_id][$pivot->cpl_id][] = $pivot->mk_id;
            });

        // Simpan sementara ke setTempSelect agar modal bisa membaca data lama
        $this->setTempSelectCpmkMK = $this->form['cpmk_mk'];
        $this->setTempSelectBkMK = $this->form['bk_mk'];
        $this->setTempSelectCplBkMK = $this->form['cpl_bk_mk'];
        $this->setTempSelectCplCpmkMK = $this->form['cpl_cpmk_mk'];
    }

    public function previewData($cloneKurikulumId = null)
    {
        // Set user & status default
        $this->form['created_by'] = auth()->user()->id;
        $this->form['status'] = 'draft';

        // Metadata Kurikulum
        $dataMetaDataKurikulum = [
            'prodi_id' => $this->form['programStudis'][0] ?? null,
            'name' => $this->form['name'],
            'year' => $this->form['year'],
            'version' => $this->form['version'],
            'type' => $this->form['type'],
            'status' => $this->form['status'],
            'created_by' => $this->form['created_by'],
            'parent_id' => $cloneKurikulumId, // jika clone
        ];

        // Buat Kurikulum baru atau clone
        $kurikulum = Kurikulum::create($dataMetaDataKurikulum);

        $kurikulumId = $kurikulum->id;

        // === Pivot PL <-> CPL ===
        foreach ($this->form['cpl_pl'] as $cplId => $plIds) {
            foreach ((array) $plIds as $plId) {
                $kurikulum->pivotPlCpl()->create([
                    'kurikulum_id' => $kurikulumId,
                    'pl_id' => $plId,
                    'cpl_id' => $cplId,
                ]);
            }
        }

        // === Pivot CPL <-> BK ===
        foreach ($this->form['bk_cpl'] as $bkId => $cplIds) {
            foreach ((array) $cplIds as $cplId) {
                $kurikulum->pivotCplBk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpl_id' => $cplId,
                    'bk_id' => $bkId,
                ]);
            }
        }

        // === Pivot BK <-> MK ===
        foreach ($this->form['bk_mk'] as $bkId => $mkIds) {
            foreach ((array) $mkIds as $mkId) {
                $kurikulum->pivotBkMk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'bk_id' => $bkId,
                    'mk_id' => $mkId,
                ]);
            }
        }

        // === Pivot CPMK <-> SubCPMK ===
        foreach ($this->form['cpmk_subcpmk'] as $cpmkId => $subcpmkIds) {
            foreach ((array) $subcpmkIds as $subcpmkId) {
                $kurikulum->pivotCpmkSubcpmk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpmk_id' => $cpmkId,
                    'subcpmk_id' => $subcpmkId,
                ]);
            }
        }

        // === Pivot CPL <-> MK ===
        foreach ($this->form['mk_cpl'] as $mkId => $cplIds) {
            foreach ((array) $cplIds as $cplId) {
                $kurikulum->pivotCplMk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpl_id' => $cplId,
                    'mk_id' => $mkId,
                ]);
            }
        }

        // === Pivot CPMK <-> MK ===
        foreach ($this->form['cpmk_mk'] as $cpmkId => $mkIds) {
            foreach ((array) $mkIds as $mkId) {
                $kurikulum->pivotCpmkMk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpmk_id' => $cpmkId,
                    'mk_id' => $mkId,
                ]);
            }
        }

        // === Pivot CPL <-> BK <-> MK ===
        foreach ($this->form['cpl_bk_mk'] as $bkId => $cplArr) {
            foreach ($cplArr as $cplId => $mkIds) {
                foreach ((array) $mkIds as $mkId) {
                    $kurikulum->pivotCplBkMk()->create([
                        'kurikulum_id' => $kurikulumId,
                        'cpl_id' => $cplId,
                        'bk_id' => $bkId,
                        'mk_id' => $mkId,
                    ]);
                }
            }
        }

        // === Pivot CPL <-> CPMK <-> MK ===
        foreach ($this->form['cpl_cpmk_mk'] as $cpmkId => $cplArr) {
            foreach ($cplArr as $cplId => $mkIds) {
                foreach ((array) $mkIds as $mkId) {
                    $kurikulum->pivotCplCpmkMk()->create([
                        'kurikulum_id' => $kurikulumId,
                        'cpl_id' => $cplId,
                        'cpmk_id' => $cpmkId,
                        'mk_id' => $mkId,
                    ]);
                }
            }
        }

        // Return object kurikulum baru/clone untuk preview
        return $kurikulum;
    }


    protected function beforeSaves(string $action, ?int $cloneKurikulumId = null)
    {
        // Set user & status default
        $this->form['created_by'] = auth()->user()->id;
        $this->form['status'] = 'draft';

        // Metadata Kurikulum
        $dataMetaDataKurikulum = [
            'prodi_id' => $this->form['programStudis'][0] ?? null,
            'name' => $this->form['name'],
            'year' => $this->form['year'],
            'version' => $this->form['version'],
            'type' => $this->form['type'],
            'status' => $this->form['status'],
            'created_by' => $this->form['created_by'],
            'parent_id' => $cloneKurikulumId, // jika clone
        ];

        // Buat Kurikulum baru / revisi
        $kurikulum = Kurikulum::create($dataMetaDataKurikulum);
        $kurikulumId = $kurikulum->id;

        // ===========================
        // Simpan semua pivot
        // ===========================

        foreach ($this->form['cpl_pl'] as $cplId => $plIds) {
            foreach ((array) $plIds as $plId) {
                $kurikulum->pivotPlCpl()->create([
                    'kurikulum_id' => $kurikulumId,
                    'pl_id' => $plId,
                    'cpl_id' => $cplId,
                ]);
            }
        }

        foreach ($this->form['bk_cpl'] as $bkId => $cplIds) {
            foreach ((array) $cplIds as $cplId) {
                $kurikulum->pivotCplBk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpl_id' => $cplId,
                    'bk_id' => $bkId,
                ]);
            }
        }

        foreach ($this->form['bk_mk'] as $bkId => $mkIds) {
            foreach ((array) $mkIds as $mkId) {
                $kurikulum->pivotBkMk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'bk_id' => $bkId,
                    'mk_id' => $mkId,
                ]);
            }
        }

        foreach ($this->form['cpmk_subcpmk'] as $cpmkId => $subcpmkIds) {
            foreach ((array) $subcpmkIds as $subcpmkId) {
                $kurikulum->pivotCpmkSubcpmk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpmk_id' => $cpmkId,
                    'subcpmk_id' => $subcpmkId,
                ]);
            }
        }

        foreach ($this->form['mk_cpl'] as $mkId => $cplIds) {
            foreach ((array) $cplIds as $cplId) {
                $kurikulum->pivotCplMk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpl_id' => $cplId,
                    'mk_id' => $mkId,
                ]);
            }
        }

        foreach ($this->form['cpmk_mk'] as $cpmkId => $mkIds) {
            foreach ((array) $mkIds as $mkId) {
                $kurikulum->pivotCpmkMk()->create([
                    'kurikulum_id' => $kurikulumId,
                    'cpmk_id' => $cpmkId,
                    'mk_id' => $mkId,
                ]);
            }
        }

        foreach ($this->form['cpl_bk_mk'] as $bkId => $cplArr) {
            foreach ($cplArr as $cplId => $mkIds) {
                foreach ((array) $mkIds as $mkId) {
                    $kurikulum->pivotCplBkMk()->create([
                        'kurikulum_id' => $kurikulumId,
                        'cpl_id' => $cplId,
                        'bk_id' => $bkId,
                        'mk_id' => $mkId,
                    ]);
                }
            }
        }

        foreach ($this->form['cpl_cpmk_mk'] as $cpmkId => $cplArr) {
            foreach ($cplArr as $cplId => $mkIds) {
                foreach ((array) $mkIds as $mkId) {
                    $kurikulum->pivotCplCpmkMk()->create([
                        'kurikulum_id' => $kurikulumId,
                        'cpl_id' => $cplId,
                        'cpmk_id' => $cpmkId,
                        'mk_id' => $mkId,
                    ]);
                }
            }
        }

        // 🔥 opsional: kembalikan kurikulum baru
        return $kurikulum;
    }
    public function saveKurikulum()
    {
        // Validasi form metadata sebelum simpan
        $this->validate($this->rules());

        // Jalankan beforeSave untuk menyimpan Kurikulum beserta semua pivot
        $kurikulum = $this->beforeSaves(
            $this->selectedId ? 'updated' : 'created',
            $this->selectedId
        );

        // Optional: notifikasi berhasil
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Sukses!',
            'description' => "Data berhasil" . $this->selectedId ? 'diupdate' : 'disimpan' . '.',
            'timeout' => 2500
        ]);

        // Redirect ke list kurikulum atau detail kurikulum
        return redirect()->route('kurikulum.index');
    }
    protected function cloneKurikulum(int $id): void
    {
        $old = Kurikulum::with([
            'pivotPlCpl',
            'pivotCplBk',
            'pivotBkMk',
            'pivotCpmkSubCpmk',
            'pivotMkCpl',
            'pivotCpmkMk',
            'pivotCplBkMk',
            'pivotCplCpmkMk',
        ])->findOrFail($id);

        // 1️⃣ Buat kurikulum baru sebagai clone
        $new = Kurikulum::create([
            'prodi_id' => $old->prodi_id,
            'name' => $old->name,
            'year' => $old->year,
            'version' => $old->version,
            'parent_id' => $old->id, // parent = kurikulum lama
            'type' => $old->type,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        $kurikulumId = $new->id;

        // 2️⃣ Copy pivot CPL ↔ PL
        foreach ($old->pivotPlCpl as $pivot) {
            $new->pivotPlCpl()->create([
                'kurikulum_id' => $kurikulumId,
                'pl_id' => $pivot->pl_id,
                'cpl_id' => $pivot->cpl_id,
            ]);
        }

        // 3️⃣ Copy pivot BK ↔ CPL
        foreach ($old->pivotCplBk as $pivot) {
            $new->pivotCplBk()->create([
                'kurikulum_id' => $kurikulumId,
                'bk_id' => $pivot->bk_id,
                'cpl_id' => $pivot->cpl_id,
            ]);
        }

        // 4️⃣ Copy pivot BK ↔ MK
        foreach ($old->pivotBkMk as $pivot) {
            $new->pivotBkMk()->create([
                'kurikulum_id' => $kurikulumId,
                'bk_id' => $pivot->bk_id,
                'mk_id' => $pivot->mk_id,
            ]);
        }

        // 5️⃣ Copy pivot CPMK ↔ SubCPMK
        foreach ($old->pivotCpmkSubCpmk as $pivot) {
            $new->pivotCpmkSubCpmk()->create([
                'kurikulum_id' => $kurikulumId,
                'cpmk_id' => $pivot->cpmk_id,
                'subcpmk_id' => $pivot->subcpmk_id,
            ]);
        }

        // 6️⃣ Copy pivot MK ↔ CPL
        foreach ($old->pivotMkCpl as $pivot) {
            $new->pivotMkCpl()->create([
                'kurikulum_id' => $kurikulumId,
                'mk_id' => $pivot->mk_id,
                'cpl_id' => $pivot->cpl_id,
            ]);
        }

        // 7️⃣ Copy pivot CPMK ↔ MK
        foreach ($old->pivotCpmkMk as $pivot) {
            $new->pivotCpmkMk()->create([
                'kurikulum_id' => $kurikulumId,
                'cpmk_id' => $pivot->cpmk_id,
                'mk_id' => $pivot->mk_id,
            ]);
        }

        // 8️⃣ Copy pivot CPL ↔ BK ↔ MK
        foreach ($old->pivotCplBkMk as $pivot) {
            $new->pivotCplBkMk()->create([
                'kurikulum_id' => $kurikulumId,
                'cpl_id' => $pivot->cpl_id,
                'bk_id' => $pivot->bk_id,
                'mk_id' => $pivot->mk_id,
            ]);
        }

        // 9️⃣ Copy pivot CPL ↔ CPMK ↔ MK
        foreach ($old->pivotCplCpmkMk as $pivot) {
            $new->pivotCplCpmkMk()->create([
                'kurikulum_id' => $kurikulumId,
                'cpl_id' => $pivot->cpl_id,
                'cpmk_id' => $pivot->cpmk_id,
                'mk_id' => $pivot->mk_id,
            ]);
        }

        // 10️⃣ Bind ke form
        $this->mount($kurikulumId);
    }


    public function getProdiProperty()
    {
        return ProgramStudi::all();
    }
    public function render()
    {
        return view('livewire.kurikulum.create-update');
    }
}
