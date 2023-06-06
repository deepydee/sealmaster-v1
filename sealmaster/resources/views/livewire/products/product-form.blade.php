<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ $editing ? __('Edit product') : __('Create product') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.products.index')">
                {{ __('Products') }}
            </x-breadcrumbs.item>
            <x-breadcrumbs.item>
                {{ $editing ? __('Edit product') : __('Create product') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>


        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div class="mb-4">
                            <x-input-label class="mb-1" for="categoryId" :value="__('Category')" />
                            <x-select wire:model="categoryId" id="categoryId" name="category" :title="__('Choose category')"
                                :options="$this->listsForFields['categories']" />
                            <x-input-error :messages="$errors->get('categoryId')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            <div>
                                <x-input-label class="mb-1" for="attributes-00" :value="__('Attribute')" />
                                <x-select wire:model="attributes.0" class="mt-1" id="attributes-00" name="attributes-00"
                                    :options="$this->listsForFields['attributes']" :title="__('Choose attribute')"/>
                                <x-input-error :messages="$errors->get('attributes.0')" class="mt-2" />
                            </div>
                            {{-- @switch($attributeTypes[0])
                                @case('image')
                                    <p>Image</p>
                                    @break
                                @default

                            @endswitch --}}
                            <div x-cloak>
                                <x-input-label for="attributeVal-00" :value="__('Value')" />
                                <x-text-input wire:model.lazy="attributeValue.0" id="attributeVal-00"
                                    class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('attributeValue.0')" class="mt-2" />
                            </div>

                            <button wire:click.prevent="addAttribute({{$i}})" type="button"
                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <!-- Heroicon name: solid/plus-sm -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        @foreach($inputs as $key => $value)
                        <div class="flex items-center gap-3 mb-4" x-cloak>
                            <div>
                                <x-input-label class="mb-1" for="attributes-{{ $key }}" :value="__('Attributes')" />
                                <x-select wire:model="attributes.{{ $value }}" class="mt-1" id="attributes-{{ $key }}" name="attributes-{{ $key }}"
                                :title="__('Choose attribute')" :options="$this->listsForFields['attributes']" />
                                <x-input-error :messages="$errors->get('attributes.{{ $value }}')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="attributeVal-{{ $value }}" :value="__('Value')" />
                                <x-text-input wire:model.lazy="attributeValue.{{ $value }}" id="attributeVal-{{ $value }}"
                                    class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('attributeValue.{{ $value }}')" class="mt-2" />
                            </div>
                            <button wire:click.prevent="removeAttribute({{$key}})" type="button"
                                class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <!-- Heroicon name: solid/plus-sm -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                  </svg>
                            </button>
                        </div>
                        @endforeach

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input wire:model.lazy="product.title" id="title" class="block mt-1 w-full"
                                type="text" />
                            <x-input-error :messages="$errors->get('product.title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input wire:model.lazy="product.code" id="code" class="block mt-1 w-full"
                                type="text" />
                            <x-input-error :messages="$errors->get('product.code')" class="mt-2" />
                        </div>

                        <div x-cloak class="mb-4">
                            <x-input-label for="description" :value="__('Description')" class="mb-1" />
                            <div wire:ignore>
                                <x-ck-editor wire:model.lazy="product.description" id="description" data-content="@this" id="description"
                                    field="product.description" />
                            </div>

                            <x-input-error :messages="$errors->get('product.description')" class="mt-2" />
                        </div>

                        <div class="mt-6 space-y-6 mb-4">
                            <x-input-label class="mb-1 cursor-pointer" for="thumbnail">
                                <div class="mb-4">{{ __('Thumbnail') }}</div>
                                <img src="
                                    @if($updateThumb)
                                        {{ $thumbnail->temporaryURL() }}
                                    @else
                                        {{ $product->getFirstMediaURL('products', 'thumb') }}
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
