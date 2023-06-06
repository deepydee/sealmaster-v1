@props(['bodyModel' => ''])

<div class="overflow-hidden overflow-x-auto mb-4 min-w-full align-middle sm:rounded-md">
    <table {{ $attributes->merge(['class' => 'min-w-full border divide-y divide-gray-200']) }}>
        <thead>
            <tr>
                {{ $heading }}
            </tr>
        </thead>
        <tbody {{$bodyModel}} class="bg-white divide-y divide-gray-200 divide-solid">
            {{ $slot }}
        </tbody>
    </table>
</div>

@push('js')
    <script>
        document.addEventListener("livewire:load", () => {
            const selectAll = document.getElementById('selectAll');

            selectAll.addEventListener('change', (event) => {
                const items = document.querySelectorAll('.table-item');
                [...items].forEach(e => e.checked = event.currentTarget.checked);

                const selectedValues = [...items]
                    .filter(e => e.checked)
                    .map(e => e.value);

                @this.set('selected', selectedValues)
            });
        });
    </script>
@endpush
