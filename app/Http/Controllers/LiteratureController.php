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
        | Response AJAX
        |--------------------------------------------------------------------------
        | Kalau request datang dari fetch() di literatures.js (ditandai header
        | X-Requested-With), cukup balikin partial _result saja, bukan full
        | page. Kalau ini tidak dicek, seluruh halaman (layout + hero + search
        | bar) ikut di-inject ke dalam #resultsContainer di sisi client.
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {
            return view('literatures._result', [
                'literatures' => $literatures,
                'categories' => $categories,
            ])->render();
        }


        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('literatures.index', [
            'literatures' => $literatures,
            'types' => $types,
            'categories' => $categories,
            'totalLiteratures' => $totalLiteratures,
        ]);
    }


    /**
     * Simpan Literatur Baru
     */
    public function store(Request $request)
    {
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

        Literature::create(
            $validated
        );

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

        $literature->update(
            $validated
        );

        return redirect()
            ->route('library.indexLiterature')
            ->with(
                'success',
                'Literatur berhasil diperbarui.'
            );
    }


    /**
     * Hapus Literatur
     */
    public function destroy(Literature $literature)
    {
        $literature->delete();

        return redirect()
            ->route('library.indexLiterature')
            ->with(
                'success',
                'Literatur berhasil dihapus.'
            );
    }
}
