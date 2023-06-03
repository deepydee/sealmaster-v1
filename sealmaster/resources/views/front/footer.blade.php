<a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" title="Наверх" role="button"><span class="icon icon-chevron-up"></span></a>

<footer class="footer mt-auto bg-light">
    <div class="container-fluid contacts-footer p-0">
      <div class="container py-4">
        <div class="row">
          <div class="col-12 col-lg-4 offset-xl-8">
            <div class="card footer-contacts-card" itemscope itemtype="http://schema.org/Organization">
              <div class="card-header">
                <h4 class="card-title fw-bold" itemprop="name">ТОО "СИЛМАСТЕР"</h4>
                <p class="card-text">Производство и реализация манжет и уплотнений</p>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"> <a href="https://maps.google.com?saddr=Current+Location&daddr=49.798523398295465, 73.15658940003331" target="_blank" class="no-underline"><span class="icon icon-location me-2" aria-hidden="true"></span><span itemprop="address">Казахстан, г. Караганда, ул Таттимбета 10/7</span></a></li>
                <li class="list-group-item"><a href="tel:+77764407004" class="no-underline fw-bold"><span class="icon icon-phone-out me-2" aria-hidden="true"></span><span itemprop="telephone">+7 (776) 440-70-04</span></a></li>
                <li class="list-group-item"><a href="tel:+77076026021" class="no-underline fw-bold"><span class="icon icon-phone-out me-2" aria-hidden="true"></span><span itemprop="telephone">+7 (707) 602-60-21</span></a></li>
                <li class="list-group-item"><a href="mailto:sealmasterkz@gmail.com" class="no-underline"><span class="icon icon-mail me-2" aria-hidden="true"></span><span itemprop="email">sealmasterkz@gmail.com</span></a></li>
                <li class="list-group-item">
                  <a id="whToggle" class="no-underline" data-bs-toggle="collapse" href="#workHours" aria-expanded="false" aria-controls="workHours"><span class="icon icon-clock me-2" aria-hidden="true"></span></a>
                <div class="collapse text-center" id="workHours">
                  <ul id="schedule-list" class="work-hours-list">
                  </ul>
                </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row contacts-footer-map">
        <div class="col">
          <iframe style="border:0; width: 100%; height: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2575.3203116374093!2d73.1538494775773!3d49.79884550106056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4243470a545803b1%3A0x992893e425427b5!2z0KLQntCeICLQodCY0JvQnNCQ0KHQotCV0KAi!5e0!3m2!1sru!2skz!4v1668583615644!5m2!1sru!2skz" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
   <!-- place footer here -->
    <div class="container p-3">
        <div class="row mb-4">

          <div class="col-md-4 mb-4">
            <h3 class="fw-bold">Нужна консультация? Напишите нам, и мы подскажем!</h3>
            {{-- @include('front.contact-form') --}}
          </div>

          <div class="col-md-8">
            @if (count($categories))
                @foreach ($categories as $category)
                    @if (@blank($category->parent))
                        @if ($category->parent)
                            <h3 class="fw-bold"><a href="{{ route('category.show', $category->path) }}">{{ $category->title }}</a></h3>
                        @else
                            <h4><a href="{{ route('category.show', $category->path) }}">{{ $category->title }}</a></h4>
                            <ul class="footer-links">
                                @include('front.footer-submenu', ['subcategories' => $category->children])
                            </ul>
                        @endif
                    @endif
                @endforeach
            @endif

            <p class="fw-bold">Следите за нами в социальных сетях</p>
            <div class="social my-4 my-lg-0">
                <a href="http://www.instagram.com/sealmasterkz/" title="ТОО СИЛМАСТЕР в Instagram"><span class="icon icon-inst"></span></a>
                <a href="http://t.me/sealmasterkz" title="ТОО СИЛМАСТЕР в Telegram"><span class="icon icon-tg"></span></a>
                <a href="https://wa.me/77764407004?text=Здравствуйте%2C+у+меня+есть+вопрос" title="Напишите нам в WhatsApp"><span class="icon icon-wa" target="_blank"></span></a>
                <a href="https://www.youtube.com/@user-ng3jr8ss1b" title="Youtube канал ТОО СИЛМАСТЕР" target="_blank"><span class="icon icon-yt"></span></a>
            </div>

          </div>
        </div>

      <div class="row">
        <span class="text-muted">{{ date('Y') }} &copy; ТОО "СИЛМАСТЕР" | Изготовление и реализация манжет и уплотнений в Караганде</span>
      </div>
    </div>

        <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="modalAskPhoneCall" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalAskPhoneCallTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalAskPhoneCallTitleId">Перезвоните мне</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="#">
                <p>Оставьте контактные данные и наш менеджер перезвонит и ответит на все интересующие Вас вопросы</p>
                <div class="form-floating mb-3">
                  <input
                    type="text"
                    class="form-control" name="userName" id="userName" placeholder="Имя (необязательно)">
                  <label for="userName">Имя (необязательно)</label>
                </div>
                <div class="form-floating mb-3">
                  <input
                    type="tel"
                    class="form-control" name="userPhone" id="userPhone" placeholder="+7(747)123-45-67" required>
                  <label for="userPhone">Телефон</label>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Заказать звонок</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
  </footer>
