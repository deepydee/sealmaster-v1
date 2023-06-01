@props(['field'])

<div x-cloak wire:ignore>
    <textarea {{ $attributes->merge(['class' => 'block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}></textarea>
</div>


@push('js')
    <script>
        const ready = (callback) => {
            if (document.readyState !== "loading") callback();
            else document.addEventListener("DOMContentLoaded", callback);
        }

        ready(() =>{
            ClassicEditor
                .create(document.querySelector('#{{ $attributes['id'] }}'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('{{ $field }}', editor.getData());
                    });

                    Livewire.on('reinit', () => {
                        editor.setData('', '');
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endpush
