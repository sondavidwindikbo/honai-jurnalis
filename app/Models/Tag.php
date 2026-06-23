<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    // Tag bisa ada di banyak artikel (many-to-many)
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
