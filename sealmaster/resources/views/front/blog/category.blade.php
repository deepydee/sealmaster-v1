@extends('layouts.front')

@section('title', $category->title)

@section('content')

<section class="container-fluid">
    <header>
        <div class="py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span>Категория</span>
                        <h3 class="mt-3 fw-bold text-capitalize">{{ $category->title }}</h3>
                        <p>Category description here.. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam
                            error eius quo, officiis non maxime quos reiciendis perferendis doloremque maiores!</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <nav class="mt-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Блог</a></li>
                <li class="breadcrumb-item active">{{ $category->title }}</li>
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
    </div>

</section>
@endsection
