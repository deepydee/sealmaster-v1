@extends('layouts.front')

@section('title', $blogPost->title)

@if ($blogPost->keywords)
    @section('keywords', $blogPost->keywords)
@endif

@section('description', strip_tags($blogPost->description))

@section('content')
<article itemscope itemtype="http://schema.org/Article">
    <header class="mb-5">
      <div class="container-fluid blog-post-header-image p-0 mb-4">
        @if ($blogPost->getFirstMedia('blog'))
        {{ $blogPost->getFirstMedia('blog')->img()->attributes([
            'alt' => $blogPost->title,
            'class' => 'img-fluid',
            'itemprop' => 'image',
        ]) }}
        @endif
      </div>
      <div class="container">
        <h1 class="display-5 fw-bold mb-5" itemprop="headline">{{ $blogPost->title }}</h1>
        <div class="mb-3"><span class="article-published fw-bold">Опубликовано </span><time datetime="{{ $blogPost->created_at }}" class="form-text text-muted" itemprop="datePublished" content="{{ $blogPost->created_at }}">{{ $blogPost->created_at }}</time><div><span class="article-updated fw-bold">Обновлено </span><time datetime="{{ $blogPost->updated_at }}" class="form-text text-muted" itemprop="dateModified" content="{{ $blogPost->updated_at }}">{{ $blogPost->updated_at }}</time></div> <div class="article-views text-muted">{{ $blogPost->views }}</div></div>
      </div>
    </header>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Блог</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.category', $blogPost->category) }}">{{ $blogPost->category->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $blogPost->title }}</li>
            </ol>
        </nav>
    </div>

    <div class="container blog-post-text">
      <div class="row g-4 justify-content-around">
        <div class="col-12 col-lg-8 ck-content">
            <p>{!! $blogPost->description !!}</p>
            {!! $blogPost->content !!}
          <div class="tags mb-4">
            @if ($blogPost->tags->count())
                @foreach ($blogPost->tags as $tag)
                    <a href="{{ route('blog.tag', $tag) }}" class="no-underline"><span class="badge text-bg-light">{{ $tag->title }}</span></a>
                @endforeach
            @endif
          </div>
        </div>
        <div class="col-lg-3 text-center">
          <div class="row g-4">
            <div class="col-12">
              <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                  <img src="{{ $blogPost->user->getFirstMediaURL('avatars', 'thumb_post') }}" width="216"  height="216" class="rounded-circle img-responsive me-2 mb-3 post-image">
                  <h3 class="fw-bold" itemprop="author">{{ $blogPost->user->name }}</h3>
                  <span class="text-muted">Кандидат технических наук, член наблюдательного совета ООН</span>
              </span>
            </div>
            <aside class="col-12 text-start mb-4 categories-list">
                @include('front.sidebar')
            </aside>
          </div>
        </div>
      </div>
    </div>
  </article>
@endsection

@section('aside')
  <h3 class="mb-4 fw-bold">Читайте также</h3>
  @include('front.popular-posts')
@endsection
