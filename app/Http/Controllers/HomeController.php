<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use App\Models\User;
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

        $literatureCount = Literature::count();
        $categoryCount   = Category::count();
        $typeCount       = Type::count();
        $userCount       = User::count();


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
        | Distribution by Type
        |--------------------------------------------------------------------------
        |
        | Relasi:
        |
        | Type
        |   ↓
        | Category
        |   ↓
        | Literature
        |
        | Semua tipe tetap ditampilkan meskipun jumlah literaturnya 0.
        |
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
            ->orderByDesc('literatures_count')
            ->orderBy('name')
            ->get()
            ->map(function ($type) {
                return [
                    'label' => $type->name,
                    'value' => (int) $type->literatures_count,
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Distribution by Category
        |--------------------------------------------------------------------------
        |
        | Semua kategori tetap ditampilkan.
        | Kategori tanpa literatur akan memiliki value = 0.
        |
        */

        $categoryChartData = Category::query()
            ->withCount('literatures')
            ->orderByDesc('literatures_count')
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                return [
                    'label' => $category->name,
                    'value' => (int) $category->literatures_count,
                ];
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Skripsi Distribution by KBK
        |--------------------------------------------------------------------------
        |
        | data_judul   : database sisinta
        | berkas_akhir : database sisinta
        | data_kbk     : database master
        |
        | Skripsi dihitung jika:
        |
        | status_judul = SELESAI
        | status berkas akhir = DITERIMA
        |
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
        |
        | KBK yang belum mempunyai skripsi tetap dikirim dengan value = 0.
        |
        */

        $kbkChartData = DB::connection('master')
            ->table('data_kbk')
            ->orderBy('nama_kbk')
            ->get()
            ->map(function ($kbk) use ($kbkTotals) {
                return [
                    'label' => $kbk->nama_kbk,

                    'value' => (int) (
                        $kbkTotals[$kbk->id] ?? 0
                    ),
                ];
            })
            ->sortByDesc('value')
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
        |
        | status:
        |
        | 0 = Login
        | 1 = Logout
        |
        | Card dashboard hanya menampilkan 5 LOGIN terbaru.
        |
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
        |
        | Digunakan pada popup "Lihat Semua Aktivitas".
        |
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

        return view('home', [
            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            'literatureCount' => $literatureCount,
            'categoryCount'   => $categoryCount,
            'typeCount'       => $typeCount,
            'userCount'       => $userCount,
            'kbkCount'        => $kbkCount,


            /*
            |--------------------------------------------------------------------------
            | Charts
            |--------------------------------------------------------------------------
            */

            'kbkChartData'      => $kbkChartData,
            'typeChartData'     => $typeChartData,
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

            'latestLoginActivities' => $latestLoginActivities,
            'loginActivities'       => $loginActivities,
        ]);
    }
}