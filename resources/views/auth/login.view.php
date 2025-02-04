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
                            <h2>clinic manager</h2>
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
</body>

</html>