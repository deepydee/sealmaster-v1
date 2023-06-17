<div class="sm:px-8 py-4 lg:py-4 max-w-2xl">
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="bg-white rounded-md px-6 flex space-x-4">
            <li class="flex">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-500">
                        <svg class="flex-shrink-0 h-5 w-5" x-description="Heroicon name: solid/home"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        <span class="sr-only">Главная</span>
                    </a>
                </div>
            </li>
            {{ $slot }}
        </ol>
    </nav>
</div>
