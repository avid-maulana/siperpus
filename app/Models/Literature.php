<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Literature extends Model
{
    use HasFactory;
    protected $fillable = [
        'cover_url',
        'title',
        'author',
        'publisher',
        'year',
        'file_url',
        'category_id',
        'description',
        'detail',
    ];

    // Relasi ke Category (Many-to-one)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke Type melalui Category (Indirect relationship)
    public function type()
    {
        return $this->hasOneThrough(Type::class, Category::class, 'id', 'id', 'category_id', 'type_id');
    }
}
