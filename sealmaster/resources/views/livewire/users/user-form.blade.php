<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ $editing ? __('Edit user') : __('Create user') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.users.index')">
                {{ __('Users') }}
            </x-breadcrumbs.item>
            <x-breadcrumbs.item>
                {{ $editing ? __('Edit user') : __('Create user') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>


        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model.lazy="user.name" id="name" class="block mt-1 w-full" type="text" />
                            <x-input-error :messages="$errors->get('user.name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:model.lazy="user.email" id="email" class="block mt-1 w-full"
                                type="email" />
                            <x-input-error :messages="$errors->get('user.email')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input wire:model.lazy="user.password" id="password" class="block mt-1 w-full" type="password" name="password"
                                required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('user.password')" class="mt-2" />
                        </div>

                        <div x-cloak class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea wire:model.lazy="user.description" id="description"
                                class="min-h-max block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            <x-input-error :messages="$errors->get('user.description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label class="mb-1" for="tags" :value="__('Roles')" />
                            <x-choices wire:model="roles" class="mt-1" id="tags" name="tags"
                                :options="$this->listsForFields['roles']" multiple />
                            <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                        </div>

                        <div class="mt-6 space-y-6 mb-4">
                            <x-input-label class="mb-1 cursor-pointer" for="thumbnail">
                                <div class="mb-4">{{ __('Photo') }}</div>
                                <img src="
                                    @if($updateThumb)
                                        {{ $thumbnail->temporaryURL() }}
                                    @else
                                        {{ $user->getFirstMediaURL('avatars', 'thumb') }}
                                    @endif" alt="Front of women's basic tee in heather gray."
                                    class="flex-none w-24 h-24 object-center object-cover bg-gray-100 rounded-full">
                            </x-input-label>
                            <x-input-file wire:model="thumbnail" id="thumbnail" name="thumbnail"
                                aria-describedby="file_input_help" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG
                                или GIF (Макс. 800x400px).</p>
                            <x-input-error class="mt-2" :messages="$errors->get('thumbnail')" />
                        </div>

                        <div class="mb-4">
                            <x-primary-button type="submit">
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>
