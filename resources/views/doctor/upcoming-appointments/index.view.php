<?php

use Carbon\Carbon;

?>

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
                            Appointments
                        </span>
                    </div>
                    <table class="table responsive">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Patient</th>
                                <th>Personal No.</th>
                                <th>Phone number</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $date => $scheduleList): ?>
                                <tr>
                                    <td colspan="5" style="font-weight: bold;"><?= $date ?></td>
                                </tr>
                                <?php foreach ($scheduleList as $appointment): ?>
                                    <tr>
                                        <td></td>
                                        <td data-label="Time"><?= $appointment['time'] ?></td>
                                        <td data-label="Patient Name"><?= $appointment['patient_firstname'] ?> <?= $appointment['patient_lastname'] ?></td>
                                        <td data-label="Personal No."><?= $appointment['patient_personalno'] ?></td>
                                        <td data-label="Phone"><?= $appointment['patient_phone'] ?></td>
                                        <td data-label="Note"><?= $appointment['note'] ?></td>
                                        <td data-label="Actions">
                                            <a href="/appointments/<?= $appointment['id'] ?>/write-diagnosis" class="btn btn-edit"><i class='bx bxs-notepad'></i></a>
                                            <form action="/appointments/<?= $appointment['id'] ?>/decline" method="POST" style="display:inline;">
                                                <input type="hidden" name="_method" value="DELETE"> <!-- Spoof DELETE method -->
                                                <button type="submit" class="btn btn-delete" onclick="return confirm(`Are you sure you want to cancel the patient's appointment?`);">Decline</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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