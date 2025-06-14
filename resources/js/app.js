import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import TomSelect from 'tom-select';

document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('customer_id');
    if (select && !select.tomselect) {
        new TomSelect(select,  {
            create: false,
            placeholder: 'Cari pelanggan...',
            allowEmptyOption: true,
        });
    }
});

