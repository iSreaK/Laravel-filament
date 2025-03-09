<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'alt_text',
        'imageable_id',
        'imageable_type'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Ajoutons un accesseur pour le chemin de l'image
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('images/' . $value)
        );
    }
}
