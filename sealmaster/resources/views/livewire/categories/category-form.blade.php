<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ $editing ? __('Edit category') : __('Create category') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.categories.index')">
                {{ __('Categories') }}
            </x-breadcrumbs.item>
            <x-breadcrumbs.item>
                {{ $editing ? __('Edit category') : __('Create category') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
    </x-slot>


        <div class="mx-auto max-w-7xl sm:px-2 lg:px-2">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div class="mb-4">
                            <x-input-label class="mb-1" for="parent_id" :value="__('Category')" />
                            <x-select wire:model="category.parent_id" id="parent_id" name="parent category"
                            :title="__('Choose parent category')" :options="$this->listsForFields['categories']" />
                            <x-input-error :messages="$errors->get('category.parent_id')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input wire:model.lazy="category.title" id="title" class="block mt-1 w-full"
                                type="text" />
                            <x-input-error :messages="$errors->get('category.title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label class="mb-1" for="keywords" :value="__('Keywords')" />
                            <x-text-input wire:model.lazy="category.keywords" id="keywords" class="block mt-1 w-full"
                                type="text" />
                            <x-input-error :messages="$errors->get('category.keywords')" class="mt-2" />
                        </div>

                        <div x-cloak class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />

                            <textarea wire:model.lazy="category.description" id="description"
                                class="min-h-max block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>

                            <x-input-error :messages="$errors->get('category.description')" class="mt-2" />
                        </div>

                        <div x-cloak class="mb-4">
                            <x-input-label for="content" :value="__('Content')" class="mb-2" />
                            <div wire:ignore>
                                <x-ck-editor wire:model.lazy="category.content" data-content="@this" id="content"
                                    field="category.content" />
                            </div>
                            <x-input-error :messages="$errors->get('category.content')" class="mt-2" />
                        </div>

                        <div class="mt-6 space-y-6 mb-4">
                            <x-input-label class="mb-1 cursor-pointer" for="thumbnail">
                                <div class="mb-4">{{ __('Thumbnail') }}</div>
                                <img src="
                                    @if($updateThumb)
                                        {{ $thumbnail->temporaryURL() }}
                                    @else
                                        {{ $category->getFirstMediaURL('categories', 'thumb') }}
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
