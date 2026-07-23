<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\LiteratureController;
use App\Http\Controllers\SkripsiController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Member
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Welcome
    Route::get('/', [LiteratureController::class, 'home'])
        ->name('home');

    // Literatur
    Route::get('/literatures', [LiteratureController::class, 'index'])
        ->name('literatures.index');

    // Skripsi
    Route::get('/skripsi', [SkripsiController::class, 'index'])
        ->name('skripsi.index');

    // PDF Viewer
    Route::get('/pdf-viewer', function () {

        return view('pdf_viewer', [
            'pdfPath' => request('path')
        ]);

    })->name('pdf.viewer');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */

    Route::middleware('role')
        ->prefix('library')
        ->name('library.')
        ->group(function () {

            // Dashboard
            Route::get('/', [LibraryController::class, 'index'])
                ->name('index');

            // Kelola Literatur
            Route::get('/literatures', [LibraryController::class, 'indexLiterature'])
                ->name('indexLiterature');

            // Type
            Route::post('/store-type', [LibraryController::class, 'storeType'])
                ->name('storeType');

            Route::put('/update-type/{id}', [LibraryController::class, 'updateType'])
                ->name('updateType');

            Route::delete('/destroy-type/{id}', [LibraryController::class, 'destroyType'])
                ->name('destroyType');

            // Category
            Route::post('/store-category', [LibraryController::class, 'storeCategory'])
                ->name('storeCategory');

            Route::put('/update-category/{id}', [LibraryController::class, 'updateCategory'])
                ->name('updateCategory');

            Route::delete('/destroy-category/{id}', [LibraryController::class, 'destroyCategory'])
                ->name('destroyCategory');

            // Literature
            Route::post('/store-literature', [LibraryController::class, 'storeLiterature'])
                ->name('storeLiterature');

            Route::put('/update-literature/{id}', [LibraryController::class, 'updateLiterature'])
                ->name('updateLiterature');

            Route::delete('/destroy-literature/{id}', [LibraryController::class, 'destroyLiterature'])
                ->name('destroyLiterature');
        });
});