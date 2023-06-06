<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ $editing ? __('Edit slide') : __('Create slide') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.slides.index')">
                {{ __('Slides') }}
            </x-breadcrumbs.item>
            <x-breadcrumbs.item>
                {{ $editing ? __('Edit slide') : __('Create slide') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>


        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input wire:model.lazy="slide.title" id="title" class="block mt-1 w-full"
                                type="text" />
                            <x-input-error :messages="$errors->get('slide.title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="link" :value="__('Link')" />
                            <x-text-input wire:model.lazy="slide.link" id="link" class="block mt-1 w-full"
                                type="text" />
                            <x-input-error :messages="$errors->get('slide.link')" class="mt-2" />
                        </div>

                        <div x-cloak class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <textarea wire:model.lazy="slide.description" id="description"
                                class="min-h-max block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>

                            <x-input-error :messages="$errors->get('slide.description')" class="mt-2" />
                        </div>

                        <div x-cloak class="mb-4">
                            <x-input-label for="content" :value="__('Content')" class="mb-1" />
                            <div wire:ignore>
                                <x-ck-editor wire:model.lazy="slide.content" id="content" data-content="@this"
                                    field="slide.content" />
                            </div>

                            <x-input-error :messages="$errors->get('pslide.content')" class="mt-2" />
                        </div>

                        <div class="mt-6 space-y-6 mb-4">
                            <x-input-label class="mb-1 cursor-pointer" for="thumbnail">
                                <div class="mb-4">{{ __('Thumbnail') }}</div>
                                <img src="
                                    @if($updateThumb)
                                        {{ $thumbnail->temporaryURL() }}
                                    @else
                                        {{ $slide->getFirstMediaURL('slides', 'thumb') }}
                                    @endif" alt="Front of women's basic tee in heather gray."
                                    class="flex-none w-24 h-24 object-center object-cover bg-gray-100 rounded-md">
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
