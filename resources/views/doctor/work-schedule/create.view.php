<?php

use Carbon\Carbon; ?>

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
                            <a href="/doctors/<?= auth()->user()->id ?>/work-schedule">Work Schedule</a>
                            >
                            Add work day..
                        </span>
                    </div>
                    <div class="create-form-layout">
                        <h1>Add doctor to system</h1>
                        <form action="/doctors/<?= auth()->user()->id ?>/schedule/store" method="POST">
                            <div class="form-control">
                                <label for="date">Date:</label>
                                <input type="date" name="date" id="date" value="<?= old('date') ?>" min="<?= Carbon::today()->toDateString() ?>" max="<?= Carbon::today()->addWeeks(2)->toDateString() ?>">
                                <?php if ($error = error('date')): ?>
                                    <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-control">
                                <label for="time_from">From:</label>
                                <input type="time" name="time_from" id="time_from" value="<?= old('time_from') ?>">
                                <?php if ($error = error('time_from')): ?>
                                    <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-control">
                                <label for="time_to">To:</label>
                                <input type="time" name="time_to" id="time_to" value="<?= old('time_to') ?>">
                                <?php if ($error = error('time_to')): ?>
                                    <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="form-control">
                                <input type="submit" value="Save Schedule">
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