<div x-show="open" class="fixed inset-0 flex z-40 md:hidden"
    x-description="Off-canvas menu for mobile, show/hide based on off-canvas menu state." x-ref="dialog"
    aria-modal="true" style="display: none;">

    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-description="Off-canvas menu overlay, show/hide based on off-canvas menu state."
        class="fixed inset-0 bg-gray-600 bg-opacity-75" @click="open=false" aria-hidden="true" style="display: none;">
    </div>

    <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        x-description="Off-canvas menu, show/hide based on off-canvas menu state."
        class="relative flex-1 flex flex-col max-w-xs w-full bg-white" style="display: none;">

        <div x-show="open" x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            x-description="Close button, show/hide based on off-canvas menu state."
            class="absolute top-0 right-0 -mr-12 pt-2" style="display: none;">
            <button type="button"
                class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                @click="open = ! open">
                <span class="sr-only">Close sidebar</span>
                <svg class="h-6 w-6 text-white" x-description="Heroicon name: outline/x"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
            <div class="flex-shrink-0 flex items-center px-4">
                <a href="/">
                    <x-application-logo class="h-10 w-auto" />
                </a>
            </div>
            <nav class="mt-5 px-2 space-y-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    @include('svg.home')
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile')">
                    @include('svg.users')
                    {{ __('Users') }}
                </x-nav-link>
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                      <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                      <span class="px-2 bg-white text-sm text-gray-500"> {{ __('Blog') }} </span>
                    </div>
                </div>
                <x-nav-link :href="route('admin.blog.categories.index')" :active="request()->routeIs('admin.blog.categories.*')">
                    @include('svg.category')
                    {{ __('Categories') }}
                </x-nav-link>
            </nav>
        </div>
        <div class="flex-shrink-0 flex justify-between border-t border-gray-200 p-4">
            <a href="{{ route('profile.edit') }}" class="flex-shrink-0 group block">
                <div class="flex items-center">
                    <div>
                        <img class="inline-block h-10 w-10 rounded-full"
                            src="{{ auth()->user()->getFirstMediaURL('avatars', 'thumb') }}"
                            alt="">
                    </div>
                    <div class="ml-3">
                        <p class="text-base font-medium text-gray-700 group-hover:text-gray-900">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-sm font-medium text-gray-500 group-hover:text-gray-700">
                            {{ __('Profile') }}
                        </p>
                    </div>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link :href="route('logout')" class="hover:text-red-700 transition-all" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    @include('svg.logout')
                    {{ __('Log Out') }}
                </x-nav-link>
            </form>
        </div>
    </div>

    <div class="flex-shrink-0 w-14">
        <!-- Force sidebar to shrink to fit close icon -->
    </div>
</div>

<div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white">
        <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
            <div class="flex items-center flex-shrink-0 px-4">
                <a href="/">
                    <x-application-logo class="h-10 w-auto" />
                </a>
            </div>
            <nav class="mt-5 flex-1 px-2 bg-white space-y-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    @include('svg.home')
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    @include('svg.users')
                    {{ __('Users') }}
                </x-nav-link>
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                      <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                      <span class="px-2 bg-white text-sm text-gray-500"> {{ __('Blog') }} </span>
                    </div>
                </div>
                <x-nav-link :href="route('admin.blog.categories.index')" :active="request()->routeIs('admin.blog.categories.*')">
                    @include('svg.category')
                    {{ __('Categories') }}
                </x-nav-link>
            </nav>
        </div>
        <div class="flex-shrink-0 flex justify-between border-t border-gray-200 p-4">
            <a href="{{ route('profile.edit') }}" class="flex-shrink-0 group block">
                <div class="flex items-center">
                    <div>
                        <img class="inline-block h-9 w-9 rounded-full"
                            src="{{ auth()->user()->getFirstMediaURL('avatars', 'thumb') }}"
                            alt="">
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">
                           {{ __('Profile') }}
                        </p>
                    </div>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link :href="route('logout')" class="hover:text-red-700 transition-all" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                    @include('svg.logout')
                    {{ __('Log Out') }}
                </x-nav-link>
            </form>
        </div>
    </div>
</div>
