<?php

use App\Http\Models\DoctorSchedule;
use App\Http\Models\User;

?>

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
                            <a href="/appointments">Appointments</a>
                            >
                            Write diagnosis
                        </span>
                    </div>
                    <div class="write-diagnosis">
                        <div class="patient">
                            <div>Date & Time: <span> <?= DoctorSchedule::find($appointment->doctor_schedule_id)->date ?> | <?= $appointment->time ?> </span></div>
                            <div>Patient: <span><?= $patient->first_name ?> <?= $patient->last_name ?></span></div>
                            <div>Personal No. : <span><?= $patient->personal_no ?></span></div>
                            <div>Phone: <span><?= $patient->phone_number ?></span></div>
                            <div>Note: <span><?= $appointment->note ?></span></div>
                        </div>
                        <div class="form">
                            <form action="/appointments/<?= $appointment->id ?>/write-diagnosis" method="POST">
                                <div class="form-control">
                                    <label for="diagnosis">Write diagnosis:</label>
                                    <textarea name="diagnosis" id="diagnosis" rows="20"><?= old('diagnosis', $appointment->diagnosis) ?></textarea>
                                    <?php if ($error = error('diagnosis')): ?>
                                        <span class="fdb error">This field is required!</span>
                                    <?php endif; ?>
                                </div>
                                <div class="form-control">
                                    <input type="submit" value="submit">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="previous-diagnosis">
                        <div class="title">
                            <h2>Previous diagnosis</h2>
                        </div>
                        <div class="body">
                            <?php if (empty($previous_diagnosis)): ?>
                                <div>This patient don't have previous diagnosis in this clinic !</div>
                            <?php endif ?>
                            <?php foreach ($previous_diagnosis as $diagnosis) : ?>
                                <?php $previousDiagnosisInfo = DoctorSchedule::find($diagnosis->doctor_schedule_id); ?>
                                <div class="diagnosis">
                                    <div class="date"><span><?= $previousDiagnosisInfo->date ?></span></div>
                                    <div class="doctor">Doctor: <span><?= User::find($previousDiagnosisInfo->user_id)->name ?></span></div>
                                    <div>Diagnosis: <span><?= $diagnosis->diagnosis ?></span></div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script type="module" src="/resources/js/top-bar.js"></script>
    <script type="module" src="/resources/js/sidebar.js"></script>
</body>

</html>