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
        | Total Seluruh Literatur
        |--------------------------------------------------------------------------
        |
        | Tidak terpengaruh search, filter type, maupun category.
        |
        */

        $totalLiteratures = Literature::count();


        /*
        |--------------------------------------------------------------------------
        | Type Options
        |--------------------------------------------------------------------------
        */

        $typeOptions = Type::orderBy('name')
            ->pluck('name');


        /*
        |--------------------------------------------------------------------------
        | Literature Query
        |--------------------------------------------------------------------------
        */

        $query = Literature::with([
            'category',
            'type',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Live Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $keyword = trim(
                $request->search
            );

            $query->where(function ($q) use ($keyword) {

                $q->where(
                    'title',
                    'like',
                    "%{$keyword}%"
                )
                    ->orWhere(
                        'author',
                        'like',
                        "%{$keyword}%"
                    )
                    ->orWhere(
                        'description',
                        'like',
                        "%{$keyword}%"
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Type
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type')) {

            $query->whereHas(
                'category.type',
                function ($q) use ($request) {

                    $q->where(
                        'name',
                        $request->type
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Filter Category
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category_id')) {

            $query->where(
                'category_id',
                $request->category_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $literatures = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | AJAX Request
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return view('literatures._result', [
                'literatures' => $literatures,
                'categories'  => Category::all(),
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Normal Request
        |--------------------------------------------------------------------------
        */

        return view('literatures.index', [
            'literatures'      => $literatures,
            'types'            => $typeOptions,
            'categories'       => Category::all(),

            // Total keseluruhan repository
            'totalLiteratures' => $totalLiteratures,
        ]);
    }
}
