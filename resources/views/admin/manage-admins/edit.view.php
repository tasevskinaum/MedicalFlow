<!DOCTYPE html>
<html>

<head>
    <?php require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>

<body>
    <div class="app">
        <div class="content-area">
            <?php require_once BASE_PATH . '/resources/views/admin/partials/sidebar.php' ?>
            <div class="main-content-area">
                <?php require_once BASE_PATH . '/resources/views/admin/partials/header.php' ?>
                <main>
                    <div class="pages-navigation">
                        <span>
                            <a href="/dashboard">Dashboard</a>
                            >
                            <a href="/admins">Manage Admins</a>
                            >
                            Edit Admin
                        </span>
                    </div>
                    <div class="create-admin">
                        <h1>Create new Admin</h1>
                        <form id="create-admin-form" action="/admins/update/<?= $user->id ?>" method="POST">
                            <div class="form-control">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="<?= old('name', $user->name) ?>">
                                <?php if ($error = error('name')): ?>
                                    <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-control">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" value="<?= old('username', $user->username) ?>">
                                <?php if ($error = error('username')): ?>
                                    <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-control">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" value="<?= old('email', $user->email) ?>">
                                <?php if ($error = error('email')): ?>
                                    <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-control">
                                <input type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script>
        // ON CLICK PROFIL PICTURE SHOW DROPDOWN MENU
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
    </script>


    <script>
        // SCRIPT FOR TIME IN BAR
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
    </script>

    <script>
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
    </script>
</body>

</html>