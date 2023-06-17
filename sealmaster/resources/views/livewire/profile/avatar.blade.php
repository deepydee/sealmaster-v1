<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Change Avatar') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Change your profile photo") }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <div class="mt-1 sm:mt-0 sm:col-span-2">
            <div class="flex items-center">
                @if ($isEditing)
                    <img src="{{ $avatar->temporaryURL() }}" class="h-12 w-12 rounded-full overflow-hidden bg-gray-100" alt="Avatar">
                @else
                    <img src="{{ auth()->user()->getFirstMediaURL('avatars', 'thumb') }}" class="h-12 w-12 rounded-full overflow-hidden bg-gray-100" alt="Avatar">
                @endif
            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-input-label for="avatar" :value="__('Photo')" />
            <x-input-file wire:model="avatar" id="avatar" name="avatar" aria-describedby="file_input_help" />
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button wire:click.prevent="save">{{ __('Save') }}</x-primary-button>

        @if ($saved)
        <p
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600"
        >{{ __('Saved.') }}
        </p>
        @endif
    </div>
</section>
