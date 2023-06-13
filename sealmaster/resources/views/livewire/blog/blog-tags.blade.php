<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Tags') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.blog.posts.index')">
                {{ __('Tags') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @can('create', \App\Models\BlogTag::class)
                    <x-primary-button wire:click.prevent="openModal" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'add-tag')" class="mb-4">
                        {{ __('Add') }}
                    </x-primary-button>

                    <x-remove-button :disabled="!$this->selectedCount" wire:click="deleteConfirm('deleteSelected')"
                        wire:loading.attr="disabled">
                        {{ __('Delete Selected') }}
                    </x-remove-button>
                    @endcan
                    <x-table>
                        <x-slot:heading>
                            <x-table.heading>
                                @can('create', \App\Models\BlogTag::class)
                                <input id="selectAll" type="checkbox" value="" class="cursor-pointer">
                                @endcan
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('blog_tags.title')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Name') }}</span>
                                @if ($sortColumn == 'blog_tags.title')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('blog_tags.slug')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Slug') }}</span>
                                @if ($sortColumn == 'blog_tags.slug')
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

                            @forelse($tags as $tag)
                            <x-table.row>
                                <x-table.cell>
                                    @can('delete', $tag)
                                    <input wire:model="selected" type="checkbox" class="table-item cursor-pointer"
                                        value="{{ $tag->id }}">
                                    @endcan
                                </x-table.cell>
                                {{-- Inline Edit Start --}}
                                <x-table.cell :hidden="$editedTagId !== $tag->id">
                                    <x-text-input wire:model="tag.title" id="tag.title"
                                        class="py-2 pr-4 pl-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                                    @error('tag.title')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </x-table.cell>
                                <x-table.cell :hidden="$editedTagId !== $tag->id">
                                    <x-text-input wire:model="tag.slug" id="tag.slug"
                                        class="py-2 pr-4 pl-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400" />
                                    @error('tag.slug')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                    @enderror
                                </x-table.cell>
                                {{-- Inline Edit End --}}
                                {{-- Show tag Name/Slug Start --}}
                                <x-table.cell :hidden="$editedTagId === $tag->id">
                                    {{ $tag->title }}
                                </x-table.cell>
                                <x-table.cell :hidden="$editedTagId === $tag->id">
                                    {{ $tag->slug }}
                                </x-table.cell>
                                {{-- Show tag Name/Slug End --}}
                                <x-table.cell>
                                    @if($editedTagId === $tag->id)
                                    <x-primary-button wire:click="save" class="mr-2">
                                        {{ __('Save') }}
                                    </x-primary-button>
                                    <x-primary-button wire:click.prevent="cancelTagEdit" id="cancel-{{ $loop->index }}">
                                        {{ __('Cancel') }}
                                    </x-primary-button>
                                    @else
                                    @can('update', $tag)
                                    <span wire:click="editTag({{ $tag->id }})" class="mr-2" title="{{ __('Edit') }}">
                                        @include('svg.btn-edit')
                                    </span>
                                    @endcan
                                    @can('delete', $tag)
                                    <span wire:click="deleteConfirm('delete', {{ $tag->id }})"
                                        title="{{ __('Remove') }}">
                                        @include('svg.btn-trash')
                                    </span>
                                    @endcan
                                    @endif
                                </x-table.cell>
                            </x-table.row>
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="4" class="grow">
                                    Нет тегов
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                    </x-table>
                    {!! $links !!}
                </div>
            </div>
        </div>

        <x-modal name="add-tag" :show="$showModal" focusable>
            <form wire:submit.prevent="save" class="w-full">
                <div class="flex flex-col items-start p-4">
                    <div class="flex items-center pb-4 mb-4 w-full border-b">
                        <div class="text-lg font-medium text-gray-900">{{ __('Create tag') }}</div>
                        <svg x-on:click="$dispatch('close')"
                            class="ml-auto w-6 h-6 text-gray-700 cursor-pointer fill-current"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z" />
                        </svg>
                    </div>
                    <div class="mb-2 w-full">
                        <x-input-label for="tag.title" value="{{ __('Name') }}" class="sr-only" />
                        <x-text-input wire:model.debounce.1000ms="tag.title" id="tag.title"
                            class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400"
                            placeholder="{{ __('Name') }}" />
                        @error('tag.title')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2 w-full">
                        <x-input-label for="tag.slug" value="{{ __('Slug') }}" class="sr-only" />
                        <x-text-input wire:model.debounce.1000ms="tag.slug" id="tag.slug"
                            class="py-2 pr-4 pl-2 mt-2 w-full text-sm rounded-lg border border-gray-400 sm:text-base focus:outline-none focus:border-blue-400"
                            placeholder="{{ __('Slug') }}" />
                        @error('tag.slug')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <x-primary-button x-on:click="$dispatch('close')">
                            {{ __('Create') }}
                        </x-primary-button>
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </div>
            </form>
        </x-modal>
</div>
