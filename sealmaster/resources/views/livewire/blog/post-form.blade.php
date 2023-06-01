<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ $editing ? __('Edit post') : __('Create post') }}</h1>
    </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form wire:submit.prevent="save">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input wire:model.lazy="post.title" id="title" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('post.title')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label class="mb-1" for="keywords" :value="__('Keywords')" />
                                <x-text-input wire:model.lazy="post.keywords" id="Keywords" class="block mt-1 w-full" type="text" />
                                <x-input-error :messages="$errors->get('post.keywords')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label class="mb-1" for="country" :value="__('Category')" />
                                <x-select wire:model="post.blog_category_id" id="blog_category_id" name="category" :options="$this->listsForFields['categories']" />
                                 <x-input-error :messages="$errors->get('post.blog_category_id')" class="mt-2" />
                            </div>

                            <div x-cloak class="mb-4">
                                <x-input-label for="description" :value="__('Description')" />

                                <textarea wire:model.lazy="post.description" id="description"  class="min-h-max block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>

                                <x-input-error :messages="$errors->get('post.description')" class="mt-2" />
                            </div>

                            <div x-cloak class="mb-4">
                                <x-input-label for="content" :value="__('Content')" />
                                <div wire:ignore>
                                    <x-ck-editor wire:model.lazy="post.content" data-content="@this" id="content" field="post.content" />
                                </div>
                                <x-input-error :messages="$errors->get('post.content')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input-label class="mb-1" for="tags" :value="__('Tags')" />
                                <x-choices wire:model="tags" class="mt-1" id="tags" name="tags" :options="$this->listsForFields['tags']" multiple />
                                <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                            </div>

                            <div class="mt-6 space-y-6 mb-4">
                                <x-input-label class="mb-1 cursor-pointer" for="thumbnail">
                                    <div class="mb-4">{{ __('Thumbnail') }}</div>
                                    <img src="
                                    @if($updateThumb)
                                        {{ $thumbnail->temporaryURL() }}
                                    @else
                                        {{ $post->getFirstMediaURL('blog', 'thumb') }}
                                    @endif" alt="Front of women's basic tee in heather gray." class="flex-none w-24 h-24 object-center object-cover bg-gray-100 rounded-md">
                                </x-input-label>
                                <x-input-file wire:model="thumbnail" id="thumbnail" name="thumbnail" aria-describedby="file_input_help" />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG или GIF (Макс. 800x400px).</p>
                                <x-input-error class="mt-2" :messages="$errors->get('thumbnail')" />
                            </div>

                            <div class="mb-4">
                                <x-input-label class="mb-1" for="author" :value="__('Author')" />

                                <select wire:model="post.user_id" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-1">
                                    <option value="">{{ __('Choose author') }}</option>
                                    @foreach($listsForFields['users'] as $key => $value)
                                        <option value="{{ $key }}" {{ $key == $post->user_id ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                 <x-input-error :messages="$errors->get('post.user_id')" class="mt-2" />
                            </div>

                            <div class="mb-6">
                                <x-input-label class="mb-1" for="tags" :value="__('Active')" />
                                <div
                                    class="inline-block relative mr-2 w-10 align-middle transition duration-200 ease-in select-none">
                                    <input wire:model="post.is_published"
                                        wire:click="toggleIsPublished()" type="checkbox"
                                        name="toggle" id="isPublished"
                                        class="block absolute w-6 h-6 bg-white rounded-full border-4 appearance-none cursor-pointer focus:outline-none toggle-checkbox transition duration-700" />
                                    <label for="isPublished"
                                        class="block overflow-hidden h-6 bg-gray-300 rounded-full cursor-pointer toggle-label transition duration-500"></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <x-primary-button type="submit">
                                    {{  __('Save')  }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
</div>
