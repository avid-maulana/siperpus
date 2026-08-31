<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use Illuminate\Http\Request;

class LiteratureController extends Controller
{
    /**
     * Daftar Literatur
     */
    public function index(Request $request)
    {
        // ...method index() yang sudah ada, tidak diubah...
    }


    /**
     * Simpan Literatur Baru
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'cover_url' => [
                'nullable',
                'url',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],

            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'file_url' => [
                'required',
                'url',
            ],

            'detail' => [
                'required',
                'string',
            ],

            'description' => [
                'required',
                'string',
                'max:255',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan Literatur Baru
        |--------------------------------------------------------------------------
        */

        Literature::create(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('library.indexLiterature')
            ->with(
                'success',
                'Literatur berhasil ditambahkan.'
            );
    }


    /**
     * Update Literatur
     */
    public function update(Request $request, Literature $literature)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'cover_url' => [
                'nullable',
                'url',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'author' => [
                'required',
                'string',
                'max:255',
            ],

            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],

            'year' => [
                'required',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'file_url' => [
                'required',
                'url',
            ],

            'detail' => [
                'required',
                'string',
            ],

            'description' => [
                'required',
                'string',
                'max:255',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Update Literatur
        |--------------------------------------------------------------------------
        */

        $literature->update(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('library.indexLiterature')
            ->with(
                'success',
                'Literatur berhasil diperbarui.'
            );
    }
}