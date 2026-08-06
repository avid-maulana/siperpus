<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'userCount'       => \App\Models\User::count(),
            'typeCount'       => Type::count(),

            'kbkCount' => DB::connection('master')
                ->table('data_kbk')
                ->count(),

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
        $typeOptions = Type::orderBy('name')
            ->pluck('name');

        $query = Literature::with([
            'category',
            'type',
        ]);

        // kode selanjutnya tetap

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

        if ($request->filled('type')) {

            $query->where('type', $request->type);
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
        | First Load
        |--------------------------------------------------------------------------
        */

        return view('literatures.index', [
            'literatures' => $literatures,
            'types'       => $typeOptions,
            'categories'  => Category::all(),
        ]);
    }
}
