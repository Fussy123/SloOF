const $targetEl = document.getElementById('crud-modals');

// options with default values
const options = {
    placement: 'bottom-right',
    backdrop: 'dynamic',
    backdropClasses:
        'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
    closable: true,
    onHide: () => {
        console.log('modal is hidden');
    },
    onShow: () => {
        console.log('modal is shown');
    },
    onToggle: () => {
        console.log('modal has been toggled');
    },
};

// instance options object
const instanceOptions = {
  id: 'crud-modal',
  override: true
};



import { Modal } from 'flowbite';

/*
 * $targetEl: required
 * options: optional
 */
const modal = new Modal($targetEl, options, instanceOptions);

modal.show();

// hide the modal
modal.hide();

modal.isHidden();

// true if visible
modal.isVisible();