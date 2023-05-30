<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Categories') }}</h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-primary-button wire:click.prevent="openModal" class="mb-4">
                        Добавить
                    </x-primary-button>

                    <div class="overflow-hidden overflow-x-auto mb-4 min-w-full align-middle sm:rounded-md">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Имя</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">Слаг</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50 w-56">
                                    </th>
                                </tr>
                            </thead>

                            <tbody wire:sortable="updateOrder" class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach($categories as $category)
                                    <tr class="bg-white">
                                        {{-- Inline Edit Start --}}
                                        <td class="@if($editedCategoryId !== $category->id) hidden @endif px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            <x-text-input wire:model="category.title" id="category.title" class="py-2 pr-4 pl-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                                            @error('category.title')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        <td class="@if($editedCategoryId !== $category->id) hidden @endif px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            <x-text-input wire:model="category.slug" id="category.slug" class="py-2 pr-4 pl-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                                            @error('category.slug')
                                                <span class="text-sm text-red-500">{{ $message }}</span>
                                            @enderror
                                        </td>
                                        {{-- Inline Edit End --}}

                                        {{-- Show Category Name/Slug Start --}}
                                        <td class="@if($editedCategoryId === $category->id) hidden @endif px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $category->title }}
                                        </td>
                                        <td class="@if($editedCategoryId === $category->id) hidden @endif px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            {{ $category->slug }}
                                        </td>
                                        {{-- Show Category Name/Slug End --}}
                                        <td class="flex items-center justify-end px-4 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                                            @if($editedCategoryId === $category->id)
                                                <x-primary-button wire:click="save" class="mr-2">
                                                    Сохранить
                                                </x-primary-button>
                                                <x-primary-button wire:click.prevent="cancelCategoryEdit" id="cancel-{{ $loop->index }}">
                                                    Отмена
                                                </x-primary-button>
                                            @else
                                            <span wire:click="editCategory({{ $category->id }})" class="mr-2" title="Редактировать">
                                                @include('svg.btn-edit')
                                            </span>
                                            <span wire:click="deleteConfirm('delete', {{ $category->id }})" title="Удалить">
                                                @include('svg.btn-trash')
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                    {!! $links !!}
                </div>
            </div>
        </div>
    </div>

    <div class="@if (!$showModal) hidden @endif flex items-center justify-center fixed left-0 bottom-0 w-full h-full bg-gray-800 bg-opacity-90">
        <div class="w-1/2 bg-white rounded-lg">
            <form wire:submit.prevent="save" class="w-full">
                <div class="flex flex-col items-start p-4">
                    <div class="flex items-center pb-4 mb-4 w-full border-b">
                        <div class="text-lg font-medium text-gray-900">Создание категории</div>
                        <svg wire:click.prevent="$set('showModal', false)"
                             class="ml-auto w-6 h-6 text-gray-700 cursor-pointer fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </div>
                    <div class="mb-2 w-full">
                        <label class="block text-sm font-medium text-gray-700" for="category.title">
                            Имя
                        </label>
                        <input wire:model.debounce.1000ms="category.title" id="category.title"
                               class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                        @error('category.title')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 w-full">
                        <label class="block text-sm font-medium text-gray-700" for="category.slug">
                            Слаг
                        </label>
                        <input wire:model="category.slug" id="category.slug"
                               class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                        @error('category.slug')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 ml-auto">
                        <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" type="submit">
                            Создать
                        </button>
                        <button wire:click.prevent="$set('showModal', false)" class="px-4 py-2 font-bold text-white bg-gray-500 rounded" type="button" data-dismiss="modal">
                            Отмена
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
