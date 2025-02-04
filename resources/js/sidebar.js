// SIDEBAR SCRIPT
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('.sidebar');
    const sidebarCloseBtn = document.querySelector('.close-btn');

    function isNavbarCollapsed() {
        return window.innerWidth <= 768;
    }

    isNavbarCollapsed() ?
        sidebar.addEventListener('click', () => {
            !sidebar.classList.contains('expand') ?
                sidebar.classList.add('expand') :
                null;
        }) :
        null;

    sidebarCloseBtn.addEventListener('click', (event) => {
        event.stopPropagation();
        sidebar.classList.remove('expand');
    });
});