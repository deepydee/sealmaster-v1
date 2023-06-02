@extends('layouts.front')

@section('title', 'Результаты поиска по блогу')

@section('content')
    <section class="container">
      <header mt-5>
        <h1 class="display-5 fw-bold mb-5">Результаты поиска по запросу "{{ $q }}"</h1>
      </header>

    <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Блог</a></li>
        <li class="breadcrumb-item active" aria-current="page">Поиск по блогу</li>
    </ol>
    </nav>

      <div class="row mb-5">
        <div class="col-md-9 mb-5">
          <div class="row g-4">
            @if ($posts->count())
                @foreach ($posts as $post)
                <div class="col-md-6">
                    @include('front.post-card', ['post' => $post])
                </div>
                @endforeach
            @else
                <div class="row mt-4">По вашему запросу ничего не найдено...</div>
            @endif
          </div>
        </div>

        <aside class="col-md-3 text-start mb-4 categories-list">
            @include('front.sidebar')
        </aside>

        {{ $posts->appends(['q' => request()->q])->links('vendor.pagination.bootstrap-5') }}
      </div>
    </section>
@endsection
