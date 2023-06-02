<div class="row g-4">

    <div class="col-12 mb-4">
        <div class="sidebar-box">
            <h3 class="heading fw-bold">Категории</h3>
            @if ($categories->count())
            <ul class="categories">
                @foreach ($categories as $category)
                <li><a href="{{ route('blog.category', $category) }}" class="no-underline">{{ $category->title }} <span>({{ $category->posts_count }})</span></a></li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <div class="col-12 mb-4">
        <div class="sidebar-box">
            <h3 class="heading fw-bold">Теги</h3>
            @if ($tags->count())
            <ul class="tagcloud">
                @foreach ($tags as $tag)
                <a href="{{ route('blog.tag', $tag) }}" class="no-underline">{{ $tag->title }}</a>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    <div class="col-12 mb-4">
        <form action="{{ route('blog.search') }}" method="GET">
            <div class="input-group mb-3">
                <input type="search" class="form-control @error('q') is-invalid @enderror" placeholder="Поиск..." aria-label="Поиск по блогу" aria-describedby="buttonSearch" id="site-search" name="q" required>
                <button class="btn btn-outline-secondary" type="submit" id="buttonSearch">Искать</button>
              </div>
        </form>
    </div>
</div>
