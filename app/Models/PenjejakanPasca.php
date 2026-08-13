<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjejakanPasca extends Model
{
    protected $table = 'penjejakan_pasca';

    protected $connection = 'siadmin';

    public $timestamps = false;

    protected $guarded = [];
}
