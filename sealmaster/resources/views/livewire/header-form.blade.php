<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalAskPhoneCallTitleId">Перезвоните мне</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-transition:enter="ease-in-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" x-cloak
                class="alert alert-success" role="alert">
                {{ session('message') }}
            </div>
            @else
            <form wire:click.prevent='submit' id="headerCallbackForm">
                <p>Оставьте контактные данные и наш менеджер перезвонит и ответит на все интересующие Вас
                    вопросы
                </p>
                <div class="mb-3">
                    <label for="setUserContactName" class="form-label">Имя</label>
                    <input wire:model='callback.name' type="text"
                        class="form-control @error('callback.name') is-invalid @enderror" @error('callback.name')
                        name="name" id="setUserContactName" aria-describedby="setUserContactNameHelpId"
                        placeholder="Ринат" autocomplete="given-name">
                    <small id="setUserContactNameHelpId" class="form-text invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="setUserContactPhone" class="form-label">Телефон</label>
                    <input wire:model='callback.phone' type="tel"
                        class="form-control @error('callback.phone') is-invalid @enderror" name="phone"
                        id="setUserContactPhone" name="phone" aria-describedby="setUserContactPhoneHelpId"
                        autocomplete="phone" placeholder="+7 (___)___-__-__">
                    @error('callback.phone')
                    <small id="setUserContactPhoneHelpId" class="form-text invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Заказать звонок</button>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
