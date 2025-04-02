<!DOCTYPE html>
<html>

<head>
    <?php

    use Carbon\Carbon;

    require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
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
                            Work Schedule
                        </span>
                    </div>
                    <div class="actions">
                        <a href="/doctors/<?= auth()->user()->id ?>/schedule/create" class="action-link">
                            Click here to add working day..
                            <span class="btn">
                                +
                            </span>
                        </a>
                    </div>
                    <table class="table responsive">
                        <thead>
                            <tr>
                                <th>Schedule No.</th>
                                <th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td data-label="Schedule No."><?= $schedule->id; ?></td>
                                    <td data-label="Date"><?= $schedule->date ?></td>
                                    <td data-label="From"><?= $schedule->time_from ?></td>
                                    <td data-label="To"><?= $schedule->time_to ?></td>
                                    <td data-label="Actions">
                                        <?php if (Carbon::createFromDate($schedule->date)->gt(Carbon::today())): ?>
                                            <form action="/doctors/<?= auth()->user()->id ?>/schedule/<?= $schedule->id ?>/destroy" method="POST" style="display:inline;">
                                                <input type="hidden" name="_method" value="DELETE"> <!-- Spoof DELETE method -->
                                                <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                            </form>
                                        <?php endif; ?>
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