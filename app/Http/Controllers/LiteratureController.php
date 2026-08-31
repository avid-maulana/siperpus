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
        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->input('search', '')
        );

        $typeName = trim(
            $request->input('type', '')
        );

        $categoryId = $request->input('category_id');


        /*
        |--------------------------------------------------------------------------
        | Query Literatur
        |--------------------------------------------------------------------------
        */

        $literatures = Literature::query()
            ->with('category.type')
            ->when(
                $search !== '',
                function ($query) use ($search) {

                    $query->where(
                        function ($query) use ($search) {

                            $query->where('title', 'like', "%{$search}%")
                                ->orWhere('author', 'like', "%{$search}%");

                        }
                    );

                }
            )
            ->when(
                $typeName !== '',
                function ($query) use ($typeName) {

                    /*
                    |--------------------------------------------------------------------------
                    | Tipe di sini merujuk ke tabel 'types' (sama seperti
                    | 'Kelola Tipe' admin), diakses lewat relasi
                    | Category -> Type. Bukan kolom enum lama di
                    | literatures.type yang sudah tidak dipakai.
                    |--------------------------------------------------------------------------
                    */

                    $query->whereHas(
                        'category.type',
                        function ($query) use ($typeName) {

                            $query->where('name', $typeName);

                        }
                    );

                }
            )
            ->when(
                $categoryId,
                function ($query) use ($categoryId) {

                    $query->where('category_id', $categoryId);

                }
            )
            ->latest()
            ->paginate(9)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Tipe (dari tabel types, bukan enum)
        |--------------------------------------------------------------------------
        */

        $types = Type::pluck('name');


        /*
        |--------------------------------------------------------------------------
        | Kategori
        |--------------------------------------------------------------------------
        */

        $categories = Category::with('type')->get();


        /*
        |--------------------------------------------------------------------------
        | Total Literatur (tidak terpengaruh filter, untuk hero)
        |--------------------------------------------------------------------------
        */

        $totalLiteratures = Literature::count();


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('literatures.index', [
            'literatures'       => $literatures,
            'types'             => $types,
            'categories'        => $categories,
            'totalLiteratures'  => $totalLiteratures,
        ]);
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