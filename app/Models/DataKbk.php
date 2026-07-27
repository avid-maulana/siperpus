<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataKbk extends Model
{
    protected $connection = 'master';
    protected $table = 'data_kbk';
    protected $primaryKey = 'id';

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $guarded = [];
}