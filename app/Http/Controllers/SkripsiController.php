<?php

namespace App\Http\Controllers;

use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkripsiController extends Controller
{
    public function index(Request $request)
    {
        $query = Skripsi::with(['user', 'isi'])
            ->where('status_judul', 'SELESAI')
            ->whereHas('isi', function ($query) {
                $query->where('status', 'DITERIMA');
            });

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $userIds = DB::connection('master')
                ->table('user')
                ->where('nama_lengkap', 'like', "%{$search}%")
                ->pluck('user_id');

            $query->where(function ($query) use ($search, $userIds) {

                $query->where('judul', 'like', "%{$search}%");

                if ($userIds->isNotEmpty()) {
                    $query->orWhereIn('user_mahasiswa_id', $userIds);
                }

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $skripsis = $query
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | AJAX Request
        |--------------------------------------------------------------------------
        */

        if ($request->ajax()) {
            return view('skripsi._result', compact('skripsis'))->render();
        }

        /*
        |--------------------------------------------------------------------------
        | Normal Request
        |--------------------------------------------------------------------------
        */

        return view('skripsi.index', compact('skripsis'));
    }
}