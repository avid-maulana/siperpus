<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;
    protected $connection = 'sisinta';
    protected $table = 'data_judul';
    protected $primaryKey = 'id_judul';
    public $timestamps = true;

    public function isi()
    {
        return $this->hasOne(IsiSkripsi::class, 'user_mahasiswa_id', 'user_mahasiswa_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_mahasiswa_id', 'user_id');
    }
}
