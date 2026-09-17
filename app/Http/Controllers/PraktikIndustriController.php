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

        $tahun = $request->input('tahun');

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
        */

        $laporan = PraktikIndustri::query()

            ->join(
                'detail_tims as dt_current',
                'dt_current.id',
                '=',
                'ujians.detail_tim_id'
            )

            ->select(
                'ujians.*'
            )

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

                    ->whereColumn(
                        'dt_lama.tim_id',
                        '=',
                        'dt_current.tim_id'
                    )

                    ->where(function ($query) {

                        $query->whereColumn(
                            'u_lama.created_at',
                            '>',
                            'ujians.created_at'
                        )

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


            ->with([

                'detailTim.tim',

                'detailTim.tim.industri',

                'detailTim.tim.ketua',

                'detailTim.tim.detailTims.user',

                'fileTerbaru',

            ])


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

                            if ($filter === 'judul') {

                                $query->where(
                                    'ujians.judul',
                                    'like',
                                    "%{$search}%"
                                );
                            } elseif ($filter === 'industri') {

                                $query->whereHas(
                                    'detailTim.tim.industri',
                                    function ($industriQuery) use ($search) {

                                        $industriQuery->where(
                                            'nama',
                                            'like',
                                            "%{$search}%"
                                        );
                                    }
                                );
                            } elseif ($filter === 'nama') {

                                if ($userIds->isNotEmpty()) {

                                    $query->whereHas(
                                        'detailTim.tim',
                                        function ($timQuery) use ($userIds) {

                                            $timQuery->whereIn(
                                                'ketua_user_id',
                                                $userIds
                                            );
                                        }
                                    );

                                    $query->orWhereHas(
                                        'detailTim.tim.detailTims',
                                        function ($detailTimQuery) use ($userIds) {

                                            $detailTimQuery->whereIn(
                                                'user_id',
                                                $userIds
                                            );
                                        }
                                    );
                                } else {

                                    $query->whereRaw('1 = 0');
                                }
                            }
                        }
                    );
                }
            )


            /*
            |--------------------------------------------------------------------------
            | FILTER: TAHUN
            |--------------------------------------------------------------------------
            */

            ->when(
                filled($tahun),
                function ($query) use ($tahun) {

                    $query->whereYear(
                        'ujians.created_at',
                        $tahun
                    );
                }
            )


            ->orderByDesc(
                'ujians.created_at'
            )

            ->orderByDesc(
                'ujians.id'
            )

            ->paginate(12)

            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | RESPONSE AJAX
        |--------------------------------------------------------------------------
        |
        | Kalau request datang dari fetch() di praktik-industri.js (ditandai
        | header X-Requested-With), cukup balikin partial _result saja. Sebelum
        | ini, controller selalu balikin full page (hero, search card, modal PDF
        | viewer, @vite) untuk SETIAP pencarian AJAX — jauh lebih berat, dan
        | rentan gagal kalau ada bagian halaman yang tidak dibutuhkan justru
        | error saat dirender ulang.
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {
            return view('praktik-industri._result', [
                'laporan' => $laporan,
            ])->render();
        }


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
