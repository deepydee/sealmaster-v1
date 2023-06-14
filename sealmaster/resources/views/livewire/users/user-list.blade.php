<div>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Users') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.users.index')">
                {{ __('Users') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <x-alert />
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        @can('create', \App\Models\User::class)
                        <a href="{{ route('admin.users.create') }}"
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
                                @can('create', \App\Models\User::class)
                                <input id="selectAll" type="checkbox" value="" class="cursor-pointer">
                                @endcan
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('users.name')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Name') }}</span>
                                @if ($sortColumn == 'users.name')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading wire:click="sortByColumn('users.email')">
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Email') }}</span>
                                @if ($sortColumn == 'users.email')
                                @include('svg.sort-' . $sortDirection)
                                @else
                                @include('svg.sort')
                                @endif
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Photo') }}</span>
                            </x-table.heading>
                            <x-table.heading>
                                <span class="text-xs font-medium tracking-wider leading-4 text-gray-500 uppercase">{{
                                    __('Roles') }}</span>
                            </x-table.heading>
                            <x-table.heading>
                                <select wire:model="perPage"
                                    class="text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach($itemsToShow as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </x-table.heading>
                            @forelse($users as $user)
                            <x-table.row>
                                <x-table.cell>
                                    @can('delete', $user)
                                    <input wire:model="selected" type="checkbox" class="table-item cursor-pointer"
                                        value="{{ $user->id }}">
                                    @endcan
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $user->name }}
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $user->email }}
                                </x-table.cell>
                                <x-table.cell>
                                    <img src="{{ $user->getFirstMediaURL('avatars', 'thumb') }}"
                                        alt="Front of women's basic tee in heather gray."
                                        class="flex-none w-10 object-center object-cover bg-gray-100 rounded-full">
                                </x-table.cell>
                                <x-table.cell>
                                    {{ $user->getRoles() }}
                                </x-table.cell>
                                <x-table.cell>
                                    @can('update', $user)
                                    <a href="{{ route('admin.users.edit', $user) }}" title="{{ __('Edit') }}">
                                         @include('svg.btn-edit')
                                    </a>
                                    @endcan
                                    @can('delete', $user)
                                    <span wire:click="deleteConfirm('delete', {{ $user->id }})"
                                        title="{{ __('Remove') }}">
                                        @include('svg.btn-trash')
                                    </span>
                                    @endcan
                                </x-table.cell>
                            </x-table.row>
                            @empty
                            <x-table.row>
                                <x-table.cell colspan="4" class="grow">
                                    Нет пользователей
                                </x-table.cell>
                            </x-table.row>
                            @endforelse
                            </x-slot>
                    </x-table>
                    {!! $links !!}
                </div>
            </div>
        </div>
</div>
