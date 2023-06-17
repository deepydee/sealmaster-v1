@extends('layouts.front')

@section('title', $category->title)

@if ($category->keywords)
    @section('keywords', $category->keywords)
@endif

@if ($category->description)
    @section('description', strip_tags($category->description))
@endif

@section('content')

@if ($category)
<section class="container mt-5">
    @include('front.breadcrumbs', ['category' => $category])
    <div class="row mb-4">
        <header>
            <h1 class="display-5 fw-bold">{{ $category->title }}</h1>
        </header>
    </div>

{{-- @if ($category->children)
<div class="row g-2 g-sm-4 mb-4">
   @foreach ($category->children as $subcategory)
   <div class="col-sm-6 col-lg-3">
        <div class="good-card rounded">
            <img src="{{ $subcategory->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $subcategory->title }}">
            <div class="overlay overlay-1">
                <a href="{{ route('category.show', ['path' => $subcategory->path]) }}"><h3>{{ $subcategory->title }}</h3></a>
            </div>
        </div>
    </div>
   @endforeach
</div>
@endif --}}

@if ($category->children)
<div class="row row-cols-lg-4 g-2 g-sm-4 mb-4">
    @foreach ($category->children as $subcategory)
    <div class="col col-md-3">
      <a href="{{ route('category.show', ['path' => $subcategory->path]) }}" class="card-production">
        <div class="card">
          <img class="card-img-top" src="{{ $subcategory->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $subcategory->title }}">
          <div class="card-body">
            <h4 class="card-title text-center">{{ $subcategory->title }}</h4>
          </div>
        </div>
      </a>
    </div>
    @endforeach
</div>
@endif

<div class="row g-2 g-sm-4 mb-4">
    @foreach($products as $product)
    <div class="col-sm-6 col-lg-3">
        <div class="good-card rounded">
        <img src="{{ $product->getFirstMediaUrl('products', 'thumb') }}" alt="{{ $product->title }}">
        <div class="overlay overlay-1">
            <a href="{{ route('products.show', ['category_path' => $category->path, 'product' => $product]) }}"><h3>{{ $product->title }}</h3></a>
        </div>
        </div>
    </div>
    @endforeach
    {{ $products->links('vendor.pagination.bootstrap-5') }}
</div>
@endif

<div class="row mb-4">
    @if ($category->content)
    <div class="col-12 ck-content">
        {!! $category->content !!}
    </div>
    @endif
</div>

@endsection
