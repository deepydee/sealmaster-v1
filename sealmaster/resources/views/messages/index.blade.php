<x-app-layout>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Messages') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item>
                {{ __('Messages') }}
            </x-breadcrumbs.item>
        </x-breadcrumbs>
        </x-slot>

        <div class="mx-auto max-w-7xl sm:px-2 lg:px-2">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alert />
                    <livewire:messages-table tableName="MessagesTable" />
                </div>
            </div>
        </div>
</x-app-layout>
