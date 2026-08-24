<?php

namespace App\Http\Controllers;

use App\Models\PraktikIndustri;
use App\Models\User;
use Illuminate\Http\Request;

class PraktikIndustriController extends Controller
{
    /**
     * Menampilkan laporan Praktik Industri.
     *
     * Aturan:
     *
     * - Satu kelompok hanya menampilkan satu laporan.
     * - Laporan yang ditampilkan adalah laporan terbaru.
     * - Laporan lama tetap berada di database.
     * - Database hanya digunakan untuk membaca data.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->input('search', '')
        );

        $filter = $request->input('filter', 'nama');

        /*
        |--------------------------------------------------------------------------
        | CARI USER DI DATABASE MASTER
        |--------------------------------------------------------------------------
        |
        | User berada di database master.
        | Digunakan untuk pencarian nama ketua dan anggota.
        |
        */

        $userIds = collect();

        if ($search !== '') {

            $userIds = User::query()
                ->where(
                    'nama_lengkap',
                    'like',
                    "%{$search}%"
                )
                ->pluck('user_id');
        }


        /*
        |--------------------------------------------------------------------------
        | QUERY LAPORAN TERBARU PER KELOMPOK
        |--------------------------------------------------------------------------
        |
        | Struktur:
        |
        | ujians.detail_tim_id
        |        ↓
        | detail_tims.id
        |        ↓
        | detail_tims.tim_id
        |
        | Setiap laporan akan dibandingkan dengan laporan
        | lain yang memiliki tim_id sama.
        |
        | Jika ada laporan yang lebih baru:
        |
        |     laporan lama → disembunyikan
        |
        | Jika tidak ada:
        |
        |     laporan terbaru → ditampilkan
        |
        */

        $laporan = PraktikIndustri::query()

            /*
            |--------------------------------------------------------------------------
            | HUBUNGKAN LAPORAN DENGAN TIM SAAT INI
            |--------------------------------------------------------------------------
            */

            ->join(
                'detail_tims as dt_current',
                'dt_current.id',
                '=',
                'ujians.detail_tim_id'
            )

            /*
            |--------------------------------------------------------------------------
            | PENTING
            |--------------------------------------------------------------------------
            |
            | Karena menggunakan JOIN, kita hanya mengambil
            | kolom dari tabel ujians agar model tetap normal.
            |
            */

            ->select(
                'ujians.*'
            )

            /*
            |--------------------------------------------------------------------------
            | AMBIL LAPORAN TERBARU PER TIM
            |--------------------------------------------------------------------------
            */

            ->whereNotExists(function ($query) {

                $query
                    ->selectRaw('1')

                    ->from(
                        'ujians as u_lama'
                    )

                    ->join(
                        'detail_tims as dt_lama',
                        'dt_lama.id',
                        '=',
                        'u_lama.detail_tim_id'
                    )

                    /*
                    |--------------------------------------------------------------------------
                    | KELOMPOK HARUS SAMA
                    |--------------------------------------------------------------------------
                    */

                    ->whereColumn(
                        'dt_lama.tim_id',
                        '=',
                        'dt_current.tim_id'
                    )

                    /*
                    |--------------------------------------------------------------------------
                    | LAPORAN PEMBANDING HARUS LEBIH BARU
                    |--------------------------------------------------------------------------
                    */

                    ->where(function ($query) {

                        /*
                        |--------------------------------------------------------------
                        | created_at lebih baru
                        |--------------------------------------------------------------
                        */

                        $query->whereColumn(
                            'u_lama.created_at',
                            '>',
                            'ujians.created_at'
                        )

                            /*
                        |--------------------------------------------------------------
                        | Jika created_at sama,
                        | ID lebih besar dianggap lebih baru.
                        |--------------------------------------------------------------
                        */

                            ->orWhere(function ($query) {

                                $query
                                    ->whereColumn(
                                        'u_lama.created_at',
                                        '=',
                                        'ujians.created_at'
                                    )
                                    ->whereColumn(
                                        'u_lama.id',
                                        '>',
                                        'ujians.id'
                                    );
                            });
                    });
            })


            /*
            |--------------------------------------------------------------------------
            | RELASI
            |--------------------------------------------------------------------------
            */

            ->with([

                'detailTim.tim',

                'detailTim.tim.industri',

                'detailTim.tim.ketua',

                'detailTim.tim.detailTims.user',

                'fileTerbaru',

            ])


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            */

            /*
|--------------------------------------------------------------------------
| SEARCH + FILTER
|--------------------------------------------------------------------------
*/

            ->when(
                $search !== '',
                function ($query) use (
                    $search,
                    $filter,
                    $userIds
                ) {

                    $query->where(
                        function ($query) use (
                            $search,
                            $filter,
                            $userIds
                        ) {

                            /*
                |--------------------------------------------------------------------------
                | FILTER: JUDUL
                |--------------------------------------------------------------------------
                */

                            if ($filter === 'judul') {

                                $query->where(
                                    'ujians.judul',
                                    'like',
                                    "%{$search}%"
                                );
                            }


                            /*
                |--------------------------------------------------------------------------
                | FILTER: INDUSTRI
                |--------------------------------------------------------------------------
                */ elseif ($filter === 'industri') {

                                $query->whereHas(
                                    'detailTim.tim.industri',
                                    function ($industriQuery) use ($search) {

                                        /*
                            | GANTI 'nama' jika nama kolom industri
                            | di database kamu berbeda.
                            */

                                        $industriQuery->where(
                                            'nama',
                                            'like',
                                            "%{$search}%"
                                        );
                                    }
                                );
                            }


                            /*
                |--------------------------------------------------------------------------
                | FILTER: NAMA
                |--------------------------------------------------------------------------
                */ elseif ($filter === 'nama') {

                                if ($userIds->isNotEmpty()) {

                                    /*
                        | Ketua
                        */

                                    $query->whereHas(
                                        'detailTim.tim',
                                        function ($timQuery) use ($userIds) {

                                            $timQuery->whereIn(
                                                'ketua_user_id',
                                                $userIds
                                            );
                                        }
                                    );


                                    /*
                        | Anggota
                        */

                                    $query->orWhereHas(
                                        'detailTim.tim.detailTims',
                                        function ($detailTimQuery) use ($userIds) {

                                            $detailTimQuery->whereIn(
                                                'user_id',
                                                $userIds
                                            );
                                        }
                                    );
                                }

                                /*
                    | Jika nama tidak ditemukan,
                    | paksa hasil menjadi kosong.
                    */ else {

                                    $query->whereRaw('1 = 0');
                                }
                            }
                        }
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | URUTKAN
            |--------------------------------------------------------------------------
            */

            ->orderByDesc(
                'ujians.created_at'
            )

            ->orderByDesc(
                'ujians.id'
            )


            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            ->paginate(12)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'praktik-industri.index',
            [
                'laporan' => $laporan,
                'search' => $search,
                'filter' => $filter,
            ]
        );
    }
}
