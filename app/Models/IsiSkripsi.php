<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiSkripsi extends Model
{
    use HasFactory;
    protected $connection = 'sisinta';
    protected $table = 'berkas_akhir';
    protected $primaryKey = 'user_mahasiswa_id';
    public $timestamps = true;

    public function skripsi()
    {
        return $this->belongsTo(Skripsi::class, 'user_mahasiswa_id', 'user_mahasiswa_id');
    }
}
