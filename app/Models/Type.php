<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    // Relasi ke Categories (One-to-many)
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
