@extends('layouts.front')

@section('title', $blogPost->title)

@if ($blogPost->keywords)
@section('keywords', $blogPost->keywords)
@endif

@section('description', strip_tags($blogPost->description))

@section('content')
<article itemscope itemtype="http://schema.org/Article">
    <header class="mb-5">
        <div class="site-cover site-cover-sm same-height overlay single-page"
            style="background-image: url('{{ $blogPost->getFirstMediaUrl('blog') }}');">
            <div class="container">
                <div class="row same-height justify-content-center">
                    <div class="col-md-12 col-lg-10">
                        <div class="post-entry text-center">
                            <span class="post-category text-white bg-success mb-3">{{ $blogPost->category->title }}</span>
                            <h1 class="mb-4" itemprop="headline"><a href="{{ route('blog.page', $blogPost) }}" class="no-underline">{{ $blogPost->title }}</a></h1>
                            <div class="post-meta align-items-center text-center">
                                <figure class="author-figure mb-0 mr-3 d-inline-block"><img src="{{ isset($blogPost->user) ? $blogPost->user->getFirstMediaURL('avatars', 'thumb_post') : '' }}"
                                        alt="Image" class="img-fluid"></figure>
                                <span class="d-inline-block mt-1">{{ $blogPost->user->name ?? 'Анонимный автор' }}</span>
                                <span itemprop="dateUpdated">&nbsp;-&nbsp; {{ $blogPost->updated_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Блог</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.category', $blogPost->category) }}">{{
                        $blogPost->category->title }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $blogPost->title }}</li>
            </ol>
        </nav>
    </div>

    <div class="container blog-post-text">
        <div class="row g-4 justify-content-around">
            <div class="col-12 col-lg-8 ck-content">
                <p>{!! $blogPost->description !!}</p>
                {!! $blogPost->content !!}
                <div class="tags mb-4 mt-5">
                    @if ($blogPost->tags->count())
                    <h3>Теги:</h3>
                    @foreach ($blogPost->tags as $tag)
                    <a href="{{ route('blog.tag', $tag) }}" class="no-underline"><span class="badge text-bg-light">#{{
                            $tag->title }}</span></a>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="row g-4">
                    <div class="col-12">
                        <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                            <img src="{{ isset($blogPost->user) ? $blogPost->user->getFirstMediaURL('avatars', 'thumb_post') : '' }}" width="216"
                                height="216" class="rounded-circle img-responsive me-2 mb-3 post-image">
                            <h3 class="fw-bold" itemprop="author">{{ isset($blogPost->user) ? $blogPost->user->name : 'Анонимный автор' }}</h3>
                            <span class="text-muted">{{ $blogPost->user->description ?? 'ТОО "СИЛМАСТЕР"' }}</span>
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
