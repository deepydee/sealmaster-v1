@extends('layouts.front')

@section('description')
ТОО «СИЛМАСТЕР» — производитель уплотнений для гидроцилиндров и гидравлического оборудования в Караганде. Компания оснащена уникальным оборудованием DMH (Австрия) для производства манжет и уплотнений методом точения любых размеров с использованием европейских материалов. Также мы поставляем продукцию ведущих производителей РТИ, таких как Kastas, Trelleborg, Hallite на все виды стационарного и мобильного оборудования.
@endsection

@section('keywords')
Продажа готовых манжет уплотнений в Караганде, Производство манжет методом точения в Караганде, манжеты, уплотнения, сальники, гидроцилиндры, маслостанции, пневмоцилиндры, резиновые кольца, гидравлические манжеты, пыльники на строительную дорожную технику
@endsection

@push('scripts')
<script>
    const ready = (callback) => {
        if (document.readyState !== "loading") callback();
        else document.addEventListener("DOMContentLoaded", callback);
    }

    ready(() => {
        const carouselElement = document.getElementById('carousel');
        const carousel = new Carousel(carouselElement, {
        ride: false,
        interval: 10000,
        touch: true,
        pause: 'hover',
        keyboard: true,
        });

        const reviewsUrl = 'https://public-api.reviews.2gis.com/2.0/branches/70000001045235526/reviews?limit=12&is_advertiser=false&fields=reviews.is_verified&without_my_first_review=false&rated=true&sort_by=date_edited&key=37c04fe6-a560-4549-b459-02309cf643ad&locale=ru_KZ';
        getReviews(reviewsUrl);
    });
</script>
@endpush

{{-- @dd($goods) --}}
@section('content')
<main>
    <section class="container-fluid slider mb-3 mb-sm-5">
        @include('front.section-main-carousel')
    </section>

    <section class="container seals-production mb-3 mb-sm-5">
        @include('front.section-production')
    </section>

    <section class="container-fluid mb-3 mb-sm-5 our-benefits py-4 p-sm-4">
        @include('front.section-our-benefits')
    </section>

    <section class="container mb-3 mb-sm-5 repair">
        @include('front.section-repair')
    </section>

    <section class="container spare-parts mb-3 mb-sm-5">
        @include('front.section-spare')
    </section>

    <section class="container-fluid mb-3 mb-sm-5 cta-section py-4 p-sm-4">
        @include('front.section-cta')
    </section>

    <section class="container goods mb-3 mb-sm-5">
        @include('front.section-goods')
    </section>

    <section class="container-fluid about mb-3 mb-sm-5 text-white">
        @include('front.section-about')
    </section>

    <section class="container-fluid mb-3 mb-sm-5 our-benefits-1 py-4 p-sm-4">
        @include('front.section-benefits-for-partnership')
    </section>

    <section class="container mb-3 mb-sm-5">
        @include('front.section-certificates')
    </section>

    <section class="container partners d-none d-md-block mb-3 mb-sm-5">
      <h2 class="display-6 fw-bold mb-4">Заказчики и партнеры</h2>
        @include('front.section-partners')
    </section>

    <section class="container blog mb-4 mb-sm-5">
      <h2 class="display-6 fw-bold mb-4">Блог</h2>
      @include('front.popular-posts')
      <a href="{{ route('blog.index') }}">Все записи</a>
    </section>

    <section class="container faq mb-3 mb-sm-5" itemscope itemtype="https://schema.org/FAQPage">
      <div class="row">
        <div class="col-md-6">
          <h2 class="display-6 fw-bold mb-4">Ваши вопросы</h2>
          @include('front.section-faq')
          <a href="#">Перейти к разделу</a>
        </div>

        <div class="d-none d-md-flex col-md-6">
            @include('front.section-gallery')
        </div>
      </div>
    </section>

    <section class="container testimonials mb-4 mb-sm-5">
        @include('front.section-testimonials')
    </section>
@endsection
