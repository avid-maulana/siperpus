<?php

namespace App\Http\Controllers;

use App\Models\PenjejakanPasca;
use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepositoryManagementController extends Controller
{
    /**
     * ================================================================
     * KELOLA REPOSITORY TESIS & DISERTASI
     * ================================================================
     *
     * Sumber data:
     *
     * 1. SIADMIN
     *    - penjejakan_pasca
     *
     * 2. MASTER
     *    - user
     *
     * 3. SIPERPUS
     *    - repositories
     *
     * Relasi:
     *
     * penjejakan_pasca.id_pengajuan
     *              ↓
     * repositories.id_pengajuan
     *
     * Jenis karya:
     *
     * - thesis
     * - dissertation
     * - null = belum ditentukan
     *
     * Kondisi repository:
     *
     * - tidak ada record      = belum ada repository
     * - needs_action           = perlu penanganan
     * - active                 = repository aktif
     */
    public function manage(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query utama SIADMIN
        |--------------------------------------------------------------------------
        |
        | Data yang ditampilkan adalah data yang sudah selesai sidang
        | dan memiliki lampiran produk.
        |
        */

        $query = PenjejakanPasca::query()
            ->where('status', '4')
            ->whereNotNull('lampiran_produk')
            ->where('lampiran_produk', '!=', '');


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        $this->applySearch($query, $request);


        /*
        |--------------------------------------------------------------------------
        | Ambil semua data
        |--------------------------------------------------------------------------
        |
        | Untuk halaman management kita membutuhkan pembagian:
        |
        | 1. Perlu Penanganan
        | 2. Belum Ada Repository
        | 3. Repository Aktif
        |
        */

        $data = $query
            ->orderByDesc('tgl_sidang')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Gabungkan data mahasiswa
        |--------------------------------------------------------------------------
        */

        $this->attachUserData($data);


        /*
        |--------------------------------------------------------------------------
        | Gabungkan data repository
        |--------------------------------------------------------------------------
        */

        $this->attachRepositoryData($data);


        /*
        |--------------------------------------------------------------------------
        | Filter Jenis Karya
        |--------------------------------------------------------------------------
        |
        | Filter dilakukan SETELAH repository digabung karena:
        |
        | jenis_karya berada di tabel repositories.
        |
        */

        $jenis = $request->input('jenis');


        if (
            in_array(
                $jenis,
                ['thesis', 'dissertation'],
                true
            )
        ) {
            $data = $data->filter(
                function ($item) use ($jenis) {

                    return optional(
                        $item->repository
                    )->jenis_karya === $jenis;
                }
            )->values();
        }


        /*
        |--------------------------------------------------------------------------
        | Pisahkan berdasarkan kondisi repository
        |--------------------------------------------------------------------------
        */


        /*
        |--------------------------------------------------------------------------
        | 1. PERLU PENANGANAN
        |--------------------------------------------------------------------------
        */

        $needsAction = $data
            ->filter(
                function ($item) {

                    return $item->repository
                        && $item->repository->status === 'needs_action';
                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | 2. BELUM ADA REPOSITORY
        |--------------------------------------------------------------------------
        */

        $withoutRepository = $data
            ->filter(
                function ($item) {

                    return !$item->repository;
                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | 3. REPOSITORY AKTIF
        |--------------------------------------------------------------------------
        */

        $active = $data
            ->filter(
                function ($item) {

                    return $item->repository
                        && $item->repository->status === 'active';
                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        |
        | Untuk pencarian/filter AJAX, kita kirim ulang partial table.
        |
        */

        if ($request->ajax()) {

            return view(
                'library.repositories._table',
                [
                    'needsAction' => $needsAction,
                    'withoutRepository' => $withoutRepository,
                    'active' => $active,
                ]
            )->render();
        }


        /*
        |--------------------------------------------------------------------------
        | Normal Request
        |--------------------------------------------------------------------------
        */

        return view(
            'library.repositories.manage',
            [
                'needsAction' => $needsAction,
                'withoutRepository' => $withoutRepository,
                'active' => $active,

                /*
                |--------------------------------------------------------------------------
                | Filter
                |--------------------------------------------------------------------------
                */

                'jenis' => $jenis,

                /*
                |--------------------------------------------------------------------------
                | Total
                |--------------------------------------------------------------------------
                */

                'totalNeedsAction' =>
                $needsAction->count(),

                'totalWithoutRepository' =>
                $withoutRepository->count(),

                'totalActive' =>
                $active->count(),
            ]
        );
    }


    /**
     * ================================================================
     * SEARCH
     * ================================================================
     *
     * Pencarian:
     *
     * - judul karya
     * - ID user
     * - NIM
     * - nama mahasiswa
     */
    private function applySearch($query, Request $request): void
    {
        if (!$request->filled('search')) {
            return;
        }


        $search = trim(
            $request->input('search')
        );


        if ($search === '') {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Cari user pada database master
        |--------------------------------------------------------------------------
        */

        $userIds = DB::connection('master')
            ->table('user')
            ->where(
                function ($userQuery) use ($search) {

                    $userQuery
                        ->where(
                            'user_id',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'nomor_induk',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'nama_lengkap',
                            'like',
                            "%{$search}%"
                        );
                }
            )
            ->pluck('user_id');


        /*
        |--------------------------------------------------------------------------
        | Cari data SIADMIN
        |--------------------------------------------------------------------------
        */

        $query->where(
            function ($pascaQuery) use (
                $search,
                $userIds
            ) {

                /*
                |--------------------------------------------------------------------------
                | Judul
                |--------------------------------------------------------------------------
                */

                $pascaQuery->where(
                    'judul_karya',
                    'like',
                    "%{$search}%"
                );


                /*
                |--------------------------------------------------------------------------
                | ID User
                |--------------------------------------------------------------------------
                */

                $pascaQuery->orWhere(
                    'id_user',
                    'like',
                    "%{$search}%"
                );


                /*
                |--------------------------------------------------------------------------
                | User dari database master
                |--------------------------------------------------------------------------
                */

                if ($userIds->isNotEmpty()) {

                    $pascaQuery->orWhereIn(
                        'id_user',
                        $userIds
                    );
                }
            }
        );
    }


    /**
     * ================================================================
     * ATTACH USER DATA
     * ================================================================
     */
    private function attachUserData($data): void
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil ID User
        |--------------------------------------------------------------------------
        */

        $userIds = $data
            ->pluck('id_user')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Tidak ada user
        |--------------------------------------------------------------------------
        */

        if ($userIds->isEmpty()) {

            $data->transform(
                function ($item) {

                    $item->nim = '-';
                    $item->nama = '-';

                    return $item;
                }
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil data user dari database master
        |--------------------------------------------------------------------------
        */

        $users = DB::connection('master')
            ->table('user')
            ->whereIn(
                'user_id',
                $userIds
            )
            ->get(
                [
                    'user_id',
                    'nomor_induk',
                    'nama_lengkap',
                ]
            )
            ->keyBy('user_id');


        /*
        |--------------------------------------------------------------------------
        | Gabungkan
        |--------------------------------------------------------------------------
        */

        $data->transform(
            function ($item) use ($users) {

                $user = $users->get(
                    $item->id_user
                );


                $item->nim =
                    $user->nomor_induk ?? '-';


                $item->nama =
                    $user->nama_lengkap ?? '-';


                return $item;
            }
        );
    }


    /**
     * ================================================================
     * ATTACH REPOSITORY DATA
     * ================================================================
     */
    private function attachRepositoryData($data): void
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil ID Pengajuan
        |--------------------------------------------------------------------------
        */

        $idPengajuan = $data
            ->pluck('id_pengajuan')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Tidak ada ID Pengajuan
        |--------------------------------------------------------------------------
        */

        if ($idPengajuan->isEmpty()) {

            $data->transform(
                function ($item) {

                    $item->repository = null;

                    return $item;
                }
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil repository SIPERPUS
        |--------------------------------------------------------------------------
        */

        $repositories = Repository::query()
            ->whereIn(
                'id_pengajuan',
                $idPengajuan
            )
            ->get()
            ->keyBy('id_pengajuan');


        /*
        |--------------------------------------------------------------------------
        | Gabungkan repository
        |--------------------------------------------------------------------------
        */

        $data->transform(
            function ($item) use ($repositories) {

                $item->repository =
                    $repositories->get(
                        $item->id_pengajuan
                    );


                return $item;
            }
        );
    }
}
