<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraktikIndustriFile extends Model
{
    protected $connection = 'simpi';

    protected $table = 'revisi_ujians';

    protected $primaryKey = 'id';

    public $timestamps = true;

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
}
