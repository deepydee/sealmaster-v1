@props(['options'])

<div x-cloak>
    <div wire:ignore class="w-full">
        <select {{ $attributes->merge(['class' => 'js-choice']) }}>
            @if(!isset($attributes['multiple']))
                <option></option>
            @endif
            <option value="">{{ __('Select ' . $attributes['name']) }}</option>
            @foreach($options as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

@push('js')

<script>
    document.addEventListener("livewire:load", () => {
        let el = document.getElementById('{{ $attributes['id'] }}');

        const initChoices = () => {
            new Choices(el, {
                allowHTML: false,
                noResultsText: 'Результатов не найдено',
                noChoicesText: 'Нет объектов для выбора',
                itemSelectText: 'Нажмите для выбора',
            });
        };

        initChoices();

        // Livewire.hook('message.processed', (message, component) => {
        //     initChoices();
        // });

        el.addEventListener('change', (e) => {
            const selected = e.currentTarget.querySelectorAll('option:checked');
            let values = [...selected].map(el => el.value);

            if (values.length === 0) {
                values = null;
            }

            // if (values.length === 1) {
            //     values = +values[0];
            // }
            // console.log(values);
            @this.set('{{ $attributes['wire:model'] }}', values)
        });
    });
</script>

@endpush

@push('styles')
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"
/>
@endpush
