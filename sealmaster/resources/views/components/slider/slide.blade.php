@props([
    'title',
    'description',
])

<div {{ $attributes->merge(['class' => 'carousel-item overlay']) }}>
    <img srcset="
      storage/storage/img/slides/002-510x207.jpg 510w
      storage/storage/img/slides/002-690x280.jpg 690w
      storage/storage/img/slides/002-1110x547.jpg 1110w
    " src="storage/img/slides/002-1110x547.jpg" class="w-100 d-block" alt="First slide">
    <div class="carousel-caption">
        <div class="row">
            <div class="col col-xxl-10">
                <a href="#" class="no-underline text-white">
                    <h5 class="mb-3 mb-md-4 slide-heading">{{ $title }}</h5>
                </a>
                <p class="d-none d-sm-block mb-4 slide-description">{{ $description }}</p>

                {{-- <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#modalAskPhoneCall">Оформить заявку</button> --}}
            </div>
        </div>
    </div>
</div>
