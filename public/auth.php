<?php
session_start();
require_once 'lang.php';
require_once 'db.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = __('invalid_email', $lang);
        } elseif ($action !== 'forgot' && strlen($password) < 6) {
            $error = __('password_too_short', $lang);
        } else {
            if ($action === 'login') {
                $stmt = $pdo->prepare("SELECT id, password_hash FROM users WHERE email = ?");
                $stmt->execute([$email]);
                $user = $stmt->fetch();

                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $error = __('invalid_credentials', $lang);
                }
            } elseif ($action === 'register') {
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $error = __('email_exists', $lang);
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, created_at) VALUES (?, ?, datetime('now'))");
                    $stmt->execute([$email, $hash]);
                    $message = __('registration_success', $lang);
                }
            } elseif ($action === 'forgot') {
                // Безопасная заглушка: не раскрываем, существует ли email
                $message = __('recovery_sent', $lang);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('auth_title', $lang) ?> — Finance Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf9 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .auth-container {
            max-width: 500px;
            margin: 2rem auto;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: white;
        }
        .btn-primary {
            background: linear-gradient(120deg, #4361ee, #3a0ca3);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .nav-pills .nav-link {
            color: #4361ee;
            font-weight: 600;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(120deg, #4361ee, #3a0ca3);
            color: white;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Language switcher -->
    <div class="position-fixed top-0 end-0 p-2" style="z-index: 1000;">
        <div class="btn-group" role="group">
            <a href="?lang=ru" class="btn btn-sm <?= $lang === 'ru' ? 'btn-primary' : 'btn-outline-primary' ?>">RU</a>
            <a href="?lang=en" class="btn btn-sm <?= $lang === 'en' ? 'btn-primary' : 'btn-outline-primary' ?>">EN</a>
            <a href="?lang=ko" class="btn btn-sm <?= $lang === 'ko' ? 'btn-primary' : 'btn-outline-primary' ?>">KO</a>
        </div>
    </div>

    <div class="container auth-container">
        <div class="text-center mb-4">
            <h2><?= __('auth_title', $lang) ?></h2>
            <p class="text-muted"><?= __('auth_subtitle', $lang) ?></p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <ul class="nav nav-pills mb-4 justify-content-center" id="formSwitcher">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-form="login"><?= __('login_tab', $lang) ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-form="register"><?= __('register_tab', $lang) ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-form="forgot"><?= __('forgot_tab', $lang) ?></a>
            </li>
        </ul>

        <div class="card p-4">
            <form method="POST" class="form-section active" id="form-login">
                <input type="hidden" name="action" value="login">
                <div class="mb-3">
                    <label class="form-label"><?= __('email', $lang) ?></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= __('password', $lang) ?></label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-primary w-100"><?= __('btn_login', $lang) ?></button>
            </form>

            <form method="POST" class="form-section" id="form-register">
                <input type="hidden" name="action" value="register">
                <div class="mb-3">
                    <label class="form-label"><?= __('email', $lang) ?></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><?= __('password', $lang) ?></label>
                    <input type="password" name="password" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-primary w-100"><?= __('btn_register', $lang) ?></button>
            </form>

            <form method="POST" class="form-section" id="form-forgot">
                <input type="hidden" name="action" value="forgot">
                <div class="mb-3">
                    <label class="form-label"><?= __('email', $lang) ?></label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><?= __('btn_forgot', $lang) ?></button>
            </form>
        </div>

        <div class="text-center mt-3">
            <a href="index.php" class="text-muted"><?= __('back_to_main', $lang) ?></a>
        </div>
    </div>

    <script>
        document.querySelectorAll('#formSwitcher a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const formId = this.getAttribute('data-form');
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                document.querySelectorAll('.form-section').forEach(f => f.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('form-' + formId).classList.add('active');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>