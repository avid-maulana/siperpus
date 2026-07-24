<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use Illuminate\Http\Request;

class LiteratureController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        return view('home', [
            'literatureCount' => Literature::count(),
            'categoryCount'   => Category::count(),
            'typeCount'       => Type::count(),

            'latestLiteratures' => Literature::with('category')
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }

    /**
     * Daftar Literatur
     */
    public function index(Request $request)
    {
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

            $keyword = trim($request->search);

            $query->where(function ($q) use ($keyword) {

                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('author', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tipe
        |--------------------------------------------------------------------------
        */

        if ($request->filled('type_id')) {

            $query->where('type_id', $request->type_id);

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Kategori
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category_id')) {

            $query->where('category_id', $request->category_id);

        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $literatures = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | AJAX Request
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {

            return view('literatures._result', compact('literatures'));

        }

        /*
        |--------------------------------------------------------------------------
        | First Load
        |--------------------------------------------------------------------------
        */

        return view('literatures.index', [
            'literatures' => $literatures,
            'types'       => Type::all(),
            'categories'  => Category::all(),
        ]);
    }
}