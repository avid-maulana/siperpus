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
            'types'            => Type::all(),
            'categories'       => Category::with('type')->get(),
            'totalTypes'       => Type::count(),
            'totalCategories'  => Category::count(),
            'totalLiteratures' => Literature::count(),
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
            'types'      => Type::all(),
            'categories' => Category::all(),

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

        $type = Type::findOrFail($id);

        $type->update($validated);

        return redirect()
            ->route('library.index')
            ->with('success', 'Tipe berhasil diperbarui.');
    }

    public function destroyType($id)
    {
        $type = Type::findOrFail($id);

        $type->delete();

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
            'name'    => 'required|string|max:255',
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
            'name'    => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
        ]);

        $category = Category::findOrFail($id);

        $category->update($validated);

        return redirect()
            ->route('library.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

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
            'cover_url' => 'nullable|url',
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'required|integer|min:1900|max:' . date('Y'),
            'file_url'    => 'required|url|max:2048',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'detail'      => 'nullable|string',
        ]);

        /*
         * Detail disimpan dalam format JSON.
         */
        if (!empty($validated['detail'])) {
            $validated['detail'] = json_encode([
                'description' => $validated['detail'],
            ], JSON_UNESCAPED_UNICODE);
        }

        Literature::create($validated);

        return redirect()
            ->route('library.indexLiterature')
            ->with('success', 'Literatur berhasil ditambahkan.');
    }

    public function updateLiterature(Request $request, $id)
    {
        /*
         * Ambil literature terlebih dahulu.
         */
        $literature = Literature::findOrFail($id);

        /*
         * Cover URL dibuat nullable.
         *
         * Jika user tidak memilih "Ganti Cover",
         * input ini boleh kosong dan cover lama akan tetap digunakan.
         */
        $validated = $request->validate([
            'cover_url'   => 'nullable|url|max:2048',
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'required|integer|min:1900|max:' . date('Y'),
            'file_url'    => 'required|url|max:2048',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'detail'      => 'nullable|string',
        ]);

        /*
         * Kalau cover baru tidak diberikan,
         * jangan update kolom cover_url.
         */
        if (empty($validated['cover_url'])) {
            unset($validated['cover_url']);
        }

        /*
         * Detail disimpan dalam format JSON.
         */
        if (!empty($validated['detail'])) {
            $validated['detail'] = json_encode([
                'description' => $validated['detail'],
            ], JSON_UNESCAPED_UNICODE);
        }

        /*
         * Update literature.
         */
        $literature->update($validated);

        return redirect()
            ->route('library.indexLiterature')
            ->with('success', 'Literatur berhasil diperbarui.');
    }

    public function destroyLiterature($id)
    {
        $literature = Literature::findOrFail($id);

        $literature->delete();

        return redirect()
            ->route('library.indexLiterature')
            ->with('success', 'Literatur berhasil dihapus.');
    }
}