<div class="container-fluid breadcrumb-container">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach($category->ancestors as $ancestor)
              <li class="breadcrumb-item"><a href="{{ route('category.show', $ancestor->path) }}">{{ $ancestor->title }}</a></li>
            @endforeach
              <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
        </ol>
      </nav>
    </div>
</div>
