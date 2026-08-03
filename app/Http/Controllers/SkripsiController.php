<?php

namespace App\Http\Controllers;

use App\Models\DataKbk;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkripsiController extends Controller
{
    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Data KBK
        |--------------------------------------------------------------------------
        */
        $kbks = DataKbk::orderBy('nama_kbk')->get();

        /*
        |--------------------------------------------------------------------------
        | Query Skripsi
        |--------------------------------------------------------------------------
        */
        $query = Skripsi::with([
            'user.dataJudul.kbk',
            'isi'
        ])
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
                ->where(function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nomor_induk', 'like', "%{$search}%");
                })
                ->pluck('user_id');

            $query->where(function ($query) use ($search, $userIds) {

                $query->whereRaw(
                    "REGEXP_REPLACE(judul, '<[^>]*>', ' ') LIKE ?",
                    ["%{$search}%"]
                );

                if ($userIds->isNotEmpty()) {
                    $query->orWhereIn('user_mahasiswa_id', $userIds);
                }
            });
        }

        /*
|--------------------------------------------------------------------------
| Filter KBK
|--------------------------------------------------------------------------
*/
        if ($request->filled('kbk')) {

            $userIds = DB::connection('sisinta')
                ->table('data_judul')
                ->where('id_kbk', $request->kbk)
                ->pluck('user_mahasiswa_id');

            $query->whereIn('user_mahasiswa_id', $userIds);
        }

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */
        $skripsis = $query
            ->latest('updated_at')
            ->paginate(12)
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
        return view('skripsi.index', [
            'skripsis' => $skripsis,
            'kbks'      => $kbks,
        ]);
    }
}
