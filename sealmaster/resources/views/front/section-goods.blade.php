<div class="row">
@if ($goods[0])
    <div class="col-lg-9">
      <h2 class="display-6 fw-bold mb-4">Товары</h2>
      <p>{{ $goods[0]->description }}</p>
    </div>
</div>
<div class="row gy-2 gy-sm-4">


    @foreach($goods[0]->children as $good)
    <div class="col-sm-6 col-lg-3">
        <div class="good-card rounded">
            <img src="{{ $good->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $good->title }}">
            <div class="overlay overlay-1">
            <a href="{{ $good->path }}"><h3>{{ $good->title }}</h3></a>
            </div>
        </div>
        </div>
    @endforeach
<a href="{{ $goods[0]->path }}">Перейти к разделу</a>
@endif
</div>
