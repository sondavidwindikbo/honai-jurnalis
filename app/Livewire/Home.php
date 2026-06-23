<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Tag;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        // Artikel utama hero (paling baru yang featured, fallback ke paling baru biasa)
        $heroMain = Article::published()
            ->featured()
            ->latest('published_at')
            ->first()
            ?? Article::published()->latest('published_at')->first();

        // 2 artikel sisi kanan hero (selain hero utama)
        $heroSide = Article::published()
            ->when($heroMain, fn ($q) => $q->where('id', '!=', $heroMain->id))
            ->latest('published_at')
            ->take(2)
            ->get();

        // Berita terkini (3 kartu, setelah yang sudah dipakai di hero)
        $excludedIds = collect([$heroMain?->id])->merge($heroSide->pluck('id'))->filter();
        $latestNews = Article::published()
            ->whereNotIn('id', $excludedIds)
            ->latest('published_at')
            ->take(3)
            ->get();

        // Daftar berita panjang (story list bernomor di kolom kiri bawah)
        $excludedIds2 = $excludedIds->merge($latestNews->pluck('id'));
        $storyList = Article::published()
            ->whereNotIn('id', $excludedIds2)
            ->latest('published_at')
            ->take(5)
            ->get();

        // Trending sidebar (fallback kalau kosong dalam 7 hari)
        $trending = Article::trending()->get();
        if ($trending->isEmpty()) {
            $trending = Article::published()->orderByDesc('views')->take(5)->get();
        }

        // Tag cloud
        $tags = Tag::has('articles')->limit(12)->get();

        return view('livewire.home', [
            'heroMain'   => $heroMain,
            'heroSide'   => $heroSide,
            'latestNews' => $latestNews,
            'storyList'  => $storyList,
            'trending'   => $trending,
            'tags'       => $tags,
        ])->layout('layouts.app', ['title' => 'Beranda — Honai Jurnalis Kampung']);
    }
}
