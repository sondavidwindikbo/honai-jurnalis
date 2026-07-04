<?php

// use App\Livewire\Home;
// use Illuminate\Support\Facades\Route;
// use App\Livewire\ArticleShow;


// // Halaman Beranda
// Route::get('/', Home::class)->name('home');
// // Route::get('/', function () {
// //     return view('welcome');
// // })->name('home');

// // Halaman Daftar Artikel per Kategori
// Route::get('/kategori/{category:slug}', function () {
//     return view('welcome'); // sementara, nanti diganti komponen Livewire
// })->name('category.show');

// // Halaman Detail Artikel
// Route::get('/artikel/{article:slug}', function () {
//     return view('welcome'); // sementara, nanti diganti komponen Livewire
// })->name('article.show');

// // Halaman Pencarian
// Route::get('/cari', function () {
//     return view('welcome'); // sementara
// })->name('search');

// //halaman show artikel
// Route::get('/artikel/{article:slug}', ArticleShow::class)->name('article.show'); -->



use App\Livewire\Home;
use App\Livewire\ArticleShow;
use App\Livewire\ArticleList;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/artikel/{article:slug}', ArticleShow::class)->name('article.show');
Route::get('/kategori/{categorySlug}', ArticleList::class)->name('category.show');
Route::get('/cari', ArticleList::class)->name('search');

// Redirect otomatis sesuai role setelah login
Route::middleware('auth')->get('/redirect-panel', function () {
    $role = auth()->user()->role;
    return match ($role) {
        'admin'   => redirect('/admin'),
        'editor'  => redirect('/editor'),
        'penulis' => redirect('/penulis'),
        default   => redirect('/'),
    };
})->name('panel.redirect');

// Override logout untuk panel editor & penulis
Route::post('/editor/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/editor/login');
})->name('filament.editor.auth.logout')->middleware('web');

Route::post('/penulis/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/penulis/login');
})->name('filament.penulis.auth.logout')->middleware('web');
