@extends('layouts.front')

@section('title', $category->title)

@section('content')

<section class="container">
    <header>
      <h1 class="display-5 fw-bold mb-5">{{ $category->title }}</h1>
    </header>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Блог</a></li>
            <li class="breadcrumb-item active">{{ $category->title }}</li>
        </ol>
    </nav>

    <p class="mb-5">Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Имеет он ведущими путь продолжил, собрал жизни домах приставка над проектах возвращайся своего текстов даже! Послушавшись даже злых заманивший. Вопроса.</p>
    <div class="row mb-5">
      <div class="col-md-9 mb-5">
        <div class="row g-4">

            @foreach ($posts as $post)
            <div class="col-md-6">
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
