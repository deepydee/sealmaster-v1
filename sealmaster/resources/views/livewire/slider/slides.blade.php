<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Slides') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.slides.index')">
                {{ __('Slides') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
    </x-slot>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @can('create', App\Models\Slide::class)
                    <div class="mb-4">
                        <a href="{{ route('admin.slides.create') }}"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700 cursor-pointer">
                            {{ __('Add') }}
                        </a>
                    </div>
                    @endcan

                    <x-table bodyModel="wire:sortable=updateOrder">
                        <x-slot:heading>
                            <x-table.heading>
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Name') }}
                                </span>
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Link') }}
                                </span>
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Thumbnail') }}
                                </span>
                            </x-table.heading>
                             <x-table.heading>
                            </x-table.heading>
                        </x-slot>
                        @forelse ($slides as $slide)
                            <x-table.row wire:key="{{ $loop->index }}" wire:sortable.item="{{ $slide->id }}">
                                <x-table.cell>
                                    @can('update', $slide)
                                    <button wire:sortable.handle class="cursor-move">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                            <path fill="none" d="M0 0h256v256H0z" />
                                            <path fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" d="M156.3 203.7 128 232l-28.3-28.3M128 160v72M99.7 52.3 128 24l28.3 28.3M128 96V24M52.3 156.3 24 128l28.3-28.3M96 128H24M203.7 99.7 232 128l-28.3 28.3M160 128h72" />
                                        </svg>
                                    </button>
                                    @endcan
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $slide->title }}
                                </x-table.cell>
                                <x-table.cell>
                                    <a href="{{ $slide->link }}" target="_blank" rel="noopener noreferrer">{{ $slide->link }}</a>
                                </x-table.cell>
                                <x-table.cell>
                                    <img src="{{ $slide->getFirstMediaURL('slides', 'thumb') }}" alt="Front of women's basic tee in heather gray."
                                    class="flex-none w-24 h-24 object-center object-cover bg-gray-100 rounded-md">
                                </x-table.cell>
                                <x-table.cell>
                                    @can('update', $slide)
                                    <a href="{{ route('admin.slides.edit', $slide->id) }}" title="{{ __('Edit') }}">
                                        @include('svg.btn-edit')
                                    </a>
                                    @endcan
                                    @can('delete', $slide)
                                    <span wire:click="deleteConfirm('delete', {{ $slide->id }})"
                                        title="{{ __('Remove') }}">
                                        @include('svg.btn-trash')
                                    </span>
                                    @endcan
                                </x-table.cell>
                            </x-table.row>
                        @empty
                        <x-table.row>
                            <x-table.cell colspan="4" class="grow">
                                Нет слайдов
                            </x-table.cell>
                        </x-table.row>
                        @endforelse
                    </x-table>
                    {!! $links !!}
                </div>
            </div>
        </div>
</div>
