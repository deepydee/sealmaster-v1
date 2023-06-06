@props([
    'options',
])

<ol {{ $arrtibutes->merge(['class' => 'carousel-indicators d-none d-md-flex']) }}>
    @foreach ($option as $item)
    <li data-bs-target="#carousel" data-bs-slide-to="{{ $loop->index }}" {{ $loop->index === 0 ? 'class="active" aria-current="true"' : '' }}  aria-label="{{ $item }}">
    </li>
    @endforeach
</ol>
