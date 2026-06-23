<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleList extends Component
{
    use WithPagination;

    // Bisa diisi dari route (kategori) atau dari input (pencarian)
    public ?string $categorySlug = null;
    public string  $search       = '';
    public string  $sortBy       = 'latest';

    public function mount(?string $categorySlug = null): void
    {
        $this->categorySlug = $categorySlug;

        // Ambil query search dari URL kalau ada (?q=...)
        $this->search = request('q', '');
    }

    // Reset pagination kalau user ganti sort atau search
    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Article::published()
            ->with(['user', 'category']);

        // Filter kategori kalau ada
        if ($this->categorySlug) {
            $query->whereHas('category', fn ($q) =>
                $q->where('slug', $this->categorySlug)
            );
        }

        // Filter pencarian
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Sorting
        match ($this->sortBy) {
            'popular' => $query->orderByDesc('views'),
            'oldest'  => $query->orderBy('published_at'),
            default   => $query->orderByDesc('published_at'),
        };

        $articles = $query->paginate(9);

        // Data tambahan untuk sidebar & header
        $category    = $this->categorySlug
            ? Category::where('slug', $this->categorySlug)->first()
            : null;

        $allCategories = Category::withCount(['articles' => fn ($q) =>
            $q->where('status', 'published')
        ])->get();

        $totalResults = $query->toBase()->getCountForPagination();

        return view('livewire.article-list', [
            'articles'      => $articles,
            'category'      => $category,
            'allCategories' => $allCategories,
            'totalResults'  => $totalResults,
        ])->layout('layouts.app', [
            'title' => $category
                ? $category->name . ' — Honai Jurnalis Kampung'
                : ($this->search ? 'Hasil Cari: ' . $this->search : 'Semua Artikel'),
        ]);
    }
}
