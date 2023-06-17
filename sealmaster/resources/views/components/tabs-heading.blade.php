<div class="pb-5 border-b border-gray-200 sm:pb-0">
    <h3 class="text-lg leading-6 font-medium text-gray-900"> {{ __('Blog') }}</h3>
    <div class="mt-3 sm:mt-4">
    <!-- Dropdown menu on small screens -->
    <div class="sm:hidden">
        <label for="current-tab" class="sr-only">Select a tab</label>
        <select id="current-tab" name="current-tab" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        <option>Applied</option>

        <option>Phone Screening</option>

        <option selected>Interview</option>

        <option>Offer</option>

        <option>Hired</option>
        </select>
    </div>
    <!-- Tabs at small breakpoint and up -->
    <div class="hidden sm:block">
        <nav class="-mb-px flex space-x-8">
            {{ $slot }}
        </nav>
    </div>
    </div>
</div>
