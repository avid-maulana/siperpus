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
     * - data tetap dianggap Belum Ada Repository
     *
     * Jika URL tersedia:
     * - repository dibuat / diperbarui
     * - status awal = needs_action
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pengajuan' => [
                'required',
                'string',
                'max:255',
            ],

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
        | URL kosong
        |--------------------------------------------------------------------------
        |
        | Tidak membuat record repository.
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
        | digunakan sebagai identitas repository.
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
                | Repository baru selalu perlu diverifikasi.
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
     * Mengubah repository yang sudah ada.
     *
     * Admin dapat mengubah:
     * - jenis karya
     * - URL repository
     * - tipe repository
     *
     * Setiap perubahan URL akan membuat status kembali:
     *
     * active
     *    ↓
     * needs_action
     *
     * sehingga repository perlu diverifikasi kembali.
     */
    public function update(
        Request $request,
        Repository $repository
    ) {
        $validated = $request->validate([
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
        | repository dihapus.
        |
        | Data karya kemudian kembali dianggap:
        |
        | Belum Ada Repository
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
        | UPDATE REPOSITORY
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
            | Perubahan repository harus diverifikasi ulang.
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
     *
     * Repository hanya dapat diaktifkan jika URL tersedia.
     */
    public function activate(
        Repository $repository
    ) {
        /*
        |--------------------------------------------------------------------------
        | Pastikan URL tersedia
        |--------------------------------------------------------------------------
        */

        $url = trim(
            $repository->repository_url ?? ''
        );


        if ($url === '') {

            return back()->with(
                'error',
                'Repository tidak dapat diaktifkan karena URL masih kosong.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Aktifkan Repository
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
