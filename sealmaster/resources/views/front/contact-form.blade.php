<form action="{{ route('contact-form.process') }}" method="POST">
    @csrf

    @include('admin.layouts.chunks.alerts')
    <div class="mb-3">
      <label for="setUserContactPhone" class="form-label">Телефон</label>
      <input type="tel"
        class="form-control @error('phone') is-invalid @enderror" name="phone" id="setUserContactPhone" aria-describedby="setUserContactPhoneHelpId" placeholder="+7 (___)___-__-__">
      <small id="setUserContactPhoneHelpId" class="form-text text-muted d-none"></small>
    </div>
    <div class="mb-3">
      <label for="setUserContactName" class="form-label">Имя</label>
      <input type="text"
        class="form-control @error('text') is-invalid @enderror" name="name" id="setUserContactName" aria-describedby="setUserContactNameHelpId" placeholder="Ринат">
      <small id="setUserContactNameHelpId" class="form-text text-muted d-none"></small>
    </div>
    <div>
      <label for="setUserContactText" class="form-label">Сообщение*</label>
      <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="setUserContactText" rows="3" required></textarea>
    </div>
    <div class="mb-3">
      <small id="setUserContactNameHelpId" class="form-text text-muted">Поля, отмеченные звездочкой (*) обязательны</small>
    </div>
    <button type="submit" class="btn btn-outline-primary px-5">Отправить</button>
</form>
