<div class="row">
@if ($repair[0])
    <div class="col-lg-9">
    <h2 class="display-6 fw-bold mb-4">Ремонт</h2>
    <p class="mb-4">{{ $repair[0]->description }}</p>
    </div>
</div>
<div class="row g-2 g-sm-4">

@foreach ($repair[0]->children as $item)
<div class="col-sm-6 col-lg-3">
    <div class="good-card rounded">
    <img src="{{ $item->getFirstMediaUrl('images', 'thumb') }}" alt="{{ $item->title }}">
    <div class="overlay overlay-1">
        <a href="{{ $item->path }}"><h3>{{ $item->title }}</h3></a>
    </div>
    </div>
</div>
@endforeach

<a href="{{ $repair[0]->path }}">Перейти к разделу</a>
@endif
</div>
