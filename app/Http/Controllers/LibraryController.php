<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Literature;
use App\Models\Type;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Admin
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        return view('library.index', [
            'types'             => Type::all(),
            'categories'        => Category::with('type')->get(),
            'totalTypes'        => Type::count(),
            'totalCategories'   => Category::count(),
            'totalLiteratures'  => Literature::count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Kelola Literatur
    |--------------------------------------------------------------------------
    */

    public function indexLiterature()
    {
        return view('library.literatures.index', [
            'types'       => Type::all(),
            'categories'  => Category::all(),
            'literatures' => Literature::with('category')
                ->latest()
                ->paginate(10),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Type
    |--------------------------------------------------------------------------
    */

    public function storeType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Type::create($validated);

        return redirect()
            ->route('library.index')
            ->with('success', 'Tipe berhasil ditambahkan.');
    }

    public function updateType(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Type::findOrFail($id)->update($validated);

        return redirect()
            ->route('library.index')
            ->with('success', 'Tipe berhasil diperbarui.');
    }

    public function destroyType($id)
    {
        Type::findOrFail($id)->delete();

        return redirect()
            ->route('library.index')
            ->with('success', 'Tipe berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        Category::create($validated);

        return redirect()
            ->route('library.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateCategory(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        Category::findOrFail($id)->update($validated);

        return redirect()
            ->route('library.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory($id)
    {
        Category::findOrFail($id)->delete();

        return redirect()
            ->route('library.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Literature
    |--------------------------------------------------------------------------
    */

    public function storeLiterature(Request $request)
    {
        $validated = $request->validate([
            'cover_url'   => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'required|integer',
            'file_url'    => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'detail'      => 'nullable|string',
        ]);

        if (!empty($validated['detail'])) {
            $validated['detail'] = json_encode([
                'description' => $validated['detail'],
            ]);
        }

        Literature::create($validated);

        return redirect()
            ->route('library.indexLiterature')
            ->with('success', 'Literatur berhasil ditambahkan.');
    }

    public function updateLiterature(Request $request, $id)
    {
        $validated = $request->validate([
            'cover_url'   => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'required|integer',
            'file_url'    => 'required|url',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'detail'      => 'nullable|string',
        ]);

        if (!empty($validated['detail'])) {
            $validated['detail'] = json_encode([
                'description' => $validated['detail'],
            ]);
        }

        Literature::findOrFail($id)->update($validated);

        return redirect()
            ->route('library.indexLiterature')
            ->with('success', 'Literatur berhasil diperbarui.');
    }

    public function destroyLiterature($id)
    {
        Literature::findOrFail($id)->delete();

        return redirect()
            ->route('library.indexLiterature')
            ->with('success', 'Literatur berhasil dihapus.');
    }
}
