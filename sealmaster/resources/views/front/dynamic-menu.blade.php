@if (count($categories))
    @foreach ($categories as $category)

    @if (@blank($category->parent))

        @if (@blank($category->children))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('category.show', $category->path) }}">{{ $category->title }}</a>
        </li>
        @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ route('category.show', $category->path) }}" id="{{ $category->slug }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $category->title }}</a>
            <ul class="dropdown-menu" aria-labelledby="{{ $category->slug }}">
                @include('front.layouts.chunks.submenu', ['subcategories' => $category->children])
            </ul>
        </li>
        @endif

    @endif

    @endforeach
@endif
