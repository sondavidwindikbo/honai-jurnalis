<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'status',
        'published_at',
        'views',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured'  => 'boolean',
        ];
    }

    // Artikel dimiliki oleh satu user (penulis)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Artikel masuk ke satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Artikel bisa punya banyak komentar
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Artikel bisa punya banyak tag (many-to-many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Hanya ambil artikel yang sudah published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Hanya ambil artikel featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Artikel trending: published, urutkan by views, prioritaskan 7 hari terakhir
    public function scopeTrending($query, int $days = 7, int $limit = 5)
    {
        return $query->published()
            ->where('published_at', '>=', now()->subDays($days))
            ->orderByDesc('views')
            ->limit($limit);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
