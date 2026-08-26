<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraktikIndustri extends Model
{
    protected $connection = 'simpi';

    protected $table = 'ujians';

    protected $primaryKey = 'id';

    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'detail_tim_id',
        'judul',
        'file_laporan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'kategori',
        'link_meeting',
        'ruangan_id',
        'status',
        'catatan_ujian',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI DETAIL TIM
    |--------------------------------------------------------------------------
    */

    public function detailTim()
    {
        return $this->belongsTo(
            DetailTim::class,
            'detail_tim_id',
            'id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI FILE REVISI
    |--------------------------------------------------------------------------
    */

    public function fileLaporan()
    {
        return $this->hasMany(
            PraktikIndustriFile::class,
            'ujian_id',
            'id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FILE REVISI TERBARU
    |--------------------------------------------------------------------------
    */

    public function fileTerbaru()
    {
        return $this->hasOne(
            PraktikIndustriFile::class,
            'ujian_id',
            'id'
        )
            ->whereNotNull('file')
            ->where('file', '!=', '')
            ->latestOfMany('updated_at');
    }


    /*
    |--------------------------------------------------------------------------
    | TANGGAL TERAKHIR DIPERBARUI
    |--------------------------------------------------------------------------
    */

    public function getTanggalTerakhirDiperbaruiAttribute()
    {
        return $this->fileTerbaru?->updated_at
            ?? $this->updated_at;
    }


    /*
    |--------------------------------------------------------------------------
    | URL FILE LAPORAN UTAMA
    |--------------------------------------------------------------------------
    */

    public function getFileLaporanUrlAttribute()
    {
        return $this->makeFileUrl(
            $this->file_laporan
        );
    }


    /*
    |--------------------------------------------------------------------------
    | URL FILE REVISI TERBARU
    |--------------------------------------------------------------------------
    */

    public function getFileRevisiUrlAttribute()
    {
        return $this->makeFileUrl(
            $this->fileTerbaru?->file
        );
    }


    /*
    |--------------------------------------------------------------------------
    | URL FILE AKTIF
    |--------------------------------------------------------------------------
    |
    | Prioritas:
    |
    | 1. Revisi terbaru
    | 2. File laporan utama
    |
    */

    public function getFileAktifUrlAttribute()
    {
        $file = $this->fileTerbaru?->file
            ?: $this->file_laporan;

        return $this->makeFileUrl($file);
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER URL FILE
    |--------------------------------------------------------------------------
    */

    protected function makeFileUrl($path)
    {
        if (empty($path)) {
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
        | BERSIHKAN PATH
        |--------------------------------------------------------------------------
        */

        $baseUrl = rtrim(
            $baseUrl,
            '/'
        );

        $path = ltrim(
            $path,
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
        | FILE REVISI
        |--------------------------------------------------------------------------
        |
        | Database:
        |
        | revisi/revisi_xxx.pdf
        |
        | Menjadi:
        |
        | {SIMPI_STORAGE_URL}/revisi/revisi_xxx.pdf
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
        | FILE LAPORAN
        |--------------------------------------------------------------------------
        |
        | Database:
        |
        | laporan_xxx.pdf
        |
        | Menjadi:
        |
        | {SIMPI_STORAGE_URL}/laporan-pi/laporan_xxx.pdf
        |
        */

        if (
            str_starts_with(
                $path,
                'laporan-pi/'
            )
        ) {
            return $baseUrl . '/' . $path;
        }


        /*
        |--------------------------------------------------------------------------
        | DEFAULT = LAPORAN PI
        |--------------------------------------------------------------------------
        */

        return $baseUrl . '/laporan-pi/' . $path;
    }
}