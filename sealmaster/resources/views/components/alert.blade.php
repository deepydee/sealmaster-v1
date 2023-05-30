<div>
    @if (session()->has('message'))
        <div
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-init="setTimeout(() => show = false, 2000)"
        class="p-3 mb-4 text-green-700 bg-green-200 rounded-md"
        >
            {{ session('message') }}
        </div>
    @endif
</div>
