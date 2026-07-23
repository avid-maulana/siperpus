<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type_id'];

    // Relasi ke Type (Many-to-one)
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    // Relasi ke Literatures (One-to-many)
    public function literatures()
    {
        return $this->hasMany(Literature::class);
    }
}
