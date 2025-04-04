const successMessage = document.getElementById('success-message');
const errorMessage = document.getElementById('unsuccess-message');

if (successMessage || errorMessage) {
    let message = successMessage ? successMessage.getAttribute('data-message') : errorMessage.getAttribute('data-message');
    let icon = successMessage ? 'success' : 'error';

    Swal.fire({
        text: message,
        buttonsStyling: false,
        customClass: {
            confirmButton: 'swal2-btn-sm'
        },
        confirmButtonText: 'Close',
        icon: icon
    });
}