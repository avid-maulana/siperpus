<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraktikIndustriFile extends Model
{
    protected $connection = 'simpi';

    protected $table = 'revisi_ujians';

    protected $primaryKey = 'id';

    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'ujian_id',
        'file',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI LAPORAN
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi file revisi ke laporan Praktik Industri.
     *
     * revisi_ujians.ujian_id
     *          ↓
     * ujians.id
     */
    public function praktikIndustri()
    {
        return $this->belongsTo(
            PraktikIndustri::class,
            'ujian_id',
            'id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | URL FILE REVISI
    |--------------------------------------------------------------------------
    */

    /**
     * Menghasilkan URL file revisi.
     *
     * .env:
     *
     * SIMPI_STORAGE_URL=https://tei.um.ac.id/simpi/public/storage
     *
     * Database:
     *
     * revisi_xxx.pdf
     *
     * Hasil:
     *
     * https://tei.um.ac.id/simpi/public/storage/revisi/revisi_xxx.pdf
     */
    public function getFileRevisiUrlAttribute()
    {
        if (empty($this->file)) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | BASE URL DARI ENV
        |--------------------------------------------------------------------------
        */

        $baseUrl = env(
            'SIMPI_STORAGE_URL',
            ''
        );

        if (empty($baseUrl)) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN URL DAN PATH
        |--------------------------------------------------------------------------
        */

        $baseUrl = rtrim(
            $baseUrl,
            '/'
        );

        $path = ltrim(
            $this->file,
            '/'
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH URL LENGKAP
        |--------------------------------------------------------------------------
        */

        if (
            str_starts_with(
                $path,
                'http://'
            )
            ||
            str_starts_with(
                $path,
                'https://'
            )
        ) {
            return $path;
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA SUDAH MEMILIKI FOLDER REVISI
        |--------------------------------------------------------------------------
        |
        | Database:
        |
        | revisi/revisi_xxx.pdf
        |
        */

        if (
            str_starts_with(
                $path,
                'revisi/'
            )
        ) {
            return $baseUrl . '/' . $path;
        }


        /*
        |--------------------------------------------------------------------------
        | DEFAULT FILE REVISI
        |--------------------------------------------------------------------------
        |
        | Database:
        |
        | revisi_xxx.pdf
        |
        | Menjadi:
        |
        | {SIMPI_STORAGE_URL}/revisi/revisi_xxx.pdf
        |
        */

        return $baseUrl . '/revisi/' . $path;
    }
}