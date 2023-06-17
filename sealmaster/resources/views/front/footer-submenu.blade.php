@if($subcategories)
    @foreach($subcategories as $category)
        @if (@blank($category->children))
        <li><a href="{{ route('category.show', $category->path) }}">{{ $category->title }}</a></li>
        @else
        <h4><a href="{{ route('category.show', $category->path) }}">{{ $category->title }}</a></h4>
        <ul class="footer-links">
            @include('front.footer-submenu', ['subcategories' => $category->children])
        </ul>
        @endif
    @endforeach
@endif
