<?php

namespace App\Http\Controllers;

use App\Models\PenjejakanPasca;
use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThesisController extends Controller
{
    /**
     * ================================================================
     * HALAMAN USER - TESIS
     * ================================================================
     *
     * Menampilkan tesis yang repository-nya:
     *
     * - sudah ditentukan sebagai thesis
     * - status repository = active
     *
     * Data karya berasal dari SIADMIN.
     * Data repository berasal dari SIPERPUS.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Query Data Tesis
        |--------------------------------------------------------------------------
        |
        | Data awal berasal dari penjejakan_pasca.
        |
        | Hanya data yang:
        |
        | - sudah selesai
        | - memiliki lampiran produk
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
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $theses = $query
            ->orderByDesc('tgl_sidang')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | User Data
        |--------------------------------------------------------------------------
        */

        $this->attachUserData($theses);


        /*
        |--------------------------------------------------------------------------
        | Repository
        |--------------------------------------------------------------------------
        */

        $this->attachRepositoryData($theses);


        /*
        |--------------------------------------------------------------------------
        | Filter Repository Aktif + Tesis
        |--------------------------------------------------------------------------
        |
        | User hanya boleh melihat repository yang sudah aktif.
        |
        */

        $theses = $theses
            ->filter(function ($thesis) {

                if (!$thesis->repository) {
                    return false;
                }

                return
                    $thesis->repository->jenis_karya === 'thesis'
                    &&
                    $thesis->repository->status === 'active';
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Pagination Manual
        |--------------------------------------------------------------------------
        |
        | Karena data berasal dari dua sumber dan repository
        | sudah digabung setelah query, pagination dilakukan
        | setelah proses filtering.
        |
        */

        $perPage = 12;

        $page = (int) $request->input(
            'page',
            1
        );

        $total = $theses->count();

        $paginated = $theses
            ->slice(
                ($page - 1) * $perPage,
                $perPage
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | AJAX
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return view(
                'theses._result',
                [
                    'theses' => $paginated,
                    'currentPage' => $page,
                    'lastPage' => max(
                        1,
                        (int) ceil(
                            $total / $perPage
                        )
                    ),
                    'total' => $total,
                ]
            )->render();
        }


        /*
        |--------------------------------------------------------------------------
        | Normal Request
        |--------------------------------------------------------------------------
        */

        return view(
            'theses.index',
            [
                'theses' => $paginated,

                'currentPage' => $page,

                'lastPage' => max(
                    1,
                    (int) ceil(
                        $total / $perPage
                    )
                ),

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
        | Cari SIADMIN
        |--------------------------------------------------------------------------
        */

        $query->where(function ($pascaQuery) use (
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
            | User
            |--------------------------------------------------------------------------
            */

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
    private function attachUserData($theses): void
    {
        /*
        |--------------------------------------------------------------------------
        | ID User
        |--------------------------------------------------------------------------
        */

        $userIds = $theses
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

            $theses->transform(function ($thesis) {

                $thesis->nim = '-';
                $thesis->nama = '-';

                return $thesis;
            });

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

        $theses->transform(
            function ($thesis) use ($users) {

                $user = $users->get(
                    $thesis->id_user
                );


                $thesis->nim =
                    $user->nomor_induk ?? '-';


                $thesis->nama =
                    $user->nama_lengkap ?? '-';


                return $thesis;
            }
        );
    }


    /**
     * ================================================================
     * REPOSITORY
     * ================================================================
     */
    private function attachRepositoryData($theses): void
    {
        /*
        |--------------------------------------------------------------------------
        | ID Pengajuan
        |--------------------------------------------------------------------------
        */

        $idPengajuan = $theses
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

            $theses->transform(
                function ($thesis) {

                    $thesis->repository = null;

                    return $thesis;
                }
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil Repository
        |--------------------------------------------------------------------------
        |
        | Tidak difilter jenis/status di query.
        |
        | Filter dilakukan setelah data digabung supaya
        | logikanya jelas:
        |
        | jenis_karya = thesis
        | status      = active
        |
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

        $theses->transform(
            function ($thesis) use ($repositories) {

                $thesis->repository =
                    $repositories->get(
                        $thesis->id_pengajuan
                    );

                return $thesis;
            }
        );
    }
}
