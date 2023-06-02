@extends('layouts.front')

@section('title', $tag->title)

@section('content')

<section class="container">
    <header>
      <h1 class="display-5 fw-bold mb-5">{{ $tag->title }}</h1>
    </header>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Блог</a></li>
            <li class="breadcrumb-item active">{{ $tag->title }}</li>
        </ol>
    </nav>

    <p class="mb-5"></p>
    <div class="row mb-5">
      <div class="col-md-9 mb-5">
        <div class="row g-4">

            @foreach ($posts as $post)
            <div class="col-sm-6 col-lg-4">
                @include('front.post-card', ['post' => $post])
            </div>
            @endforeach

        </div>
      </div>

      <aside class="col-md-3 text-start mb-4 categories-list">
        @include('front.sidebar')
      </aside>

      {{ $posts->links('vendor.pagination.bootstrap-5') }}
    </div>
  </section>
@endsection
