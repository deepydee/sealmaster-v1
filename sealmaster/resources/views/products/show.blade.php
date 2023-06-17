@extends('layouts.front')

@section('title', $product->title)

@if ($product->keywords)
    @section('keywords', $product->keywords)
@endif

@if ($product->description)
    @section('description', strip_tags($product->description))
@endif

@section('content')

<section class="container mt-5">
    @include('front.breadcrumbs', ['category' => $category])
    <div class="row mb-4">
        <header>
            <h1 class="display-5 fw-bold">{{ $product->title }}</h1>
        </header>
    </div>
    <div class="row mb-4 g-4">
        <div class="col-12 col-md-2">
            <figure class="figure text-center">
                <img src="{{ $product->getFirstMediaUrl('products', 'thumb') }}" alt="{{ $product->title }}" class="img-fluid">
                <figcaption class="figure-caption text-center">{{ $product->title }}</figcaption>
            </figure>
        </div>
        <div class="col-12 col-md-10">
            {{-- <h3>Преимущества продукта</h3>
            <p>{!! $product->attributes[0]->pivot->value !!}</p>

            <h3>Область применения</h3>
            <p>{!! $product->attributes[1]->pivot->value !!}</p> --}}

            <h3>Характеристики:</h3>
            <ul>
                @foreach ($product->attributes as $attribute)
                <li>{{$attribute->title}} ({{ $attribute->type }}): {!! $attribute->pivot->value !!}</li>
                @endforeach
            </ul>
            {{-- <ul>
                @for ($i = 2; $i < 6; $i++)
                <li>{{ $product->attributes[$i]->title }}: {{ $product->attributes[$i]->pivot->value }}</li>
                @endfor
            </ul>
            @if ($product->attributes[6])
            <figure class="figure text-center">
                <img src="{{ asset('storage/uploads/images/'. $product->attributes[6]->pivot->value) }}" alt="{{ $product->title }}" class="img-fluid">
                <figcaption class="figure-caption text-center">Техническией рисунок</figcaption>
            </figure>
            @endif --}}
        </div>
    </div>
</section>

{{-- <div class="product-card">
    <h1>{{ $product->title }}</h1>

    <h2>Характеристики:</h2>
    <img src="{{ $product->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $product->title }}">
    <table class="table-responsive-sm table-bordered table-hover">
        <caption>Характеристики для {{ $product->title }}</caption>
        <thead class="thead-dark">
            <tr>
            @foreach($product->attributes as $attribute)
                @if ($attribute->pivot->value)
                <th scope="col">{{ $attribute->title }}</th>
                @endif
            @endforeach
            </tr>
        </thead>
        <tbody>
            <tr scope="row">
            @foreach($product->attributes as $attribute)
            @if ($attribute->pivot->value && $attribute->type === App\Enums\AttributeType::Text)
                <td>{!! $attribute->pivot->value !!}</td>
            @endif
            @if ($attribute->pivot->value && $attribute->type === App\Enums\AttributeType::Image)
            <td><img src="{{ asset('storage/uploads/images/'. $attribute->pivot->value) }}"></td>
            @endif
            @endforeach
            </tr>
        </tbody>
    </table>
</div> --}}

@endsection
