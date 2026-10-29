<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $table = 'films';
    protected $fillable = ['title','sinopsis','year','poster','genre_id'];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function getPosterUrlAttribute(): string
    {
        $poster = (string) $this->poster;

        if (filter_var($poster, FILTER_VALIDATE_URL)) {
            return $poster;
        }

        return asset('template/images/' . basename($poster));
    }
}
