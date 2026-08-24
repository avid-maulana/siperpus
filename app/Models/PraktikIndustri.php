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

    /**
     * Relasi laporan ke detail tim.
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

    /**
     * Semua file revisi yang pernah tersedia
     * untuk laporan Praktik Industri.
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

    /**
     * Mengambil file revisi terbaru yang memiliki file.
     *
     * Revisi dengan file NULL atau kosong tidak dihitung.
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

    /**
     * Mengambil tanggal terakhir file aktif diperbarui.
     *
     * Prioritas:
     *
     * 1. updated_at file revisi terbaru
     * 2. updated_at laporan utama
     */
    public function getTanggalTerakhirDiperbaruiAttribute()
    {
        if ($this->relationLoaded('fileTerbaru')) {

            return $this->fileTerbaru?->updated_at
                ?? $this->updated_at;
        }

        return $this->fileTerbaru?->updated_at
            ?? $this->updated_at;
    }


    /*
|--------------------------------------------------------------------------
| URL FILE LAPORAN UTAMA
|--------------------------------------------------------------------------
*/

    /**
     * Menghasilkan URL file laporan utama.
     *
     * Jika database menyimpan:
     *
     *     /revisi/revisi_xxx.pdf
     *
     * maka diarahkan ke:
     *
     *     https://tei.um.ac.id/simpi/public/storage/revisi/revisi_xxx.pdf
     *
     * Jika database hanya menyimpan:
     *
     *     laporan_xxx.pdf
     *
     * maka diarahkan ke:
     *
     *     https://tei.um.ac.id/simpi/public/storage/laporan-pi/laporan_xxx.pdf
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

    /**
     * Menghasilkan URL file revisi terbaru.
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
*/

    /**
     * Menghasilkan URL file yang digunakan
     * pada halaman Praktik Industri.
     *
     * Prioritas:
     *
     * 1. Revisi terbaru
     * 2. File laporan utama
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

    /**
     * Mengubah path database menjadi URL file
     * pada server SIMPI.
     */
    protected function makeFileUrl($path)
    {
        if (!$path) {
            return null;
        }

        /*
    |--------------------------------------------------------------------------
    | Bersihkan slash di awal
    |--------------------------------------------------------------------------
    */

        $path = ltrim($path, '/');


        /*
    |--------------------------------------------------------------------------
    | Jika path sudah memiliki folder
    |--------------------------------------------------------------------------
    |
    | Contoh:
    |
    | revisi/revisi_xxx.pdf
    | laporan-pi/laporan_xxx.pdf
    |
    */

        if (
            str_starts_with($path, 'revisi/')
            || str_starts_with($path, 'laporan-pi/')
        ) {
            return 'https://tei.um.ac.id/simpi/public/storage/' . $path;
        }


        /*
    |--------------------------------------------------------------------------
    | File laporan biasa
    |--------------------------------------------------------------------------
    |
    | Contoh database:
    |
    | laporan_691_176653455.pdf
    |
    */

        return 'https://tei.um.ac.id/simpi/public/storage/laporan-pi/' . $path;
    }
}
