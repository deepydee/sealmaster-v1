<x-app-layout>
    <x-slot:header>
        <h1 class="text-2xl font-semibold text-gray-900">{{ __('Posts') }}</h1>
        <x-breadcrumbs>
            <x-breadcrumbs.item :href="route('admin.blog.posts.index')">
                {{ __('Posts') }}
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
                    </div>

                    <livewire:products-list/>

                </div>
            </div>
        </div>
</x-app-layout>
