<?php
session_start();
require_once 'lang.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('title', $lang) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf9 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .hero-section {
            padding: 4rem 0;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        }
        .btn-primary {
            background: linear-gradient(120deg, #4361ee, #3a0ca3);
            border: none;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(120deg, #3a56e0, #2b0a8a);
            transform: scale(1.03);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #4cc9f0, #4361ee);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 1.5rem;
        }
        .contact-link {
            color: #4361ee;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        .contact-link:hover {
            color: #3a0ca3;
            text-decoration: underline;
        }
        footer {
            margin-top: 3rem;
            padding: 2rem 0;
            color: #6c757d;
            border-top: 1px solid #eee;
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

    <div class="container">
        <!-- Hero -->
        <section class="hero-section text-center">
            <h1 class="display-4 fw-bold mb-3"><?= __('hero_title', $lang) ?></h1>
            <p class="lead text-muted mb-4">
                <?= __('hero_desc', $lang) ?>
            </p>
            <a href="auth.php" class="btn btn-primary btn-lg"><?= __('btn_login_register', $lang) ?></a>
        </section>

        <!-- Features -->
        <section class="mb-5">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon mx-auto">📊</div>
                        <h5><?= __('features.analytics', $lang) ?></h5>
                        <p class="text-muted">
                            <?= __('features.analytics_desc', $lang) ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon mx-auto">🔒</div>
                        <h5><?= __('features.security', $lang) ?></h5>
                        <p class="text-muted">
                            <?= __('features.security_desc', $lang) ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card p-4 h-100">
                        <div class="feature-icon mx-auto">📱</div>
                        <h5><?= __('features.telegram', $lang) ?></h5>
                        <p class="text-muted">
                            <?= __('features.telegram_desc', $lang) ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Me -->
        <section class="text-center mb-5">
            <h2 class="mb-4"><?= __('about_author', $lang) ?></h2>
            <p class="text-muted mb-3">
                <?= __('portfolio_roles', $lang) ?>
            </p>
            <div class="d-flex justify-content-center gap-4 flex-wrap">
                <span class="badge bg-primary">Web Dev (PHP)</span>
                <span class="badge bg-success">Data Analysis (Python)</span>
                <span class="badge bg-warning text-dark">QA Testing</span>
            </div>
        </section>

        <!-- Contacts -->
        <section class="text-center mb-5">
            <h3><?= __('contact_me', $lang) ?></h3>
            <div class="mt-3">
                <!-- 🔁 ЗАМЕНИ ЭТИ ССЫЛКИ НА СВОИ! -->
                <p>
                    <a href="https://t.me/susichhh" class="contact-link" target="_blank">Telegram</a> •
                    <a href="mailto:zorkovivan134@gmail.com" class="contact-link">Email</a> •
                    <a href="https://github.com/Ivankosusech" class="contact-link" target="_blank">GitHub</a>
                </p>
            </div>
        </section>
    </div>

    <footer class="container text-center">
        <p class="mb-0">&copy; <?= date('Y') ?> <?= __('footer', $lang) ?></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>