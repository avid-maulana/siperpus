<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use Illuminate\Http\Request;

class LiteratureController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Welcome Page
    |--------------------------------------------------------------------------
    */

    public function home()
    {
        return view('home', [
            'literatureCount' => Literature::count(),
            'categoryCount'   => Category::count(),
            'typeCount'       => Type::count(),

            // 6 literatur terbaru
            'latestLiteratures' => Literature::with('category')
                ->latest()
                ->take(6)
                ->get(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Daftar Literatur
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $types = Type::with('categories')->get();
        $categories = Category::all();

        $query = Literature::with(['category', 'type']);

        // Pencarian
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");

            });

        }

        // Filter berdasarkan tipe
        if ($request->filled('type_id')) {

            $query->whereHas('category.type', function ($q) use ($request) {

                $q->where('id', $request->type_id);

            });

        }

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {

            $query->where('category_id', $request->category_id);

        }

        $literatures = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('literatures.index', [
            'literatures' => $literatures,
            'categories'  => $categories,
            'types'       => $types,
        ]);
    }
}