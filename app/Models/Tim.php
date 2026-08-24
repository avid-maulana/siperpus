<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $connection = 'simpi';

    protected $table = 'tims';

    /**
     * Relasi ke detail anggota tim.
     */
    public function detailTims()
    {
        return $this->hasMany(
            DetailTim::class,
            'tim_id',
            'id'
        );
    }

    /**
     * Relasi ke ketua tim.
     */
    public function ketua()
    {
        return $this->belongsTo(
            User::class,
            'ketua_user_id',
            'user_id'
        );
    }

    /**
     * Relasi ke industri tempat Praktik Industri.
     */
    public function industri()
    {
        return $this->belongsTo(
            Industri::class,
            'industri_id',
            'id'
        );
    }
}