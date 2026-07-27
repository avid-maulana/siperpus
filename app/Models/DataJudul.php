<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DataKbk;

class DataJudul extends Model
{
    protected $connection = 'sisinta';
    protected $table = 'data_judul';
    protected $primaryKey = 'id_judul';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];

    public function kbk()
    {
        return $this->belongsTo(DataKbk::class, 'id_kbk', 'id');
    }
}