<?php

namespace App\Http\Controllers;

use App\Models\PenjejakanPasca;
use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DisertasiController extends Controller
{
    /**
     * ================================================================
     * HALAMAN USER - DISERTASI
     * ================================================================
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query Data Disertasi
        |--------------------------------------------------------------------------
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
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $disertasis = $query
            ->orderByDesc('tgl_sidang')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | User Data
        |--------------------------------------------------------------------------
        */

        $this->attachUserData($disertasis);


        /*
        |--------------------------------------------------------------------------
        | Repository
        |--------------------------------------------------------------------------
        */

        $this->attachRepositoryData($disertasis);


        /*
        |--------------------------------------------------------------------------
        | Filter Repository Aktif + Disertasi
        |--------------------------------------------------------------------------
        */

        $disertasis = $disertasis
            ->filter(function ($disertasi) {

                if (!$disertasi->repository) {
                    return false;
                }

                return
                    $disertasi->repository->jenis_karya === 'dissertation'
                    &&
                    $disertasi->repository->status === 'active';
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Pagination Manual
        |--------------------------------------------------------------------------
        */

        $perPage = 12;

        $page = max(
            1,
            (int) $request->input('page', 1)
        );

        $total = $disertasis->count();

        $lastPage = max(
            1,
            (int) ceil($total / $perPage)
        );


        /*
        |--------------------------------------------------------------------------
        | Pastikan Page Tidak Melebihi Last Page
        |--------------------------------------------------------------------------
        */

        if ($page > $lastPage) {
            $page = $lastPage;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Data Sesuai Halaman
        |--------------------------------------------------------------------------
        */

        $paginated = $disertasis
            ->slice(
                ($page - 1) * $perPage,
                $perPage
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | AJAX REQUEST
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return view(
                'dissertations._result',
                [
                    /*
                    |--------------------------------------------------------------------------
                    | PENTING
                    |--------------------------------------------------------------------------
                    | Nama harus sama dengan yang digunakan
                    | di dissertations/_result.blade.php
                    */

                    'dissertations' => $paginated,

                    'currentPage' => $page,

                    'lastPage' => $lastPage,

                    'total' => $total,
                ]
            )->render();
        }


        /*
        |--------------------------------------------------------------------------
        | NORMAL REQUEST
        |--------------------------------------------------------------------------
        */

        return view(
            'dissertations.index',
            [
                /*
                |--------------------------------------------------------------------------
                | PENTING
                |--------------------------------------------------------------------------
                */

                'dissertations' => $paginated,

                'currentPage' => $page,

                'lastPage' => $lastPage,

                'total' => $total,
            ]
        );
    }


    /**
     * ================================================================
     * SEARCH
     * ================================================================
     */
    private function applySearch(
        $query,
        Request $request
    ): void {

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
        | Cari User
        |--------------------------------------------------------------------------
        */

        $userIds = DB::connection('master')
            ->table('user')
            ->where(function ($userQuery) use ($search) {

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
            })
            ->pluck('user_id');


        /*
        |--------------------------------------------------------------------------
        | Cari Data SIADMIN
        |--------------------------------------------------------------------------
        */

        $query->where(function ($pascaQuery) use (
            $search,
            $userIds
        ) {

            $pascaQuery->where(
                'judul_karya',
                'like',
                "%{$search}%"
            );


            $pascaQuery->orWhere(
                'id_user',
                'like',
                "%{$search}%"
            );


            if ($userIds->isNotEmpty()) {

                $pascaQuery->orWhereIn(
                    'id_user',
                    $userIds
                );
            }
        });
    }


    /**
     * ================================================================
     * USER DATA
     * ================================================================
     */
    private function attachUserData($disertasis): void
    {
        /*
        |--------------------------------------------------------------------------
        | ID User
        |--------------------------------------------------------------------------
        */

        $userIds = $disertasis
            ->pluck('id_user')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Tidak Ada User
        |--------------------------------------------------------------------------
        */

        if ($userIds->isEmpty()) {

            $disertasis->transform(
                function ($disertasi) {

                    $disertasi->nim = '-';

                    $disertasi->nama = '-';

                    return $disertasi;
                }
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil User
        |--------------------------------------------------------------------------
        */

        $users = DB::connection('master')
            ->table('user')
            ->whereIn(
                'user_id',
                $userIds
            )
            ->get([
                'user_id',
                'nomor_induk',
                'nama_lengkap',
            ])
            ->keyBy('user_id');


        /*
        |--------------------------------------------------------------------------
        | Gabungkan
        |--------------------------------------------------------------------------
        */

        $disertasis->transform(
            function ($disertasi) use ($users) {

                $user = $users->get(
                    $disertasi->id_user
                );


                $disertasi->nim =
                    $user->nomor_induk ?? '-';


                $disertasi->nama =
                    $user->nama_lengkap ?? '-';


                return $disertasi;
            }
        );
    }


    /**
     * ================================================================
     * REPOSITORY
     * ================================================================
     */
    private function attachRepositoryData($disertasis): void
    {
        /*
        |--------------------------------------------------------------------------
        | ID Pengajuan
        |--------------------------------------------------------------------------
        */

        $idPengajuan = $disertasis
            ->pluck('id_pengajuan')
            ->filter()
            ->unique()
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Tidak Ada ID Pengajuan
        |--------------------------------------------------------------------------
        */

        if ($idPengajuan->isEmpty()) {

            $disertasis->transform(
                function ($disertasi) {

                    $disertasi->repository = null;

                    return $disertasi;
                }
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Repository
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
        | Gabungkan
        |--------------------------------------------------------------------------
        */

        $disertasis->transform(
            function ($disertasi) use ($repositories) {

                $disertasi->repository =
                    $repositories->get(
                        $disertasi->id_pengajuan
                    );

                return $disertasi;
            }
        );
    }
}
