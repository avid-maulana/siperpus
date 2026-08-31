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
use App\Http\Controllers\PraktikIndustriController;
use App\Http\Controllers\PraktikIndustriAdminController;


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
    */

    Route::get(
        '/tesis',
        [ThesisController::class, 'index']
    )->name('tesis.index');


    /*
    |--------------------------------------------------------------------------
    | Pascasarjana - Disertasi
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/disertasi',
        [DisertasiController::class, 'index']
    )->name('disertasi.index');


    /*
    |--------------------------------------------------------------------------
    | Laporan Praktik Industri
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/praktik-industri',
        [PraktikIndustriController::class, 'index']
    )->name('praktik-industri.index');


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
    |
    | Sumber:
    |
    | - PDF langsung
    | - Google Drive
    | - Google Docs
    |
    */

    Route::get(
        '/pdf-proxy',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Ambil URL
            |--------------------------------------------------------------------------
            */

            $url = trim(
                request('url', '')
            );


            /*
            |--------------------------------------------------------------------------
            | Validasi URL
            |--------------------------------------------------------------------------
            */

            if (
                $url === '' ||
                !filter_var(
                    $url,
                    FILTER_VALIDATE_URL
                )
            ) {

                abort(
                    400,
                    'URL dokumen tidak valid.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Parse URL
            |--------------------------------------------------------------------------
            */

            $host = strtolower(
                parse_url(
                    $url,
                    PHP_URL_HOST
                ) ?? ''
            );

            $path = parse_url(
                $url,
                PHP_URL_PATH
            ) ?? '';


            /*
            |--------------------------------------------------------------------------
            | Deteksi Sumber
            |--------------------------------------------------------------------------
            */

            $isGoogleDrive =
                in_array(
                    $host,
                    [
                        'drive.google.com',
                        'www.drive.google.com',
                    ],
                    true
                );

            $isGoogleDocs =
                in_array(
                    $host,
                    [
                        'docs.google.com',
                        'www.docs.google.com',
                    ],
                    true
                );


            $requestUrl = $url;


            /*
            |--------------------------------------------------------------------------
            | Google Drive
            |--------------------------------------------------------------------------
            */

            if ($isGoogleDrive) {

                $fileId = null;


                if (
                    preg_match(
                        '#/file/d/([^/]+)#',
                        $path,
                        $matches
                    )
                ) {

                    $fileId = $matches[1];
                }


                if (!$fileId) {

                    parse_str(
                        parse_url(
                            $url,
                            PHP_URL_QUERY
                        ) ?? '',
                        $query
                    );


                    if (
                        isset($query['id']) &&
                        $query['id'] !== ''
                    ) {

                        $fileId =
                            $query['id'];
                    }
                }


                if (!$fileId) {

                    abort(
                        400,
                        'ID file Google Drive tidak ditemukan.'
                    );
                }


                $requestUrl =
                    'https://drive.usercontent.google.com/download'
                    . '?id='
                    . urlencode($fileId)
                    . '&export=download';
            }


            /*
            |--------------------------------------------------------------------------
            | Google Docs
            |--------------------------------------------------------------------------
            */

            if ($isGoogleDocs) {

                $documentId = null;


                if (
                    preg_match(
                        '#/document/d/([^/]+)#',
                        $path,
                        $matches
                    )
                ) {

                    $documentId = $matches[1];
                }


                if (!$documentId) {

                    abort(
                        400,
                        'ID Google Docs tidak ditemukan.'
                    );
                }


                $requestUrl =
                    'https://docs.google.com/document/d/'
                    . urlencode($documentId)
                    . '/export?format=pdf';
            }


            /*
            |--------------------------------------------------------------------------
            | Domain Allowlist
            |--------------------------------------------------------------------------
            */

            $allowedHosts = [

                'tei.um.ac.id',
                'elektro.um.ac.id',

                'drive.google.com',
                'www.drive.google.com',
                'drive.usercontent.google.com',

                'docs.google.com',
                'www.docs.google.com',
            ];


            /*
            |--------------------------------------------------------------------------
            | Cek Domain
            |--------------------------------------------------------------------------
            */

            if (
                !in_array(
                    $host,
                    $allowedHosts,
                    true
                )
            ) {

                abort(
                    403,
                    'Domain dokumen tidak diizinkan.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Request ke Sumber Dokumen
            |--------------------------------------------------------------------------
            */

            try {

                $response = Http::timeout(120)
                    ->connectTimeout(30)
                    ->withHeaders([
                        'User-Agent' =>
                        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/151.0 Safari/537.36',

                        'Accept' =>
                        'application/pdf,application/octet-stream,text/html,*/*',
                    ])
                    ->withOptions([
                        'allow_redirects' => [
                            'max' => 10,
                            'strict' => true,
                        ],
                    ])
                    ->get($requestUrl);
            } catch (\Throwable $e) {

                logger()->error(
                    'PDF Proxy Exception',
                    [
                        'original_url' =>
                        $url,

                        'request_url' =>
                        $requestUrl,

                        'message' =>
                        $e->getMessage(),

                        'file' =>
                        $e->getFile(),

                        'line' =>
                        $e->getLine(),
                    ]
                );


                abort(
                    502,
                    'Dokumen tidak dapat diambil dari server.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | HTTP Status
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                logger()->error(
                    'PDF Proxy HTTP Error',
                    [
                        'original_url' =>
                        $url,

                        'request_url' =>
                        $requestUrl,

                        'status' =>
                        $response->status(),

                        'content_type' =>
                        $response->header(
                            'Content-Type'
                        ),
                    ]
                );


                abort(
                    502,
                    'Server dokumen mengembalikan status '
                        . $response->status()
                        . '.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Content-Type
            |--------------------------------------------------------------------------
            */

            $contentType = strtolower(
                $response->header(
                    'Content-Type',
                    ''
                )
            );


            /*
            |--------------------------------------------------------------------------
            | Body
            |--------------------------------------------------------------------------
            */

            $body =
                $response->body();


            if (empty($body)) {

                logger()->error(
                    'PDF Proxy Empty Response',
                    [
                        'original_url' =>
                        $url,

                        'request_url' =>
                        $requestUrl,

                        'content_type' =>
                        $contentType,
                    ]
                );


                abort(
                    502,
                    'Dokumen yang diterima kosong.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Validasi PDF
            |--------------------------------------------------------------------------
            */

            $isPdf =
                str_starts_with(
                    $body,
                    '%PDF-'
                );


            if (!$isPdf) {

                logger()->error(
                    'PDF Proxy Invalid PDF',
                    [
                        'original_url' =>
                        $url,

                        'request_url' =>
                        $requestUrl,

                        'content_type' =>
                        $contentType,

                        'body_start' =>
                        substr(
                            $body,
                            0,
                            100
                        ),
                    ]
                );


                abort(
                    502,
                    'Dokumen tidak dapat ditampilkan sebagai PDF. '
                        . 'Pastikan repository dapat diakses secara publik.'
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
|
| Semua route di bawah ini:
|
| /library/...
|
| hanya dapat diakses oleh user:
|
| - authenticated
| - memiliki role admin/library sesuai middleware role
|
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


        Route::post(
            '/literatures',
            [LiteratureController::class, 'store']
        )->name('storeLiterature');


        Route::put(
            '/literatures/{literature}',
            [LiteratureController::class, 'update']
        )->name('updateLiterature');


        Route::delete(
            '/literatures/{literature}',
            [LiteratureController::class, 'destroy']
        )->name('destroyLiterature');


        /*
        |--------------------------------------------------------------------------
        | Kelola Repository Tesis & Disertasi
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/repositories',
            [RepositoryManagementController::class, 'manage']
        )->name('repositories');


        Route::post(
            '/repository',
            [RepositoryController::class, 'store']
        )->name('repository.store');


        Route::put(
            '/repository/{repository}',
            [RepositoryController::class, 'update']
        )->name('repository.update');


        Route::delete(
            '/repository/{repository}',
            [RepositoryController::class, 'destroy']
        )->name('repository.destroy');


        Route::patch(
            '/repository/{repository}/activate',
            [RepositoryController::class, 'activate']
        )->name('repository.activate');


        /*
        |--------------------------------------------------------------------------
        | HALAMAN KELOLA PRAKTIK INDUSTRI
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/praktik-industri',
            [PraktikIndustriAdminController::class, 'index']
        )->name('praktik-industri');


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT LAPORAN BERDASARKAN KELOMPOK
        |--------------------------------------------------------------------------
        |
        | {tim} adalah tim.id / nomor kelompok.
        |
        | Contoh URL hasil:
        |
        | /library/praktik-industri/group/472/history
        |
        */

        Route::get(
            '/praktik-industri/group/{tim}/history',
            [PraktikIndustriAdminController::class, 'history']
        )->name('praktik-industri.history');


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
    });
