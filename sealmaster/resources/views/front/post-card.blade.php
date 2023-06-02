<article class="card blog-card" itemscope itemtype="http://schema.org/Article">
    <a href="{{ route('blog.page', $post) }}"><img class="card-img-top" src="{{ $post->getFirstMediaUrl('blog', 'thumb')  }}" alt="{{ $post->title }}" itemprop="image"></a>
    <div class="card-body">
      <header>
        <h5 class="text-uppercase fs-6 fw-bold mb-4"><a href="{{ route('blog.category', $post->category->slug) }}">{{ $post->category->title }}</a></h5>
      </header>
      <h4 class="card-title fw-bold mb-3"><a href="{{ route('blog.page', $post) }}" class="blog-post" itemprop="headline">{{ $post->title }}</a></h4>
      <p class="card-description">{!! \Illuminate\Support\Str::limit($post->description, 100, $end='...') !!}</p>
    </div>
    <footer class="card-footer">
      <span  itemprop="author" itemscope itemtype="https://schema.org/Person"><img class="author" src="{{ $post->user->getFirstMediaURL('avatars', 'thumb') }}" class="rounded-circle img-responsive img-fluid me-2">
      <span class="card-text">{{ $post->user->name }}</span></span>
      <div class="mt-1"><time datetime="{{ $post->created_at }}" class="form-text text-muted" itemprop="datePublished" content="{{ $post->created_at }}">{{ $post->created_at }}</time> <small>(обновлено <time datetime="{{ $post->updated_at }}" class="form-text text-muted" itemprop="dateModified" content="{{ $post->updated_at }}">{{ $post->updated_at }}</time>)</small></div>
    </footer>
  </article>
