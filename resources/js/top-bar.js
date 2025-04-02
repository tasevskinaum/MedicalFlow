document.addEventListener('DOMContentLoaded', () => {
    const profilePicture = document.querySelector('#user-profile-picture');
    const dropdownMenu = document.querySelector('.user-dropdown-menu');

    profilePicture.addEventListener('click', () => {
        dropdownMenu.classList.toggle('active');
    });

    document.addEventListener('click', (event) => {
        !profilePicture.contains(event.target) && !dropdownMenu.contains(event.target) ?
            dropdownMenu.classList.remove('active') :
            null;
    });
});

function updateDateTime() {
    const now = new Date();

    const dateString = now.toLocaleDateString(undefined, {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });

    const timeString = now.toLocaleTimeString(undefined, {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });

    document.querySelector('.live-datetime').textContent = `${dateString} | ${timeString}`;
}

setInterval(updateDateTime, 1000);
updateDateTime();