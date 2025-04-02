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
                        <form action="/admins/update/<?= $user->id ?>" method="POST">
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

    <script type="module" src="/resources/js/top-bar.js"></script>
    <script type="module" src="/resources/js/sidebar.js"></script>
</body>

</html>