@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }}
    type="button"
    {!! $attributes->merge(['class' => 'px-4 py-2 text-xs text-red-500 uppercase bg-red-200 rounded-md border border-transparent hover:text-red-700 hover:bg-red-300 disabled:opacity-50 disabled:cursor-not-allowed']) !!}>
    {{ $slot }}
</button>
