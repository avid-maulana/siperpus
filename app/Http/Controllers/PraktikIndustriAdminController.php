<?php

namespace App\Http\Controllers;

use App\Models\PraktikIndustri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PraktikIndustriAdminController extends Controller
{
    /**
     * Halaman kelola laporan Praktik Industri untuk admin.
     *
     * ALGORITMA:
     *
     * 1. Ambil seluruh laporan Praktik Industri.
     * 2. Ambil data user dari database master untuk kebutuhan search.
     * 3. Cari laporan berdasarkan:
     *    - judul
     *    - nama ketua
     *    - nama anggota
     *    - nama industri
     * 4. Kelompokkan laporan berdasarkan tim.id.
     * 5. Semua detail_tim yang berada di tim yang sama
     *    dianggap sebagai satu kelompok.
     * 6. Laporan dengan created_at terbaru menjadi data utama.
     * 7. Data lainnya menjadi riwayat/duplikat.
     * 8. Tidak ada data yang dihapus.
     * 9. Pagination dilakukan setelah proses grouping.
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


        /*
        |--------------------------------------------------------------------------
        | CARI USER DI DATABASE MASTER
        |--------------------------------------------------------------------------
        |
        | User berada di database master.
        |
        | PraktikIndustri berada di database simpi.
        |
        | Oleh karena itu user_id dicari terlebih dahulu,
        | kemudian digunakan untuk filter ketua dan anggota.
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
        | QUERY LAPORAN
        |--------------------------------------------------------------------------
        */

        $laporan = PraktikIndustri::query()
            ->with([

                /*
                |--------------------------------------------------------------------------
                | DETAIL TIM
                |--------------------------------------------------------------------------
                */

                'detailTim.tim',

                /*
                |--------------------------------------------------------------------------
                | INDUSTRI
                |--------------------------------------------------------------------------
                */

                'detailTim.tim.industri',

                /*
                |--------------------------------------------------------------------------
                | KETUA
                |--------------------------------------------------------------------------
                */

                'detailTim.tim.ketua',

                /*
                |--------------------------------------------------------------------------
                | ANGGOTA
                |--------------------------------------------------------------------------
                */

                'detailTim.tim.detailTims.user',

                /*
                |--------------------------------------------------------------------------
                | SEMUA FILE REVISI
                |--------------------------------------------------------------------------
                */

                'fileLaporan',

                /*
                |--------------------------------------------------------------------------
                | FILE REVISI TERBARU
                |--------------------------------------------------------------------------
                */

                'fileTerbaru',

            ])


            /*
            |--------------------------------------------------------------------------
            | SEARCH
            |--------------------------------------------------------------------------
            |
            | Search:
            |
            | - Judul
            | - Ketua
            | - Anggota
            | - Industri
            |
            */

            ->when(
                $search !== '',
                function ($query) use (
                    $search,
                    $userIds
                ) {

                    $query->where(
                        function ($query) use (
                            $search,
                            $userIds
                        ) {

                            /*
                            |--------------------------------------------------------------------------
                            | JUDUL
                            |--------------------------------------------------------------------------
                            */

                            $query->where(
                                'judul',
                                'like',
                                "%{$search}%"
                            );


                            /*
                            |--------------------------------------------------------------------------
                            | KETUA & ANGGOTA
                            |--------------------------------------------------------------------------
                            */

                            if ($userIds->isNotEmpty()) {

                                /*
                                |--------------------------------------------------------------------------
                                | KETUA
                                |--------------------------------------------------------------------------
                                */

                                $query->orWhereHas(
                                    'detailTim.tim',
                                    function ($timQuery) use (
                                        $userIds
                                    ) {

                                        $timQuery->whereIn(
                                            'ketua_user_id',
                                            $userIds
                                        );

                                    }
                                );


                                /*
                                |--------------------------------------------------------------------------
                                | ANGGOTA
                                |--------------------------------------------------------------------------
                                */

                                $query->orWhereHas(
                                    'detailTim.tim.detailTims',
                                    function ($detailTimQuery) use (
                                        $userIds
                                    ) {

                                        $detailTimQuery->whereIn(
                                            'user_id',
                                            $userIds
                                        );

                                    }
                                );

                            }


                            /*
                            |--------------------------------------------------------------------------
                            | INDUSTRI
                            |--------------------------------------------------------------------------
                            */

                            $query->orWhereHas(
                                'detailTim.tim.industri',
                                function ($industriQuery) use (
                                    $search
                                ) {

                                    $industriQuery->where(
                                        'nama',
                                        'like',
                                        "%{$search}%"
                                    );

                                }
                            );

                        }
                    );

                }
            )


            /*
            |--------------------------------------------------------------------------
            | URUTKAN DATA
            |--------------------------------------------------------------------------
            |
            | Data terbaru diletakkan terlebih dahulu.
            |
            */

            ->orderByDesc('created_at')
            ->orderByDesc('id')


            /*
            |--------------------------------------------------------------------------
            | EKSEKUSI
            |--------------------------------------------------------------------------
            */

            ->get();


        /*
        |--------------------------------------------------------------------------
        | KELOMPOKKAN BERDASARKAN TIM
        |--------------------------------------------------------------------------
        |
        | PENTING:
        |
        | Identitas kelompok adalah:
        |
        |     tim.id
        |
        | BUKAN:
        |
        |     detail_tim_id
        |
        |
        | Contoh:
        |
        | tim.id = 472
        |
        | detail_tim:
        |     394
        |     395
        |     396
        |
        | Semua tetap dianggap:
        |
        |     KELOMPOK 472
        |
        */

        $kelompok = $laporan
            ->filter(
                function ($item) {

                    return
                        $item->detailTim?->tim?->id !== null;

                }
            )
            ->groupBy(
                function ($item) {

                    return
                        $item->detailTim
                            ->tim
                            ->id;

                }
            );


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN DATA UTAMA & RIWAYAT
        |--------------------------------------------------------------------------
        */

        $hasil = $kelompok
            ->map(
                function ($items) {

                    /*
                    |--------------------------------------------------------------------------
                    | URUTKAN DATA DALAM KELOMPOK
                    |--------------------------------------------------------------------------
                    |
                    | Prioritas:
                    |
                    | 1. created_at terbaru
                    | 2. id terbesar jika tanggal sama
                    |
                    */

                    $items = $items
                        ->sort(
                            function (
                                $a,
                                $b
                            ) {

                                $tanggalA =
                                    $a->created_at?->timestamp
                                    ?? 0;

                                $tanggalB =
                                    $b->created_at?->timestamp
                                    ?? 0;


                                if (
                                    $tanggalA !==
                                    $tanggalB
                                ) {

                                    return
                                        $tanggalB
                                        <=>
                                        $tanggalA;

                                }


                                return
                                    $b->id
                                    <=>
                                    $a->id;

                            }
                        )
                        ->values();


                    /*
                    |--------------------------------------------------------------------------
                    | DATA UTAMA
                    |--------------------------------------------------------------------------
                    */

                    $utama =
                        $items->first();


                    /*
                    |--------------------------------------------------------------------------
                    | DATA RIWAYAT
                    |--------------------------------------------------------------------------
                    */

                    $riwayat =
                        $items
                            ->skip(1)
                            ->values();


                    /*
                    |--------------------------------------------------------------------------
                    | NOMOR KELOMPOK
                    |--------------------------------------------------------------------------
                    */

                    $kelompokId =
                        $utama
                            ->detailTim
                            ?->tim
                            ?->id;


                    /*
                    |--------------------------------------------------------------------------
                    | RETURN
                    |--------------------------------------------------------------------------
                    */

                    return [

                        /*
                        |--------------------------------------------------------------------------
                        | DATA TERBARU
                        |--------------------------------------------------------------------------
                        */

                        'utama' =>
                            $utama,


                        /*
                        |--------------------------------------------------------------------------
                        | DATA LAMA
                        |--------------------------------------------------------------------------
                        */

                        'riwayat' =>
                            $riwayat,


                        /*
                        |--------------------------------------------------------------------------
                        | JUMLAH RIWAYAT
                        |--------------------------------------------------------------------------
                        */

                        'jumlah_riwayat' =>
                            $riwayat->count(),


                        /*
                        |--------------------------------------------------------------------------
                        | JUMLAH SEMUA DATA
                        |--------------------------------------------------------------------------
                        */

                        'jumlah_data' =>
                            $items->count(),


                        /*
                        |--------------------------------------------------------------------------
                        | NOMOR KELOMPOK
                        |--------------------------------------------------------------------------
                        */

                        'kelompok_id' =>
                            $kelompokId,

                    ];

                }
            )


            /*
            |--------------------------------------------------------------------------
            | URUTKAN KELOMPOK
            |--------------------------------------------------------------------------
            |
            | Kelompok dengan laporan terbaru
            | muncul paling atas.
            |
            */

            ->sort(
                function (
                    $a,
                    $b
                ) {

                    $tanggalA =
                        $a['utama']
                            ->created_at
                            ?->timestamp
                        ?? 0;


                    $tanggalB =
                        $b['utama']
                            ->created_at
                            ?->timestamp
                        ?? 0;


                    if (
                        $tanggalA !==
                        $tanggalB
                    ) {

                        return
                            $tanggalB
                            <=>
                            $tanggalA;

                    }


                    return
                        $b['utama']->id
                        <=>
                        $a['utama']->id;

                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | Pagination dilakukan setelah grouping.
        |
        | Jadi:
        |
        | 12 = 12 KELOMPOK
        |
        | bukan:
        |
        | 12 = 12 laporan.
        |
        */

        $perPage = 12;


        $currentPage = max(
            1,
            (int) $request->input(
                'page',
                1
            )
        );


        $total =
            $hasil->count();


        $items =
            $hasil
                ->slice(
                    ($currentPage - 1)
                    * $perPage,
                    $perPage
                )
                ->values();


        /*
        |--------------------------------------------------------------------------
        | PAGINATOR
        |--------------------------------------------------------------------------
        */

        $paginator =
            new LengthAwarePaginator(
                $items,
                $total,
                $perPage,
                $currentPage,
                [
                    'path' =>
                        $request->url(),

                    'query' =>
                        $request->query(),
                ]
            );


        /*
|--------------------------------------------------------------------------
| VIEW
|--------------------------------------------------------------------------
*/

// Request dari JS (fetch/AJAX) -> balas JSON berisi partial HTML.
if ($request->ajax() || $request->wantsJson()) {

    return response()->json([

        'result' => view(
            'library.praktik-industri._result',
            [
                'laporan' => $paginator,
            ]
        )->render(),

        'pagination' => view(
            'library.praktik-industri._pagination',
            [
                'laporan' => $paginator,
            ]
        )->render(),

    ]);

}

// Load halaman biasa -> tetap render full page seperti sekarang.
return view(
    'library.praktik-industri.index',
    [
        'laporan' => $paginator,
        'search'  => $search,
    ]
);
    }
    /**
     * Menampilkan seluruh riwayat laporan berdasarkan nomor kelompok.
     *
     * Parameter $tim adalah:
     *
     *     tim.id
     *
     * BUKAN:
     *
     *     detail_tim_id
     *
     * Semua laporan yang berada di dalam tim yang sama
     * akan dikembalikan.
     */
    public function history(Request $request, $tim)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA LAPORAN DALAM KELOMPOK
        |--------------------------------------------------------------------------
        */

        $laporan = PraktikIndustri::query()
            ->with([
                'detailTim.tim',
                'detailTim.tim.industri',
                'detailTim.tim.ketua',
                'detailTim.tim.detailTims.user',
                'fileLaporan',
                'fileTerbaru',
            ])
            ->whereHas(
                'detailTim.tim',
                function ($query) use ($tim) {
                    $query->where('id', $tim);
                }
            )
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if ($laporan->isEmpty()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Data laporan kelompok tidak ditemukan.',
                ],
                404
            );
        }

        /*
        |--------------------------------------------------------------------------
        | BENTUK DATA UNTUK JAVASCRIPT
        |--------------------------------------------------------------------------
        |
        | Setiap record laporan membawa file miliknya sendiri.
        | Jadi riwayat tidak mengambil file milik versi lain.
        |
        */

        $data = $laporan
            ->map(function ($item, $index) use ($laporan, $tim) {
                $timData = $item->detailTim?->tim;
                $ketua = $timData?->ketua;
                $industri = $timData?->industri;

                /*
                |------------------------------------------------------------------
                | FILE VERSI INI
                |------------------------------------------------------------------
                |
                | Prioritas utama adalah ujians.file_laporan karena setiap
                | laporan/versi memiliki file utamanya sendiri.
                |
                | Jika kosong, baru cari file revisi yang terkait dengan
                | ujians tersebut.
                |
                */

                $fileAktif = $item->file_laporan;

                if (!$fileAktif) {
                    $fileAktif = $item->fileLaporan
                        ->filter(function ($file) {
                            return !empty($file->file);
                        })
                        ->sortByDesc(function ($file) {
                            return $file->updated_at?->timestamp ?? 0;
                        })
                        ->first()?->file;
                }

                /*
                |------------------------------------------------------------------
                | URL FILE
                |------------------------------------------------------------------
                */

                $fileUrl = null;

                if ($fileAktif) {
                    if (filter_var($fileAktif, FILTER_VALIDATE_URL)) {
                        $fileUrl = $fileAktif;
                    } else {
                        $fileUrl = asset(
                            'storage/' . ltrim($fileAktif, '/')
                        );
                    }
                }

                /*
                |------------------------------------------------------------------
                | TANGGAL
                |------------------------------------------------------------------
                |
                | Untuk versi laporan, created_at adalah waktu versi tersebut
                | dibuat. updated_at digunakan sebagai fallback.
                |
                */

                $createdAt = $item->created_at;
                $updatedAt = $item->updated_at ?? $createdAt;

                /*
                | Jika file revisi memiliki waktu update yang lebih relevan,
                | gunakan waktu file tersebut.
                */

                $fileTerakhir = $item->fileLaporan
                    ->filter(function ($file) {
                        return !empty($file->file);
                    })
                    ->sortByDesc(function ($file) {
                        return $file->updated_at?->timestamp ?? 0;
                    })
                    ->first();

                if ($fileTerakhir?->updated_at) {
                    $updatedAt = $fileTerakhir->updated_at;
                }

                /*
                |------------------------------------------------------------------
                | STATUS DAN NOMOR REVISI
                |------------------------------------------------------------------
                */

                $status = $index === 0
                    ? 'utama'
                    : 'riwayat';

                $nomorRevisi = $index === 0
                    ? null
                    : $laporan->count() - $index;

                /*
                |------------------------------------------------------------------
                | RETURN
                |------------------------------------------------------------------
                */

                return [
                    'id' => $item->id,

                    'detail_tim_id' => $item->detail_tim_id,

                    'kelompok' => $timData?->id ?? $tim,

                    'judul' => $item->judul
                        ?: 'Judul tidak tersedia',

                    'ketua' => $ketua?->nama_lengkap ?? '-',

                    'industri' => $industri?->nama ?? '-',

                    /* File */
                    'file' => $fileUrl,
                    'pdf' => $fileUrl,
                    'file_url' => $fileUrl,
                    'pdf_url' => $fileUrl,

                    /* Raw timestamp untuk JS */
                    'created_at' => $createdAt?->toISOString(),
                    'updated_at' => $updatedAt?->toISOString(),
                    'date' => $updatedAt?->toISOString(),

                    /* Tanggal upload */
                    'tanggal_upload' => $createdAt
                        ? $createdAt->translatedFormat('d F Y')
                        : null,

                    'jam_upload' => $createdAt
                        ? $createdAt->format('H:i')
                        : null,

                    /* Tanggal update */
                    'tanggal_update' => $updatedAt
                        ? $updatedAt->translatedFormat('d F Y')
                        : null,

                    'jam_update' => $updatedAt
                        ? $updatedAt->format('H:i')
                        : null,

                    /* Revisi */
                    'status' => $status,
                    'revision' => $nomorRevisi,
                    'revisi' => $nomorRevisi,
                    'nomor_revisi' => $nomorRevisi,

                    /* Jumlah file revisi */
                    'jumlah_revisi' => $item->fileLaporan->count(),
                ];
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | RESPONSE JSON
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,
            'kelompok' => $tim,
            'total' => $data->count(),
            'data' => $data,
        ]);
    }
}