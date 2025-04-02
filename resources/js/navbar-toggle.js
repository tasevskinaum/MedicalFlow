document.addEventListener('DOMContentLoaded', () => {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navigationContainer = document.querySelector('.navigation-container');
    const navigationWrapper = document.querySelector('.navigation-wrapper');
    const body = document.querySelector('body');

    navbarToggler.addEventListener('click', () => {
        [navbarToggler, navigationContainer, navigationWrapper].forEach(el => el.classList.toggle('active'));

        navbarToggler.classList.contains('active') ?
            body.style.overflow = 'hidden' : body.style.overflow = '';
    });
});