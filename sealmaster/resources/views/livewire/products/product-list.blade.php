<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Products') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.products.index')">
                {{ __('Products') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="mb-4">
                        <a href="{{ route('admin.products.create') }}"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700 cursor-pointer">
                            {{ __('Add') }}
                        </a>

                        <x-remove-button :disabled="!$this->selectedCount" wire:click="deleteConfirm('deleteSelected')"
                            wire:loading.attr="disabled">
                            {{ __('Delete Selected') }}
                        </x-remove-button>
                    </div>

                    <x-table>
                        <x-slot:heading>
                            <x-table.heading>
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('title')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Name') }}
                                </span>
                                @if ($sortColumn == 'products.title')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('title')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Thumbnail') }}
                                </span>
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('code')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Code') }}
                                </span>
                                @if ($sortColumn == 'products.code')
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
                            <x-table.heading class="text-center">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">
                                    {{ __('Items') }}
                                </span>
                            </x-table.heading>
                            <x-table.row>
                                <x-table.cell>
                                    <input id="selectAll" type="checkbox" value="" class="cursor-pointer">
                                </x-table.cell>
                                <x-table.cell>
                                    <input wire:model="searchColumns.title" type="text" placeholder="Поиск..."
                                        class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                                </x-table.cell>
                                <x-table.cell>
                                </x-table.cell>
                                <x-table.cell>
                                </x-table.cell>
                                <x-table.cell>
                                    <x-select wire:model="searchColumns.category_id" id="category_id"
                                    :options="$categories" :title="__('Choose category')" />
                                </x-table.cell>
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

                            @forelse($products as $product)
                            <x-table.row>
                                <x-table.cell>
                                    <input wire:model="selected" type="checkbox" class="table-item cursor-pointer"
                                        value="{{ $product->id }}">
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $product->title }}
                                </x-table.cell>
                                <x-table.cell>
                                    <img src="{{ $product->getFirstMediaURL('products', 'thumb') }}" alt="Front of women's basic tee in heather gray."
                                    class="flex-none w-24 h-24 object-center object-cover bg-gray-100 rounded-md">
                                </x-table.cell>
                                 <x-table.cell>
                                    {{ $product->code }}
                                 </x-table.cell>
                                 <x-table.cell>
                                    {{ $product->categoryTitle }}
                                 </x-table.cell>
                                 <x-table.cell>
                                    <a href="{{ route('admin.products.edit', $product->slug) }}" title="{{ __('Edit') }}">
                                        @include('svg.btn-edit')
                                    </a>
                                    <span wire:click="deleteConfirm('delete', {{ $product->id }})"
                                        title="{{ __('Remove') }}">
                                        @include('svg.btn-trash')
                                    </span>
                                </x-table.cell>
                            </x-table.row>
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="4" class="grow">
                                    Нет товаров
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                    </x-table>

                </div>
            </div>
        </div>
</div>
