import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;

Alpine.start();

window.addEventListener('swal:confirm', event => {
    Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.type,
        showCancelButton: true,
        confirmButtonColor: 'rgb(239 68 6)',
        confirmButtonText: 'Да, удалить!',
        cancelButtonText: 'Отмена',
    })
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                window.livewire.emit(event.detail.method, event.detail.id);
            }
        });
});
