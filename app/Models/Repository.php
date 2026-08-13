<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    protected $table = 'repositories';

    protected $connection = 'mysql';

    protected $fillable = [
        'id_pengajuan',
        'jenis_karya',
        'repository_url',
        'repository_type',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
