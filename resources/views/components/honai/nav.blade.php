<nav class="honai-nav">
    <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Semua</a>
    @foreach($categories ?? \App\Models\Category::orderBy('name')->get() as $category)
        <a href="{{ route('category.show', $category->slug) }}"
           class="nav-item {{ request()->routeIs('category.show') && request()->route('category')?->slug === $category->slug ? 'active' : '' }}">
            {{ $category->name }}
        </a>
    @endforeach
</nav>
