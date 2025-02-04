<!DOCTYPE html>
<html>

<head>
    <?php require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>

<body>
    <div class="app">
        <?php require_once BASE_PATH . '/resources/views/home/partials/header.view.php' ?>
        <main>
            <?php require_once BASE_PATH . '/resources/views/home/partials/hero.view.php' ?>
        </main>
    </div>
</body>

<script>
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
</script>

</html>