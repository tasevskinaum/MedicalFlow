<!DOCTYPE html>
<html>

<head>
    <?php require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>

<body>
    <div class="app">
        <div class="content-area">
            <?php require_once BASE_PATH . '/resources/views/admin/partials/sidebar.php'; ?>
            <div class="main-content-area">
                <?php require_once BASE_PATH . '/resources/views/admin/partials/header.php'; ?>
                <main>
                    <div class="pages-navigation">
                        <span>
                            <a href="/dashboard">Dashboard</a>
                            >
                            Manage Doctors
                        </span>
                    </div>
                    <div class="actions">
                        <a href="/doctors/create" class="action-link">
                            Click here to create doctor profile..
                            <span class="btn">
                                +
                            </span>
                        </a>
                    </div>
                    <table class="table responsive">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($doctors as $doctor): ?>
                                <tr>
                                    <td data-label="Name"><a href="#"><?php echo $doctor->name; ?></a></td>
                                    <td data-label="Email"><?php echo $doctor->email; ?></td>
                                    <td data-label="Username"><?php echo $doctor->username; ?></td>
                                    <td data-label="Role"><?= \App\Http\Models\Role::queryBuilder()->where('id', '=', $doctor->role_id)->first()->name ?></td>
                                    <td data-label="Actions">
                                        <a href="/doctors/edit/<?php echo $doctor->id; ?>" class="btn btn-edit">Edit</a>
                                        <!-- Delete Form -->
                                        <form action="/doctors/destroy/<?php echo $doctor->id; ?>" method="POST" style="display:inline;">
                                            <input type="hidden" name="_method" value="DELETE"> <!-- Spoof DELETE method -->
                                            <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </main>
            </div>
        </div>
        <?php if (\Core\Session::has('success')): ?>
            <div id="success-message" data-message="<?= \Core\Session::getFlash('success') ?>" style="display: none;"></div>
        <?php endif; ?>
        <?php if (\Core\Session::has('unsuccess')): ?>
            <div id="unsuccess-message" data-message="<?= \Core\Session::getFlash('unsuccess') ?>" style="display: none;"></div>
        <?php endif; ?>
    </div>

    <?php require_once BASE_PATH . '/resources/views/partials/_script.view.php' ?>

    <script type="module" src="/resources/js/top-bar.js"></script>
    <script type="module" src="/resources/js/sidebar.js"></script>
    <script type="module" src="/resources/js/alert/success-unsucsess.js"></script>
</body>

</html>