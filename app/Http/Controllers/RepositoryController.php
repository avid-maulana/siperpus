<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
    /**
     * ================================================================
     * STORE
     * ================================================================
     *
     * Menambahkan repository baru.
     *
     * Jenis karya ditentukan oleh ADMIN:
     * - thesis
     * - dissertation
     *
     * Jika URL kosong:
     * - tidak membuat record
     * - tetap dianggap Belum Ada Repository
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pengajuan' => [
                'required',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Jenis Karya Ditentukan Admin
            |--------------------------------------------------------------------------
            */

            'jenis_karya' => [
                'required',
                'in:thesis,dissertation',
            ],

            'repository_url' => [
                'nullable',
                'url',
                'max:5000',
            ],

            'repository_type' => [
                'nullable',
                'in:file,folder',
            ],
        ]);


        $url = trim(
            $validated['repository_url'] ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | Jika URL kosong
        |--------------------------------------------------------------------------
        |
        | Jangan membuat record repository.
        |
        */

        if ($url === '') {
            return back()->with(
                'success',
                'Repository belum ditambahkan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan Repository
        |--------------------------------------------------------------------------
        |
        | Kombinasi:
        |
        | id_pengajuan
        | +
        | jenis_karya
        |
        | menjadi identitas repository.
        |
        */

        Repository::updateOrCreate(
            [
                'id_pengajuan' => $validated['id_pengajuan'],
                'jenis_karya' => $validated['jenis_karya'],
            ],
            [
                'repository_url' => $url,

                'repository_type' =>
                $validated['repository_type'] ?? null,

                /*
                |--------------------------------------------------------------------------
                | Repository baru selalu perlu ditangani.
                |--------------------------------------------------------------------------
                */

                'status' => 'needs_action',
            ]
        );


        return back()->with(
            'success',
            'Repository berhasil disimpan dan perlu ditangani.'
        );
    }


    /**
     * ================================================================
     * UPDATE
     * ================================================================
     *
     * Mengubah repository.
     *
     * Admin juga dapat mengubah:
     * - jenis karya
     * - URL
     * - tipe repository
     */
    public function update(
        Request $request,
        Repository $repository
    ) {
        $validated = $request->validate([
            /*
            |--------------------------------------------------------------------------
            | Jenis Karya
            |--------------------------------------------------------------------------
            |
            | Admin boleh mengubah:
            | Tesis ↔ Disertasi
            |
            */

            'jenis_karya' => [
                'required',
                'in:thesis,dissertation',
            ],

            'repository_url' => [
                'nullable',
                'url',
                'max:5000',
            ],

            'repository_type' => [
                'nullable',
                'in:file,folder',
            ],
        ]);


        $url = trim(
            $validated['repository_url'] ?? ''
        );


        /*
        |--------------------------------------------------------------------------
        | URL DIKOSONGKAN
        |--------------------------------------------------------------------------
        |
        | Jika admin menghapus URL kemudian menyimpan,
        | repository dihapus sepenuhnya.
        |
        | Hasil:
        |
        | 🟡 Belum Ada Repository
        |
        */

        if ($url === '') {

            $repository->delete();

            return back()->with(
                'success',
                'Repository berhasil dihapus.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $repository->update([
            'jenis_karya' =>
            $validated['jenis_karya'],

            'repository_url' =>
            $url,

            'repository_type' =>
            $validated['repository_type'] ?? null,

            /*
            |--------------------------------------------------------------------------
            | Setiap perubahan dianggap perlu diverifikasi ulang.
            |--------------------------------------------------------------------------
            */

            'status' =>
            'needs_action',
        ]);


        return back()->with(
            'success',
            'Repository berhasil diperbarui dan perlu ditangani kembali.'
        );
    }


    /**
     * ================================================================
     * ACTIVATE
     * ================================================================
     *
     * Mengubah:
     *
     * needs_action
     *       ↓
     * active
     */
    public function activate(
        Repository $repository
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan URL tersedia
        |--------------------------------------------------------------------------
        */

        if (
            !$repository->repository_url ||
            trim($repository->repository_url) === ''
        ) {
            return back()->with(
                'error',
                'Repository tidak dapat diaktifkan karena URL masih kosong.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Aktifkan
        |--------------------------------------------------------------------------
        */

        $repository->update([
            'status' => 'active',
        ]);


        return back()->with(
            'success',
            'Repository berhasil diaktifkan.'
        );
    }


    /**
     * ================================================================
     * DESTROY
     * ================================================================
     *
     * Menghapus repository dari SIPERPUS.
     *
     * Data SIADMIN tidak disentuh.
     */
    public function destroy(
        Repository $repository
    ) {
        $repository->delete();

        return back()->with(
            'success',
            'Repository berhasil dihapus.'
        );
    }
}
