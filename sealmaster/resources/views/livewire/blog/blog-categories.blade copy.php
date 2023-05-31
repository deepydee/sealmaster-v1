<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Categories') }}</h1>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <x-alert />
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-primary-button wire:click.prevent="openModal" class="mb-4">
                        {{ __('Add') }}
                    </x-primary-button>

                    <x-remove-button :disabled="!$this->selectedCount" wire:click="deleteConfirm('deleteSelected')"
                        wire:loading.attr="disabled">
                         {{ __('Delete Selected') }}
                    </x-remove-button>

                    <x-table>
                        <x-slot:heading>
                            <x-table.heading>
                                <input id="selectAll" type="checkbox" value="" class="cursor-pointer">
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('blog_categories.title')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Name') }}</span>
                                @if ($sortColumn == 'blog_categories.title')
                                    @include('svg.sort-' . $sortDirection)
                                @else
                                    @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('blog_categories.slug')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{ __('Slug') }}</span>
                                @if ($sortColumn == 'blog_categories.slug')
                                    @include('svg.sort-' . $sortDirection)
                                @else
                                    @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading>
                                <select wire:model="perPage"
                                class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($itemsToShow as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </x-table.heading>
                        </x-slot>

                        @forelse($categories as $category)
                        <x-table.row>
                            <x-table.cell>
                                <input wire:model="selected" type="checkbox" class="table-item cursor-pointer" value="{{ $category->id }}">
                            </x-table.cell>
                            {{-- Inline Edit Start --}}
                            <x-table.cell :hidden="$editedCategoryId !== $category->id">
                                <x-text-input wire:model="category.title" id="category.title" class="py-2 pr-4 pl-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                                @error('category.title')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </x-table.cell>
                            <x-table.cell :hidden="$editedCategoryId !== $category->id">
                                <x-text-input wire:model="category.slug" id="category.slug" class="py-2 pr-4 pl-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                                @error('category.slug')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </x-table.cell>
                            {{-- Inline Edit End --}}
                            {{-- Show Category Name/Slug Start --}}
                            <x-table.cell :hidden="$editedCategoryId === $category->id">
                                {{ $category->title }}
                            </x-table.cell>
                            <x-table.cell :hidden="$editedCategoryId === $category->id">
                                {{ $category->slug }}
                            </x-table.cell>
                            {{-- Show Category Name/Slug End --}}
                            <x-table.cell>
                                @if($editedCategoryId === $category->id)
                                    <x-primary-button wire:click="save" class="mr-2">
                                        {{ __('Save') }}
                                    </x-primary-button>
                                    <x-primary-button wire:click.prevent="cancelCategoryEdit" id="cancel-{{ $loop->index }}">
                                        {{ __('Cancel') }}
                                    </x-primary-button>
                                @else
                                    <span wire:click="editCategory({{ $category->id }})" class="mr-2" title="{{ __('Edit') }}">
                                        @include('svg.btn-edit')
                                    </span>
                                    <span wire:click="deleteConfirm('delete', {{ $category->id }})" title="{{ __('Remove') }}">
                                        @include('svg.btn-trash')
                                    </span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="4" class="grow">
                                Нет категорий
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-table>
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
                        <div class="text-lg font-medium text-gray-900">{{ __('Create category') }}</div>
                        <svg wire:click.prevent="$set('showModal', false)"
                             class="ml-auto w-6 h-6 text-gray-700 cursor-pointer fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </div>
                    <div class="mb-2 w-full">
                        <label class="block text-sm font-medium text-gray-700" for="category.title">
                            {{ __('Name') }}
                        </label>
                        <input wire:model.debounce.1000ms="category.title" id="category.title"
                               class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                        @error('category.title')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 w-full">
                        <label class="block text-sm font-medium text-gray-700" for="category.slug">
                            {{ __('Slug') }}
                        </label>
                        <input wire:model="category.slug" id="category.slug"
                               class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                        @error('category.slug')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mt-4 ml-auto">
                        <button class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700" type="submit">
                            {{ __('Create') }}
                        </button>
                        <button wire:click.prevent="$set('showModal', false)" class="px-4 py-2 font-bold text-white bg-gray-500 rounded" type="button" data-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
