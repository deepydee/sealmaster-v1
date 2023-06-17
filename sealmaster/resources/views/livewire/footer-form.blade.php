<form wire:submit.prevent="submit" id="footerCbForm" name="cbForm">
    @if (session()->has('message'))
    <div x-data="{ show: true }" x-show="show" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        x-init="setTimeout(() => show = false, 2000)" x-cloak class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
    @endif
    <div class="mb-3">
        <label for="setUserContactPhone" class="form-label">Телефон</label>
        <input wire:model='callback.phone' type="tel" class="form-control @error('callback.phone') is-invalid @enderror"
            name="phone" id="setUserContactPhone" name="phone" aria-describedby="setUserContactPhoneHelpId" autocomplete="phone"
            placeholder="+7 (___)___-__-__">
        @error('callback.phone')
        <small id="setUserContactPhoneHelpId" class="form-text invalid-feedback">{{ $message }}</small>
        @enderror
    </div>
    <div class="mb-3">
        <label for="setUserContactName" class="form-label">Имя</label>
        <input wire:model='callback.name' type="text" class="form-control @error('callback.name') is-invalid @enderror"
            @error('callback.name') name="name" id="setUserContactName" aria-describedby="setUserContactNameHelpId"
            placeholder="Ринат" autocomplete="given-name">
        <small id="setUserContactNameHelpId" class="form-text invalid-feedback">{{ $message }}</small>
        @enderror
    </div>
    <div>
        <label for="setUserContactText" class="form-label">Сообщение*</label>
        <textarea wire:model='callback.message' class="form-control @error('callback.message') is-invalid @enderror"
            name="message" id="setUserContactText" rows="3" required></textarea>
        @error('callback.message')
        <small id="setUserContactNameHelpId" class="form-text invalid-feedback">{{ $message }}</small>
        @enderror
    </div>
    <div class="mb-3">
        <small id="setUserContactNameHelpId" class="form-text text-muted">Поля, отмеченные звездочкой (*)
            обязательны</small>
    </div>
    <button type="submit" class="btn btn-outline-primary px-5">Отправить</button>
</form>
