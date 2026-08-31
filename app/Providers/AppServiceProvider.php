<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\PenjejakanPasca;
use App\Models\Repository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | FORCE HTTPS DI PRODUCTION
        |--------------------------------------------------------------------------
        */

        if (!app()->runningInConsole() && app()->environment('production')) {
            URL::forceScheme('https');
        }


        /*
        |--------------------------------------------------------------------------
        | BADGE KELOLA PASCASARJANA
        |--------------------------------------------------------------------------
        |
        | Angka = Perlu Penanganan + Belum Ada Repository
        | (tidak termasuk yang sudah Aktif).
        |
        | Sengaja DILUAR blok production di atas, supaya badge tetap
        | jalan di local/development juga, bukan cuma di production.
        |
        | Hanya dihitung untuk admin (level 6), supaya user biasa
        | tidak ikut menjalankan query tambahan tiap buka halaman.
        |
        */

        View::composer(
            'layouts.partials.navbar',
            function ($view) {

                $badgeCount = 0;


                if (
                    auth()->check() &&
                    auth()->user()->level == 6
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Data karya yang memenuhi syarat (sama seperti di manage())
                    |--------------------------------------------------------------------------
                    */

                    $idPengajuanList = PenjejakanPasca::query()
                        ->where('status', '4')
                        ->whereNotNull('lampiran_produk')
                        ->where('lampiran_produk', '!=', '')
                        ->pluck('id_pengajuan')
                        ->filter()
                        ->unique()
                        ->values();


                    /*
                    |--------------------------------------------------------------------------
                    | Status repository untuk karya-karya tersebut
                    |--------------------------------------------------------------------------
                    */

                    $repositoryStatuses = Repository::query()
                        ->whereIn('id_pengajuan', $idPengajuanList)
                        ->pluck('status', 'id_pengajuan');


                    /*
                    |--------------------------------------------------------------------------
                    | Perlu Penanganan
                    |--------------------------------------------------------------------------
                    */

                    $totalNeedsAction = $repositoryStatuses
                        ->filter(
                            fn ($status) => $status === 'needs_action'
                        )
                        ->count();


                    /*
                    |--------------------------------------------------------------------------
                    | Belum Ada Repository
                    |--------------------------------------------------------------------------
                    |
                    | Karya yang tidak punya baris repository sama sekali.
                    |
                    */

                    $totalWithoutRepository =
                        $idPengajuanList->count() -
                        $repositoryStatuses->count();


                    $badgeCount =
                        $totalNeedsAction +
                        $totalWithoutRepository;

                }


                $view->with(
                    'pascasarjanaBadgeCount',
                    $badgeCount
                );

            }
        );
    }
}