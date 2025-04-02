<!DOCTYPE html>
<html>

<head>
    <?php require_once BASE_PATH . '/resources/views/partials/_head.view.php' ?>
</head>

<body>
    <div class="app">
        <div class="login-page">
            <div class="login-container">
                <div class="wrapper">
                    <div class="side left-side">
                    </div>
                    <div class="side right-side">
                        <div class="brand">
                            <a href="/">
                                <h2>Medical Flow</h2>
                            </a>
                        </div>
                        <div class="wrapper">
                            <div class="form-container">
                                <form action="/login" method="POST">
                                    <?php if ($message = \Core\Session::getFlash('error')): ?>
                                        <span class="fdb error"><?= htmlspecialchars($message) ?></span>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" placeholder="Email" value="<?= old('email') ?>">
                                        <?php if ($error = error('email')): ?>
                                            <span class="fdb error"><?= htmlspecialchars($error) ?></span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" id="password" placeholder="Password">
                                    </div>

                                    <button type="submit">Log in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if (\Core\Session::has('success')): ?>
        <div id="success-message" data-message="<?= \Core\Session::getFlash('success') ?>" style="display: none;"></div>
    <?php endif; ?>
    <?php if (\Core\Session::has('unsuccess')): ?>
        <div id="unsuccess-message" data-message="<?= \Core\Session::getFlash('unsuccess') ?>" style="display: none;"></div>
    <?php endif; ?>

    <?php require_once BASE_PATH . '/resources/views/partials/_script.view.php' ?>
    <script type="module" src="/resources/js/alert/success-unsucsess.js"></script>
</body>

</html>