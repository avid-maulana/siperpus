<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'master';
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'no_hp',
        'nomor_induk',
        'nama_lengkap',
        'tahun_masuk',
        'jenjang',
        'kode_prodi',
        'jenis_kelamin',
        'status',
        'password',
        'pwd_hash',
        'kat_no_induk',
        'level',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke data skripsi.
     */
    public function skripsi()
    {
        return $this->hasMany(Skripsi::class, 'user_mahasiswa_id', 'user_id');
    }

    /**
     * Relasi ke data_judul.
     */
    public function dataJudul()
    {
        return $this->hasOne(DataJudul::class, 'user_mahasiswa_id', 'user_id');
    }
}
