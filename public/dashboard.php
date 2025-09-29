<?php
session_start();
require_once 'lang.php';
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit;
}
$user_id = $_SESSION['user_id'];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_transaction'])) {
    $type = $_POST['type'] ?? 'expense';
    $amount = floatval($_POST['amount']);
    $category = trim($_POST['category']);
    $comment = trim($_POST['comment'] ?? '');

    if ($amount <= 0) {
        $message = $lang === 'ru' ? 'Сумма должна быть больше нуля' : 
                   ($lang === 'en' ? 'Amount must be greater than zero' : '금액은 0보다 커야 합니다');
    } elseif (empty($category)) {
        $message = $lang === 'ru' ? 'Выберите категорию' : 
                   ($lang === 'en' ? 'Please select a category' : '카테고리를 선택하세요');
    } else {
        $stmt = $pdo->prepare("INSERT INTO transactions (user_id, type, amount, category, comment, date) VALUES (?, ?, ?, ?, ?, date('now'))");
        $stmt->execute([$user_id, $type, $amount, $category, $comment]);
        $message = $lang === 'ru' ? 'Операция добавлена!' : 
                   ($lang === 'en' ? 'Transaction added!' : '거래가 추가되었습니다!');
    }
}

$transactions = $pdo->prepare("
    SELECT * FROM transactions 
    WHERE user_id = ? 
    ORDER BY date DESC, id DESC 
    LIMIT 20
");
$transactions->execute([$user_id]);
$transactions_list = $transactions->fetchAll();

// Статистика
$today_income = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE user_id = ? AND type = 'income' AND date = date('now')");
$today_income->execute([$user_id]);
$total_income_today = $today_income->fetchColumn() ?: 0;

$today_expense = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE user_id = ? AND type = 'expense' AND date = date('now')");
$today_expense->execute([$user_id]);
$total_expense_today = $today_expense->fetchColumn() ?: 0;

$balance_today = $total_income_today - $total_expense_today;

$week_income = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE user_id = ? AND type = 'income' AND date >= date('now', '-6 days')");
$week_income->execute([$user_id]);
$total_income_week = $week_income->fetchColumn() ?: 0;

$week_expense = $pdo->prepare("SELECT SUM(amount) FROM transactions WHERE user_id = ? AND type = 'expense' AND date >= date('now', '-6 days')");
$week_expense->execute([$user_id]);
$total_expense_week = $week_expense->fetchColumn() ?: 0;

$balance_week = $total_income_week - $total_expense_week;

$top_income_cat = $pdo->prepare("
    SELECT category, SUM(amount) as total 
    FROM transactions 
    WHERE user_id = ? AND type = 'income'
    GROUP BY category 
    ORDER BY total DESC 
    LIMIT 1
");
$top_income_cat->execute([$user_id]);
$top_income = $top_income_cat->fetch();

$top_expense_cat = $pdo->prepare("
    SELECT category, SUM(amount) as total 
    FROM transactions 
    WHERE user_id = ? AND type = 'expense'
    GROUP BY category 
    ORDER BY total DESC 
    LIMIT 1
");
$top_expense_cat->execute([$user_id]);
$top_expense = $top_expense_cat->fetch();
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= __('dashboard_title', $lang) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .header {
            background: linear-gradient(120deg, #4361ee, #3a0ca3);
            color: white;
            padding: 1.5rem 0;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        .stat-card {
            text-align: center;
            padding: 1.2rem;
        }
        .stat-income { color: #2ecc71; font-weight: bold; }
        .stat-expense { color: #e74c3c; font-weight: bold; }
        .stat-balance { 
            color: <?= $balance_week >= 0 ? '#2ecc71' : '#e74c3c' ?>; 
            font-weight: bold; 
        }
        .btn-logout { background: #ff6b6b; border: none; }
        .btn-logout:hover { background: #ff5252; }
        .type-toggle .btn { min-width: 120px; }
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

    <div class="header text-center">
        <div class="container">
            <h1>💰 Finance Tracker</h1>
            <p><?= __('dashboard_header', $lang) ?></p>
            <a href="logout.php" class="btn btn-logout btn-sm"><?= __('logout', $lang) ?></a>
        </div>
    </div>

    <div class="container mt-4">
        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h5><?= __('add_transaction', $lang) ?></h5>
                <form method="POST">
                    <input type="hidden" name="add_transaction" value="1">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <div class="type-toggle btn-group" role="group">
                                <input type="radio" class="btn-check" name="type" id="type-expense" value="expense" checked>
                                <label class="btn btn-outline-danger" for="type-expense"><?= __('type_expense', $lang) ?></label>
                                
                                <input type="radio" class="btn-check" name="type" id="type-income" value="income">
                                <label class="btn btn-outline-success" for="type-income"><?= __('type_income', $lang) ?></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01" name="amount" class="form-control" placeholder="<?= __('amount', $lang) ?>" required min="0.01">
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select" required>
                                <option value=""><?= __('category', $lang) ?></option>
                                <optgroup label="<?= $lang === 'ru' ? 'Расходы' : ($lang === 'en' ? 'Expenses' : '지출') ?>">
                                    <option value="food"><?= __('food', $lang) ?></option>
                                    <option value="transport"><?= __('transport', $lang) ?></option>
                                    <option value="entertainment"><?= __('entertainment', $lang) ?></option>
                                    <option value="health"><?= __('health', $lang) ?></option>
                                    <option value="other_expense"><?= __('other_expense', $lang) ?></option>
                                </optgroup>
                                <optgroup label="<?= $lang === 'ru' ? 'Доходы' : ($lang === 'en' ? 'Income' : '수입') ?>">
                                    <option value="salary"><?= __('salary', $lang) ?></option>
                                    <option value="freelance"><?= __('freelance', $lang) ?></option>
                                    <option value="investments"><?= __('investments', $lang) ?></option>
                                    <option value="gift"><?= __('gift', $lang) ?></option>
                                    <option value="other_income"><?= __('other_income', $lang) ?></option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <input type="text" name="comment" class="form-control" placeholder="<?= __('comment', $lang) ?>">
                                <button type="submit" class="btn btn-primary"><?= __('btn_add', $lang) ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Статистика с валютой -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div><?= __('income', $lang) ?> (<?= __('today', $lang) ?>)</div>
                    <div class="stat-income">+<?= format_money($total_income_today, $lang) ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div><?= __('expense', $lang) ?> (<?= __('today', $lang) ?>)</div>
                    <div class="stat-expense">-<?= format_money($total_expense_today, $lang) ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div><?= __('balance', $lang) ?> (<?= __('today', $lang) ?>)</div>
                    <div class="stat-balance"><?= ($balance_today >= 0 ? '+' : '') . format_money(abs($balance_today), $lang) ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div><?= __('balance', $lang) ?> (<?= __('this_week', $lang) ?>)</div>
                    <div class="stat-balance"><?= ($balance_week >= 0 ? '+' : '') . format_money(abs($balance_week), $lang) ?></div>
                </div>
            </div>
        </div>

        <!-- Таблица операций -->
        <div class="card">
            <div class="card-body">
                <h5><?= __('recent_transactions', $lang) ?></h5>
                <?php if ($transactions_list): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><?= __('today', $lang) ?></th>
                                    <th><?= __('type_expense', $lang) ?>/<?= __('type_income', $lang) ?></th>
                                    <th><?= __('category', $lang) ?></th>
                                    <th><?= __('amount', $lang) ?></th>
                                    <th><?= __('comment', $lang) ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions_list as $t): ?>
                                <tr>
                                    <td><?= htmlspecialchars($t['date']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $t['type'] === 'income' ? 'success' : 'danger' ?>">
                                            <?= $t['type'] === 'income' ? __('type_income', $lang) : __('type_expense', $lang) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($t['category']) ?></td>
                                    <td>
                                        <span class="<?= $t['type'] === 'income' ? 'text-success' : 'text-danger' ?>">
                                            <?= ($t['type'] === 'income' ? '+' : '-') . format_money($t['amount'], $lang) ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($t['comment'] ?? '') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted"><?= __('no_transactions', $lang) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>