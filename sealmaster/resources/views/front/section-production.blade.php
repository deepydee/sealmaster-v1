<div class="row gy-5 mb-3 mb-md-5">
    <div class="col-12 col-lg-9">
      <h2 class="display-6 fw-bold mb-4">Производство манжет</h2>
      <p>Собственные производственные мощности, широкий выбор материалов и гибкость в перенастройке оборудования дают возможность производить уплотнения любой сложности.</p>
      <p>В процессе изготовления уплотнительных элементов применяется большой ассортимент материалов, например, таких как полиуретан (PU), маслобензостойкая резина (NBR), тефлон (PTFE), фторный каучук (FPM), синтетические эластомеры и иные материалы.</p>
      <div class="row row-cols-md-2 gy-md-5 mt-4">
        <div class="col-md-6 feature-card">
          <h3 class="fw-bold">Универсальность</h3>
          <p>Выпускаем РТИ для различных видов спецтехники – сельскохозяйственной, коммунальной, дорожно-строительной, погрузочной, промышленного оборудования и др</p>
        </div>
        <div class="col-md-6 feature-card">
          <h3 class="fw-bold">Европейские материалы</h3>
          <p>Высококачественные  полуфабрикаты для производства уплотнений из Австрии – тубы из полиуретана HPU, CHPU, резины NBR, HNBR, FPM, EPDM, PTFE, POM и др</p>
        </div>
        <div class="col-md-6 feature-card">
          <h3 class="fw-bold">Скорость изготовления</h3>
          <p>Выточим манжету за 30 минут по Вашему образцу или чертежу</p>
        </div>
        <div class="col-md-6 feature-card">
          <h3 class="fw-bold">Индивидуально</h3>
          <p>Минимальный объем заказа - 1 шт.</p>
        </div>
        <div class="col-md-6 feature-card">
          <h3 class="fw-bold">Высокая точность</h3>
          <p>Точность обработки поверхностей выточенных манжет до 0,01 мм</p>
        </div>
        <div class="col-md-6 feature-card">
          <h3 class="fw-bold">Доставка</h3>
          <p>Удобная доставка транспортной компанией по Караганде и Казахстану</p>
        </div>
      </div>
    </div>
  </div>
  <div class="row row-cols-md-4 g-2 g-sm-4">

    @if ($dmh[0])

    @foreach ($dmh[0]->children as $item)
    <div class="col-6 col-md-3">
        <a href="{{ $item->path }}" class="card-production">
          <div class="card">
            <img class="card-img-top" src="{{ $item->getFirstMediaUrl('categories', 'thumb') }}" alt="{{ $item->title }}">
            <div class="card-body">
              <h4 class="card-title text-center">{{ $item->title }}</h4>
            </div>
          </div>
        </a>
      </div>
    @endforeach

    @endif

    <a href="{{ $dmh[0]->path }}">Перейти к разделу</a>
  </div>
