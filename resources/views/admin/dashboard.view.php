<!DOCTYPE html>
<html>

<head>
    <?php

    use App\Http\Models\DoctorProfile;
    use App\Http\Models\Role;

    require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>


<body>
    <div class="app">
        <div class="content-area">
            <?php require_once BASE_PATH . '/resources/views/admin/partials/sidebar.php' ?>
            <div class="main-content-area">
                <?php require_once BASE_PATH . '/resources/views/admin/partials/header.php' ?>
                <main>
                </main>
            </div>
        </div>
    </div>

    <script type="module" src="/resources/js/top-bar.js"></script>
    <script type="module" src="/resources/js/sidebar.js"></script>
</body>

</html>