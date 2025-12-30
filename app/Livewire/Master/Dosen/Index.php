<?php

namespace App\Livewire\Master\Dosen;

use App\Livewire\Base\BaseTable;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use App\Repositories\ApiClientRepository;
use App\Services\UserCreatorService;
use Flux\Flux;
use App\Models\ProgramStudi;
use App\Models\Dosen as DSN;
use App\Models\User;
#[Title('Dosen')]
#[Layout('components.layouts.sidebar')]

class Index extends BaseTable
{
    public string $title = 'Dosen';
    protected string $apiUrl = "https://siak.poltek-kampar.ac.id/data_dosen/apidosen";
    public array $filter = [
        'prodi' => null
    ];
    protected static string $model = DSN::class;
    protected static string $view = 'livewire.master.dosen.index';

    public array $relations = ['programStudis'];
    protected array $filterable = [
        'prodi' => ['type' => 'relation', 'relation' => 'programStudis', 'column' => 'program_studis.id'],
    ];
    protected array $searchable = [
        'nrp',
        'nidn',
        'name',
        'email'
    ];

    public array $dataApi = [];

    public function getProdiOptionsProperty()
    {
        return ProgramStudi::query()
            ->orderBy('name')
            ->get(['id', 'name', 'jenjang']);
    }

    public function openModal()
    {
        $this->dataApi = [];
        $this->modal()->open('simpleModal');
        // Flux::modal('edit-profile')->show();
    }

    public function getDataFromApi(ApiClientRepository $api)
    {
        $response = $api->get($this->apiUrl);

        if (empty($response)) {
            $this->notification()->send([
                'icon' => 'error',
                'title' => 'Error Notification!',
                'description' => 'Gagal mengambil data dari API (timeout). Coba lagi nanti',
            ]);
            return;
        }

        $this->dataApi = collect($response)->map(fn($item) => [
            'nrp' => $item['nrp'],
            'nidn' => $item['nidn'],
            'name' => $item['nama_dsn'],
            'email' => $item['email'],
            'gender' => $item['jenis_k'] == 'L' ? 'Laki-laki' : 'Perempuan',
            'programStudis' => [$item['prodi_id']],
        ])->toArray();
    }

    public function syncToDatabase()
    {
        $userService = new UserCreatorService();

        DSN::upsert(
            collect($this->dataApi)
                ->map(fn($item) => [
                    'nrp' => $item['nrp'],
                    'nidn' => $item['nidn'],
                    'name' => $item['name'],
                    'email' => $item['email'],
                    'gender' => $item['gender'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->toArray(),
            ['nrp', 'nidn'], // unique keys
            ['name', 'email', 'gender', 'updated_at']
        );

        foreach ($this->dataApi as $item) {
            $dsn = DSN::where('nrp', $item['nrp'])
                ->orWhere('nidn', $item['nidn'])
                ->first();

            if (!$dsn)
                continue;
            $prodiIds = ProgramStudi::whereIn('code', $item['programStudis'])
                ->pluck('id')
                ->toArray();

            if (!empty($prodiIds)) {
                $dsn->programStudis()->sync($prodiIds);
            }
            // ⬇️ Create or retrieve user
            $user = $userService->createOrGet(
                email: $item['email'],
                name: $item['name']
            );

            // ⬇️ Attach pivot DSN → User
            $userService->attachToPivot($dsn, $user);

            // ⬇️ Assign default role (role_id=4)
            $userService->assignRoles($user, 4);
        }
        $this->notification()->send([
            'icon' => 'success',
            'title' => 'Success',
            'description' => 'Data Berhasil di sinkronkan',
        ]);

        $this->modal()->close('simpleModal');
    }
}
