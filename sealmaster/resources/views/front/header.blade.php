<header class="main-menu-header">
    <!-- place navbar here -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
        <a class="navbar-brand me-0 me-lg-3" href="/">
          <img src="{{ asset('storage/img/logo-main.png') }}" alt="ТОО СИЛМАСТЕР" class="brand-logo">
        </a>
        <a href="tel:+77076026021" class="d-lg-none no-underline">+7 (707) 602-60-21</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav me-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link active" href="{{ route('home') }}" aria-current="page">Главная <span class="visually-hidden">(текущая)</span></a>
            </li>
            {{-- @include('front.dynamic-menu') --}}

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="goods" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Контакты</a>
              <div class="dropdown-menu" aria-labelledby="goods">
                <a class="dropdown-item" href="tel:+77764407004"><span class="icon icon-phone-out" aria-hidden="true"></span> +7 (776) 440 70 04</a>
                <a class="dropdown-item" href="tel:+77076026021"><span class="icon icon-phone-out" aria-hidden="true"></span> +7 (707) 602-60-21</a>
                <a class="dropdown-item" href="https://wa.me/77764407004?text=Здравствуйте%2C+у+меня+есть+вопрос" target="_blank"><span class="icon icon-wa"></span> Написать в WhatsApp</a>
                <a href="#" class="dropdown-item">
                  <!-- Modal trigger button -->
                  <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalAskPhoneCall">
                    <span class="icon icon-phone-in"></span> Обратный звонок
                  </button>
                </a>
              </div>
            </li>
          </ul>
          <a href="tel:+77076026021" class="d-none d-xxl-block me-3 no-underline"><span class="icon icon-phone-out" aria-hidden="true"></span> +7 (707) 602-60-21</a>
          <a href="tel:+77764407004" class="d-none d-xl-block me-3 no-underline"><span class="icon icon-phone-out" aria-hidden="true"></span> +7 (776) 440 70 04</a>
          <div class="social my-4 my-lg-0">
            <a href="http://www.instagram.com/sealmasterkz/" title="ТОО СИЛМАСТЕР в Instagram"><span class="icon icon-inst"></span></a>
            <a href="http://t.me/sealmasterkz" title="ТОО СИЛМАСТЕР в Telegram"><span class="icon icon-tg"></span></a>
            <a href="https://wa.me/77764407004?text=Здравствуйте%2C+у+меня+есть+вопрос" title="Напишите нам в WhatsApp"><span class="icon icon-wa" target="_blank"></span></a>
            <a href="https://www.youtube.com/@user-ng3jr8ss1b" title="Youtube канал ТОО СИЛМАСТЕР" target="_blank"><span class="icon icon-yt"></span></a>
          </div>
          @auth('web')
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-nav-link :href="route('logout')" class="no-underline" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-nav-link>
            </form>
          @endauth

          @guest
            <a class="no-underline" href="{{ route('login') }}">Войти</a>
          @endguest
        </div>
      </div>
    </nav>
  </header>
