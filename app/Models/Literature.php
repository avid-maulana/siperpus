<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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


    /*
    |--------------------------------------------------------------------------
    | ACCESSOR / MUTATOR: DETAIL
    |--------------------------------------------------------------------------
    |
    | Kolom 'detail' bertipe JSON di database (MySQL 8 otomatis
    | memberi CHECK constraint JSON_VALID untuk kolom JSON).
    |
    | Tapi di sisi form/Blade, 'detail' selalu diperlakukan sebagai
    | teks polos satu paragraf (dari <textarea>), bukan struktur data.
    |
    | Supaya kedua sisi cocok tanpa perlu ubah form/Blade lain:
    |
    | - SET (simpan)  -> selalu di-json_encode() jadi JSON string valid,
    |                    apa pun isinya.
    |
    | - GET (baca)    -> selalu dikembalikan sebagai string biasa ke PHP,
    |                    supaya aman dipakai di {{ }} (htmlspecialchars)
    |                    di Blade manapun tanpa perlu is_array() checking
    |                    di tiap tempat.
    |
    */

    protected function detail(): Attribute
    {
        return Attribute::make(

            get: function ($value) {

                if ($value === null) {
                    return null;
                }

                $decoded = json_decode($value, true);

                // Kasus normal: tersimpan sebagai JSON string ("tes").
                if (is_string($decoded)) {
                    return $decoded;
                }

                // Kasus data lama yang sempat tersimpan sebagai array/objek JSON.
                if (is_array($decoded)) {
                    return implode("\n", array_map('strval', $decoded));
                }

                // Kasus data lama yang bukan JSON valid sama sekali -> pakai apa adanya.
                return $value;

            },

            set: fn ($value) => json_encode((string) $value),

        );

    }


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