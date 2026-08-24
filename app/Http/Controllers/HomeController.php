<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use App\Models\User;
use App\Models\PenjejakanPasca;
use App\Models\Repository;
use App\Models\Skripsi;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Homepage / Dashboard
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        /*
        |----------------------------------------------------------------------
        | Literatur
        |----------------------------------------------------------------------
        */

        $literatureCount = Literature::count();


        /*
        |----------------------------------------------------------------------
        | Kategori
        |----------------------------------------------------------------------
        */

        $categoryCount = Category::count();


        /*
        |----------------------------------------------------------------------
        | Type
        |----------------------------------------------------------------------
        */

        $typeCount = Type::count();


        /*
        |----------------------------------------------------------------------
        | User
        |----------------------------------------------------------------------
        */

        $userCount = User::count();


        /*
        |--------------------------------------------------------------------------
        | KBK Count
        |--------------------------------------------------------------------------
        */

        $kbkCount = DB::connection('master')
            ->table('data_kbk')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Total Skripsi
        |--------------------------------------------------------------------------
        |
        | Mengikuti logic SkripsiController:
        |
        | status_judul = SELESAI
        | isi.status   = DITERIMA
        |
        */

        $skripsiCount = Skripsi::query()
            ->where(
                'status_judul',
                'SELESAI'
            )
            ->whereHas(
                'isi',
                function ($query) {
                    $query->where(
                        'status',
                        'DITERIMA'
                    );
                }
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Base Query Tesis + Disertasi
        |--------------------------------------------------------------------------
        |
        | Mengikuti ThesisController dan DisertasiController:
        |
        | status = 4
        | lampiran_produk tersedia
        |
        */

        $penjejakanPasca = PenjejakanPasca::query()
            ->where(
                'status',
                '4'
            )
            ->whereNotNull(
                'lampiran_produk'
            )
            ->where(
                'lampiran_produk',
                '!=',
                ''
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Repository Tesis / Disertasi
        |--------------------------------------------------------------------------
        |
        | Ambil repository berdasarkan id_pengajuan.
        |
        */

        $idPengajuan = $penjejakanPasca
            ->pluck('id_pengajuan')
            ->filter()
            ->unique()
            ->values();


        $repositories = collect();

        if ($idPengajuan->isNotEmpty()) {

            $repositories = Repository::query()
                ->whereIn(
                    'id_pengajuan',
                    $idPengajuan
                )
                ->get()
                ->keyBy(
                    'id_pengajuan'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Total Tesis
        |--------------------------------------------------------------------------
        |
        | Hanya:
        |
        | jenis_karya = thesis
        | status      = active
        |
        */

        $tesisCount = $penjejakanPasca
            ->filter(
                function ($item) use ($repositories) {

                    $repository = $repositories->get(
                        $item->id_pengajuan
                    );

                    if (!$repository) {
                        return false;
                    }

                    return
                        $repository->jenis_karya === 'thesis'
                        &&
                        $repository->status === 'active';
                }
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Total Disertasi
        |--------------------------------------------------------------------------
        |
        | Hanya:
        |
        | jenis_karya = dissertation
        | status      = active
        |
        */

        $disertasiCount = $penjejakanPasca
            ->filter(
                function ($item) use ($repositories) {

                    $repository = $repositories->get(
                        $item->id_pengajuan
                    );

                    if (!$repository) {
                        return false;
                    }

                    return
                        $repository->jenis_karya === 'dissertation'
                        &&
                        $repository->status === 'active';
                }
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Total Seluruh Koleksi
        |--------------------------------------------------------------------------
        |
        | Literatur
        | + Skripsi
        | + Tesis
        | + Disertasi
        |
        */

        $totalCollection =
            $literatureCount
            + $skripsiCount
            + $tesisCount
            + $disertasiCount;


        /*
        |--------------------------------------------------------------------------
        | Distribution by Type
        |--------------------------------------------------------------------------
        */

        $typeChartData = Type::query()
            ->withCount([
                'categories as literatures_count' => function ($query) {

                    $query->join(
                        'literatures',
                        'literatures.category_id',
                        '=',
                        'categories.id'
                    );
                }
            ])
            ->orderByDesc(
                'literatures_count'
            )
            ->orderBy(
                'name'
            )
            ->get()
            ->map(
                function ($type) {

                    return [
                        'label' => $type->name,
                        'value' => (int) $type->literatures_count,
                    ];
                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Distribution by Category
        |--------------------------------------------------------------------------
        */

        $categoryChartData = Category::query()
            ->withCount(
                'literatures'
            )
            ->orderByDesc(
                'literatures_count'
            )
            ->orderBy(
                'name'
            )
            ->get()
            ->map(
                function ($category) {

                    return [
                        'label' => $category->name,
                        'value' => (int) $category->literatures_count,
                    ];
                }
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Skripsi Distribution by KBK
        |--------------------------------------------------------------------------
        */

        $kbkTotals = DB::connection('sisinta')
            ->table('data_judul')
            ->join(
                'berkas_akhir',
                'berkas_akhir.user_mahasiswa_id',
                '=',
                'data_judul.user_mahasiswa_id'
            )
            ->select(
                'data_judul.id_kbk',
                DB::raw(
                    'COUNT(DISTINCT data_judul.id_judul) as total'
                )
            )
            ->where(
                'data_judul.status_judul',
                'SELESAI'
            )
            ->where(
                'berkas_akhir.status',
                'DITERIMA'
            )
            ->whereNotNull(
                'data_judul.id_kbk'
            )
            ->groupBy(
                'data_judul.id_kbk'
            )
            ->pluck(
                'total',
                'id_kbk'
            );


        /*
        |--------------------------------------------------------------------------
        | Semua KBK
        |--------------------------------------------------------------------------
        */

        $kbkChartData = DB::connection('master')
            ->table('data_kbk')
            ->orderBy(
                'nama_kbk'
            )
            ->get()
            ->map(
                function ($kbk) use ($kbkTotals) {

                    return [
                        'label' => $kbk->nama_kbk,

                        'value' => (int) (
                            $kbkTotals[$kbk->id] ?? 0
                        ),
                    ];
                }
            )
            ->sortByDesc(
                'value'
            )
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Latest Literatures
        |--------------------------------------------------------------------------
        */

        $latestLiteratures = Literature::with([
            'category',
            'type',
        ])
            ->latest()
            ->take(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Latest Login Activity
        |--------------------------------------------------------------------------
        */

        $latestLoginActivities = DB::connection('master')
            ->table('log_login')
            ->leftJoin(
                'user',
                'user.user_id',
                '=',
                'log_login.user_user_id'
            )
            ->select([
                'log_login.id',
                'log_login.user_user_id',
                'log_login.ip_pengakses',
                'log_login.status',
                'log_login.created_at',

                'user.nama_lengkap',
                'user.nomor_induk',
            ])
            ->where(
                'log_login.status',
                0
            )
            ->orderByDesc(
                'log_login.created_at'
            )
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Login / Logout Activity - 14 Days
        |--------------------------------------------------------------------------
        */

        $loginActivities = DB::connection('master')
            ->table('log_login')
            ->leftJoin(
                'user',
                'user.user_id',
                '=',
                'log_login.user_user_id'
            )
            ->select([
                'log_login.id',
                'log_login.user_user_id',
                'log_login.ip_pengakses',
                'log_login.status',
                'log_login.created_at',

                'user.nama_lengkap',
                'user.nomor_induk',
            ])
            ->where(
                'log_login.created_at',
                '>=',
                now()->subDays(13)->startOfDay()
            )
            ->orderByDesc(
                'log_login.created_at'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'home',
            [

                /*
                |--------------------------------------------------------------------------
                | Statistics
                |--------------------------------------------------------------------------
                */

                'literatureCount' => $literatureCount,

                'skripsiCount' => $skripsiCount,

                'tesisCount' => $tesisCount,

                'disertasiCount' => $disertasiCount,

                'totalCollection' => $totalCollection,

                'categoryCount' => $categoryCount,

                'typeCount' => $typeCount,

                'userCount' => $userCount,

                'kbkCount' => $kbkCount,


                /*
                |--------------------------------------------------------------------------
                | Charts
                |--------------------------------------------------------------------------
                */

                'kbkChartData' => $kbkChartData,

                'typeChartData' => $typeChartData,

                'categoryChartData' => $categoryChartData,


                /*
                |--------------------------------------------------------------------------
                | Literature
                |--------------------------------------------------------------------------
                */

                'latestLiteratures' => $latestLiteratures,


                /*
                |--------------------------------------------------------------------------
                | Login Activity
                |--------------------------------------------------------------------------
                */

                'latestLoginActivities' =>
                $latestLoginActivities,

                'loginActivities' =>
                $loginActivities,
            ]
        );
    }
}
