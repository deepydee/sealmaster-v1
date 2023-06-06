@props([
    'title',
    'description',
    'srcset' => '',
    'imgSrc' => '',
    'content' => '',
])

<div {{ $attributes->merge(['class' => 'carousel-item overlay']) }}>
    <img srcset="{{ $srcset }}" src="{{ $imgSrc }}" class="w-100 d-block" alt="{{ $title }}">
    <div class="carousel-caption">
        <div class="row">
            <div class="col col-xxl-10">
                <a href="#" class="no-underline text-white">
                    <h5 class="mb-3 mb-md-4 slide-heading">{{ $title }}</h5>
                </a>
                <p class="d-none d-sm-block mb-4 slide-description">{{ $description }}</p>

                {!! $content !!}
            </div>
        </div>
    </div>
</div>
