import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import Choices from 'choices.js';
import '@nextapps-be/livewire-sortablejs';
import flatpickr from "flatpickr";
import './../../vendor/power-components/livewire-powergrid/dist/powergrid'
import './../../vendor/power-components/livewire-powergrid/dist/powergrid.css'

window.Choices = Choices;
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
                // console.log(event.detail.method, event.detail.id);
                window.livewire.emit(event.detail.method, event.detail.id);
            }
        });
});

window.addEventListener('swal:info', event => {
    Swal.fire({
        title: event.detail.title,
        text: event.detail.text,
        icon: event.detail.type,
        showCancelButton: true,
        confirmButtonColor: 'rgb(63 195 238)',
        confirmButtonText: 'Прочитано',
        cancelButtonText: 'Отмена',
    })
        .then((process) => {
            if (process.isConfirmed) {
                // console.log(event.detail.method, event.detail.id);
                window.livewire.emit(event.detail.method, event.detail.id);
            }
        });
});
