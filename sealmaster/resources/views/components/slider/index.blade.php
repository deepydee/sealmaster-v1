@props(['target'])

<div id="carousel" class="carousel slide" data-bs-ride="true">
    <ol class="carousel-indicators d-none d-md-flex">
        {{ $header }}
    </ol>
    <div class="carousel-inner" role="listbox">
        {{ $slot }}
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#{{ $target }}" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#{{ $target }}" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
