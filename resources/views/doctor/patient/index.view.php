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
                    <div class="patient-title">
                        <h2>Patients</h2>
                    </div>
                    <div class="patient-search">
                        <input type="text" id="patient" placeholder="Search patient here..">
                    </div>
                    <ul class="patients">
                        <?php foreach ($patients as $patient) : ?>
                            <li class="patient">
                                <a href="/patients/<?= $patient->id ?>">
                                    <div>
                                        <span><?= $patient->first_name ?> <?= $patient->last_name ?></span>
                                    </div>
                                    <div>
                                        <span><?= $patient->personal_no ?></span>
                                        <span><?= $patient->phone_number ?></span>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </main>
            </div>
        </div>
    </div>

    <script type="module" src="/resources/js/top-bar.js"></script>
    <script type="module" src="/resources/js/sidebar.js"></script>
    <script type="module" src="/resources/js/patients/patient-search.js"></script>
</body>

</html>