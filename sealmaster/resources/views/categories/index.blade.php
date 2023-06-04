<x-app-layout>
    <div>
        <x-slot:header>
            <h1 class="text-2xl font-semibold text-gray-900">{{ __('Categories') }}</h1>
            <x-breadcrumbs>
                <x-breadcrumbs.item>
                    {{ __('Categories') }}
                </x-breadcrumbs.item>
            </x-breadcrumbs>
            </x-slot>

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <a href="{{ route('admin.categories.create') }}"
                            class="inline-flex items-center px-4 py-2 mb-3 text-xs font-semibold tracking-widest text-white uppercase bg-gray-800 rounded-md border border-transparent hover:bg-gray-700 cursor-pointer">
                            {{ __('Add') }}
                        </a>

                        <x-alert />

                        <ul class="list-disc my-2 pl-6">
                            @forelse($categories as $category)
                            <li class="{{ @blank($category->parent_id) ? 'font-bold' : '' }}"><a
                                    href="{{ route('category.show', $category->path) }}" target="_blank"
                                    rel="noopener noreferrer">{{ $category->title }}</a>
                                <span class="inline-flex items-baseline">
                                    <a href="{{ route('admin.categories.create', ['category' => $category, 'addChild' => true]) }}"
                                    class="inline-flex px-1 items-center text-gray-500 hover:text-gray-700"
                                    title="Добавить потомка"
                                    >
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-node-plus" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M11 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM6.025 7.5a5 5 0 1 1 0 1H4A1.5 1.5 0 0 1 2.5 10h-1A1.5 1.5 0 0 1 0 8.5v-1A1.5 1.5 0 0 1 1.5 6h1A1.5 1.5 0 0 1 4 7.5h2.025zM11 5a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 11 5zM1.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
                                      </svg>
                                    </a>
                                    <a href="{{ route('admin.categories.create', $category) }}" title="{{ __('Edit') }}" class="inline-flex px-1 items-center text-gray-500 hover:text-gray-700"
                                    title="Редактировать">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                      </svg>
                                    </a>
                                    <form action="{{ route('admin.categories.update',
                                    [
                                        'category' => $category,
                                        'title' => $category->title,
                                        'parent_id' => $category->parent_id,
                                        'shiftUp' => true
                                    ]) }}" method="POST" class="">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="inline-flex px-1 items-center text-gray-500 hover:text-gray-700"
                                            title="Сдвинуть вверх">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-caret-up"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3.204 11h9.592L8 5.519 3.204 11zm-.753-.659 4.796-5.48a1 1 0 0 1 1.506 0l4.796 5.48c.566.647.106 1.659-.753 1.659H3.204a1 1 0 0 1-.753-1.659z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.categories.update',
                                    [
                                        'category' => $category,
                                        'title' => $category->title,
                                        'parent_id' => $category->parent_id,
                                        'shiftDown' => true
                                    ]) }}" method="POST" class="">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit"
                                            class="inline-flex px-1 items-center text-gray-500 hover:text-gray-700"
                                            title="Сдвинуть вниз">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-caret-down"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="inline-flex items-center text-red-500 hover:text-red-700"
                                            title="Удалить"
                                            onclick="return confirm('Вы действительно хотите удалить категорию?')">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                <path
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </span>
                            </li>
                            @include('categories.subcategory', ['subcategories' => $category->children])
                        </ul>
                        @empty
                        <p>Нет категорий</p>
                        @endforelse
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
