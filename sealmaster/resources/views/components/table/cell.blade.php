@props([
    'hidden' => false,
])

<td {{ $attributes->class(['hidden' => $hidden])->merge(['class' => 'px-4 py-2 text-sm leading-5 text-gray-900 whitespace-no-wrap']) }}>
   {{ $slot }}
</td>
