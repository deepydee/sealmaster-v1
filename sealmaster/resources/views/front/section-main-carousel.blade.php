{{-- @if ($slides->count()) --}}
<x-slider target="carousel">
    <x-slot:header>
        @foreach ($slides as $slide)
        <li
            data-bs-target="#carousel"
            data-bs-slide-to="{{ $loop->index }}"
            class="{{ $loop->index === 0 ? 'active' : '' }}"
            aria-label="{{ $slide->title }}"
        >
        </li>
        @endforeach
    </x-slot>
        @foreach ($slides as $slide)
            <x-slider.slide
                title="{{ $slide->title }}"
                description="{{ $slide->description }}"
                srcset="{{ $slide->getFirstMedia('slides')->getSrcSet() }}"
                imgSrc="{{ $slide->getFirstMediaUrl('slides') }}"
                link="{{ $slide->link }}"
                class="{{ $loop->first ? 'active' : '' }}"
            />
        @endforeach
    </x-slider>
{{-- @endif --}}
