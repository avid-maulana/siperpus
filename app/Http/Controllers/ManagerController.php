<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function manageLiteratures(Request $request)
    {
        $query = Literature::with(['category', 'type']);

        // Filter
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->year) {
            $query->where('year', $request->year);
        }
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('author', 'like', "%{$request->search}%");
            });
        }

        // Sort
        $sort = $request->sort ?? 'title';
        $direction = $request->direction ?? 'asc';
        $query->orderBy($sort, $direction);

        $literatures = $query->paginate(10);
        $categories = Category::all();

        return view('library.manage-literatures', compact('literatures', 'categories'));
    }
}
