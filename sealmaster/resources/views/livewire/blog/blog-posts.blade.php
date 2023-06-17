<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Posts') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.blog.posts.index')">
                {{ __('Posts') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>

        <div class="mx-auto max-w-7xl sm:px-2 lg:px-2">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4">
                        @can('create', \App\Models\BlogPost::class)
                        <a href="{{ route('admin.blog.posts.create') }}"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700 cursor-pointer">
                            {{ __('Add') }}
                        </a>
                        <x-remove-button :disabled="!$this->selectedCount" wire:click="deleteConfirm('deleteSelected')"
                            wire:loading.attr="disabled">
                            {{ __('Delete Selected') }}
                        </x-remove-button>
                        @endcan
                    </div>


                    <x-table>
                        <x-slot:heading>
                            <x-table.heading>
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('title')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Name') }}
                                </span>
                                @if ($sortColumn == 'blog_posts.title')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('user_id')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Author') }}
                                </span>
                                @if ($sortColumn == 'user_id')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('categoryTitle')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Category') }}
                                </span>
                                @if ($sortColumn == 'categoryTitle')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Tags') }}
                                </span>
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('updated_at')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Date') }}
                                </span>
                                @if ($sortColumn == 'updated_at')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Active') }}
                                </span>
                            </x-table.heading>

                            <x-table.heading class="text-center">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">
                                    {{ __('Items') }}
                                </span>
                            </x-table.heading>
                            <x-table.row>
                                <x-table.cell>
                                    @can('create', \App\Models\BlogPost::class)
                                    <input id="selectAll" type="checkbox" value="" class="cursor-pointer">
                                    @endcan
                                </x-table.cell>
                                <x-table.cell>
                                    <input wire:model="searchColumns.title" type="text" placeholder="Поиск..."
                                        class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                </x-table.cell>
                                <x-table.cell></x-table.cell>
                                <x-table.cell>
                                    <x-select wire:model="searchColumns.blog_category_id" id="blog_category_id"
                                        :options="$categories" :title="__('Choose category')" />
                                </x-table.cell>
                                <x-table.cell>
                                    <x-select wire:model="searchColumns.blog_tag_id" id="blog_tag_id" :options="$tags"
                                        :title="__('Choose tag')" />
                                </x-table.cell>

                                <x-table.cell></x-table.cell>
                                <x-table.cell></x-table.cell>

                                <x-table.cell>
                                    <select wire:model="perPage"
                                        class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        @foreach($itemsToShow as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </x-table.cell>
                            </x-table.row>
                            </x-slot>

                            @forelse($posts as $post)
                            @can('view', $post)
                            <x-table.row>
                                <x-table.cell>
                                    @can('delete', $post)
                                    <input wire:model="selected" type="checkbox" class="table-item cursor-pointer"
                                        value="{{ $post->id }}">
                                    @endcan
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{route('blog.page', $post->slug)}}" target="_blank">{{ $post->title }}</a>
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $post->user->name ?? 'Анонимный автор' }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $post->category->title }}
                                </x-table.cell>

                                <x-table.cell class="flex flex-wrap gap-1">
                                    @foreach($post->tags as $tag)
                                    <span class="px-2 py-1 text-xs text-indigo-700 bg-indigo-200 rounded-md">{{
                                        $tag->title }}</span>
                                    @endforeach
                                </x-table.cell>

                                <x-table.cell>
                                    {{ $post->updated_at }}
                                </x-table.cell>

                                <x-table.cell>
                                    <div
                                        class="inline-block relative mr-2 w-10 align-middle transition duration-200 ease-in select-none">
                                        <input wire:model="active.{{ $post->id }}"
                                            wire:click="toggleIsActive({{ $post->id }})" type="checkbox" name="toggle"
                                            id="{{ $loop->index.$post->id }}"
                                            class="block absolute w-6 h-6 bg-white rounded-full border-4 appearance-none cursor-pointer focus:outline-none toggle-checkbox transition duration-700" />
                                        <label for="active-{{ $loop->index.$post->id }}"
                                            class="block overflow-hidden h-6 bg-gray-300 rounded-full cursor-pointer toggle-label transition duration-500"></label>
                                    </div>
                                </x-table.cell>

                                <x-table.cell>
                                    @can('update', $post)
                                    <a href="{{ route('admin.blog.posts.edit', $post) }}" title="{{ __('Edit') }}">
                                        @include('svg.btn-edit')
                                    </a>
                                    @endcan
                                    @can('delete', $post)
                                    <span wire:click="deleteConfirm('delete', {{ $post->id }})"
                                        title="{{ __('Remove') }}">
                                        @include('svg.btn-trash')
                                    </span>
                                    @endcan
                                </x-table.cell>
                            </x-table.row>
                            @endcan
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="4" class="grow">
                                    Нет статей
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                    </x-table>
                    {!! $links !!}
                </div>
            </div>
        </div>
