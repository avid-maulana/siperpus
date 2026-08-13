<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LiteratureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkripsiController;
use App\Http\Controllers\DisertasiController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\RepositoryManagementController;
use App\Http\Controllers\RepositoryController;


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get(
        '/login',
        [LoginController::class, 'showLoginForm']
    )->name('login');


    Route::post(
        '/login',
        [LoginController::class, 'login']
    );
});


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post(
    '/logout',
    [LoginController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Authenticated User
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Homepage
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/',
        [HomeController::class, 'index']
    )->name('home');


    /*
    |--------------------------------------------------------------------------
    | Literatur
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/literatures',
        [LiteratureController::class, 'index']
    )->name('literatures.index');


    /*
    |--------------------------------------------------------------------------
    | Skripsi
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/skripsi',
        [SkripsiController::class, 'index']
    )->name('skripsi.index');


    /*
    |--------------------------------------------------------------------------
    | Pascasarjana - Tesis
    |--------------------------------------------------------------------------
    |
    | Halaman publik untuk melihat repository tesis
    | yang sudah diaktifkan oleh admin.
    |
    */

    Route::get(
        '/tesis',
        [ThesisController::class, 'index']
    )->name('tesis.index');


    /*
    |--------------------------------------------------------------------------
    | Pascasarjana - Disertasi
    |--------------------------------------------------------------------------
    |
    | Halaman publik untuk melihat repository disertasi
    | yang sudah diaktifkan oleh admin.
    |
    */

    Route::get(
        '/disertasi',
        [DisertasiController::class, 'index']
    )->name('disertasi.index');


    /*
    |--------------------------------------------------------------------------
    | PDF Viewer
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pdf-viewer',
        function () {

            return view('pdf_viewer', [
                'pdfPath' => request('path'),
            ]);
        }
    )->name('pdf.viewer');


    /*
    |--------------------------------------------------------------------------
    | PDF Proxy
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pdf-proxy',
        function () {

            $url = request('url');


            /*
            |--------------------------------------------------------------------------
            | Validasi URL
            |--------------------------------------------------------------------------
            */

            if (
                !$url ||
                !filter_var(
                    $url,
                    FILTER_VALIDATE_URL
                )
            ) {

                abort(
                    400,
                    'URL PDF tidak valid.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Batasi Domain
            |--------------------------------------------------------------------------
            */

            $host = parse_url(
                $url,
                PHP_URL_HOST
            );


            $allowedHosts = [
                'tei.um.ac.id',
                'elektro.um.ac.id',
            ];


            if (
                !in_array(
                    $host,
                    $allowedHosts,
                    true
                )
            ) {

                abort(
                    403,
                    'Domain PDF tidak diizinkan.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Ambil PDF
            |--------------------------------------------------------------------------
            */

            try {

                $response = Http::timeout(120)
                    ->connectTimeout(30)
                    ->withHeaders([
                        'User-Agent' =>
                        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/151.0 Safari/537.36',

                        'Accept' =>
                        'application/pdf,application/octet-stream,*/*',
                    ])
                    ->withOptions([
                        'allow_redirects' => [
                            'max' => 5,
                            'strict' => true,
                        ],
                    ])
                    ->get($url);
            } catch (\Throwable $e) {

                logger()->error(
                    'PDF Proxy Exception',
                    [
                        'url' => $url,
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                    ]
                );


                abort(
                    502,
                    'PDF tidak dapat diambil dari server.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Cek HTTP Status
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                logger()->error(
                    'PDF Proxy HTTP Error',
                    [
                        'url' => $url,
                        'status' => $response->status(),
                        'content_type' =>
                        $response->header('Content-Type'),
                    ]
                );


                abort(
                    502,
                    'Server PDF mengembalikan status ' .
                        $response->status()
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Cek Content-Type
            |--------------------------------------------------------------------------
            */

            $contentType = strtolower(
                $response->header(
                    'Content-Type',
                    ''
                )
            );


            if (
                $contentType &&
                !str_contains(
                    $contentType,
                    'application/pdf'
                ) &&
                !str_contains(
                    $contentType,
                    'application/octet-stream'
                )
            ) {

                logger()->error(
                    'PDF Proxy Invalid Content Type',
                    [
                        'url' => $url,
                        'content_type' => $contentType,
                    ]
                );


                abort(
                    502,
                    'Server tidak mengembalikan file PDF.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Ambil Isi PDF
            |--------------------------------------------------------------------------
            */

            $body = $response->body();


            if (empty($body)) {

                logger()->error(
                    'PDF Proxy Empty Response',
                    [
                        'url' => $url,
                        'status' => $response->status(),
                    ]
                );


                abort(
                    502,
                    'File PDF kosong.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Return PDF
            |--------------------------------------------------------------------------
            */

            return response(
                $body,
                200,
                [
                    'Content-Type' =>
                    'application/pdf',

                    'Content-Disposition' =>
                    'inline; filename="document.pdf"',

                    'Content-Length' =>
                    strlen($body),

                    'Cache-Control' =>
                    'private, max-age=3600',

                    'Accept-Ranges' =>
                    'bytes',
                ]
            );
        }
    )->name('pdf.proxy');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile/edit',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::put(
        '/profile/update',
        [ProfileController::class, 'update']
    )->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| Admin / Library Management
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role'])
    ->prefix('library')
    ->name('library.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/',
            [LibraryController::class, 'index']
        )->name('index');


        /*
        |--------------------------------------------------------------------------
        | Kelola Literatur
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/literatures',
            [LibraryController::class, 'indexLiterature']
        )->name('indexLiterature');


        /*
        |--------------------------------------------------------------------------
        | Literatur - Tambah
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/literatures',
            [LiteratureController::class, 'store']
        )->name('storeLiterature');


        /*
        |--------------------------------------------------------------------------
        | Literatur - Update
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/literatures/{literature}',
            [LiteratureController::class, 'update']
        )->name('updateLiterature');


        /*
        |--------------------------------------------------------------------------
        | Literatur - Hapus
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/literatures/{literature}',
            [LiteratureController::class, 'destroy']
        )->name('destroyLiterature');
        /*
        |--------------------------------------------------------------------------
        | Kelola Repository Tesis & Disertasi
        |--------------------------------------------------------------------------
        |
        | Semua data pascasarjana dikelola dari satu halaman.
        |
        | Admin dapat:
        |
        | - menentukan jenis karya
        | - Tesis
        | - Disertasi
        | - menentukan status
        | - Perlu Penanganan
        | - Belum Ada Repository
        | - Aktif
        |
        */

        Route::get(
            '/repositories',
            [RepositoryManagementController::class, 'manage']
        )->name('repositories');


        /*
        |--------------------------------------------------------------------------
        | Repository - Tambah
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/repository',
            [RepositoryController::class, 'store']
        )->name('repository.store');


        /*
        |--------------------------------------------------------------------------
        | Repository - Edit
        |--------------------------------------------------------------------------
        */

        Route::put(
            '/repository/{repository}',
            [RepositoryController::class, 'update']
        )->name('repository.update');


        /*
        |--------------------------------------------------------------------------
        | Repository - Hapus
        |--------------------------------------------------------------------------
        */

        Route::delete(
            '/repository/{repository}',
            [RepositoryController::class, 'destroy']
        )->name('repository.destroy');


        /*
        |--------------------------------------------------------------------------
        | Repository - Aktifkan
        |--------------------------------------------------------------------------
        */

        Route::patch(
            '/repository/{repository}/activate',
            [RepositoryController::class, 'activate']
        )->name('repository.activate');


        /*
        |--------------------------------------------------------------------------
        | Type
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/store-type',
            [LibraryController::class, 'storeType']
        )->name('storeType');


        Route::put(
            '/update-type/{id}',
            [LibraryController::class, 'updateType']
        )->name('updateType');


        Route::delete(
            '/destroy-type/{id}',
            [LibraryController::class, 'destroyType']
        )->name('destroyType');


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        Route::post(
            '/store-category',
            [LibraryController::class, 'storeCategory']
        )->name('storeCategory');


        Route::put(
            '/update-category/{id}',
            [LibraryController::class, 'updateCategory']
        )->name('updateCategory');


        Route::delete(
            '/destroy-category/{id}',
            [LibraryController::class, 'destroyCategory']
        )->name('destroyCategory');
    });
