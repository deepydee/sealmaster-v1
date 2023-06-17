@props(['field'])

<div x-cloak wire:ignore>
    <textarea {{ $attributes->merge(['class' => 'block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}></textarea>
</div>


@push('js')
<script>
    class MyUploadAdapter {
    constructor( loader ) {
        this.loader = loader;
    }

    upload() {
        return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
    }

    abort() {
        if ( this.xhr ) {
            this.xhr.abort();
        }
    }

    _initRequest() {
        const xhr = this.xhr = new XMLHttpRequest();

        xhr.open( 'POST', '{{ route('admin.images.store') }}', true );
        xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
        xhr.responseType = 'json';
    }

     _initListeners( resolve, reject, file ) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText = `Couldn't upload file: ${ file.name }.`;

        xhr.addEventListener( 'error', () => reject( genericErrorText ) );
        xhr.addEventListener( 'abort', () => reject() );
        xhr.addEventListener( 'load', () => {
            const response = xhr.response;

            if ( !response || response.error ) {
                return reject( response && response.error ? response.error.message : genericErrorText );
            }

            resolve( response.urls );

            // resolve( {
            //     default: response.url
            // } );

        } );

        if ( xhr.upload ) {
            xhr.upload.addEventListener( 'progress', evt => {
                if ( evt.lengthComputable ) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            } );
        }
    }

    _sendRequest( file ) {
        const data = new FormData();

        data.append( 'upload', file );
        this.xhr.send( data );
    }
}

    function SimpleUploadAdapterPlugin( editor ) {
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
            return new MyUploadAdapter( loader );
        };
    }
    const ready = (callback) => {
        if (document.readyState !== "loading") callback();
        else document.addEventListener("DOMContentLoaded", callback);
    }

    ready(() =>{
        ClassicEditor
            .create(document.querySelector('#{{ $attributes['id'] }}'), {
                extraPlugins: [ SimpleUploadAdapterPlugin ],
                language: 'ru',
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading2', view: { name: 'h2', classes: 'display-6 fw-bold mt-5 mb-4' }, title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    ]
                },
                placeholder: 'Наберите текст',
                htmlEmbed: {
                    showPreviews: true
                },
            })
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
