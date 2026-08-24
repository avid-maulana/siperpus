<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    protected $connection = 'simpi';

    protected $table = 'industris';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'jabatan',
        'kontak',
    ];

    /**
     * Relasi industri ke tim Praktik Industri.
     */
    public function tims()
    {
        return $this->hasMany(
            Tim::class,
            'industri_id',
            'id'
        );
    }
}