<?php
// public/lang.php

// Определяем язык
$allowed_langs = ['ru', 'en', 'ko'];
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'ru';

if (in_array($lang, $allowed_langs)) {
    $_SESSION['lang'] = $lang;
} else {
    $lang = 'ru';
}

// Настройки валюты и форматирования по языку
$currency_settings = [
    'ru' => ['symbol' => '₽', 'thousands_sep' => ' ', 'decimal_sep' => ','],
    'en' => ['symbol' => '$', 'thousands_sep' => ',', 'decimal_sep' => '.'],
    'ko' => ['symbol' => '₩', 'thousands_sep' => ',', 'decimal_sep' => '.'],
];

// Все тексты перевода
$translations = [
    'ru' => [
        'invalid_email' => 'Некорректный email',
        'password_too_short' => 'Пароль должен быть не короче 6 символов',
        'invalid_credentials' => 'Неверный email или пароль',
        'email_exists' => 'Пользователь с таким email уже существует',
        'registration_success' => 'Регистрация успешна! Теперь войдите.',
        'recovery_sent' => 'Ссылка для восстановления отправлена на ваш email (демо-режим).',
        'title' => 'Finance Tracker — Твой личный помощник в финансах',
        'hero_title' => '💰 Finance Tracker',
        'hero_desc' => 'Простой, безопасный и удобный инструмент для учёта личных финансов.<br>Отслеживай расходы, анализируй привычки и достигай финансовых целей.',
        'btn_login_register' => 'Войти / Зарегистрироваться',
        'features' => [
            'analytics' => 'Аналитика',
            'analytics_desc' => 'Визуализация трат по категориям и времени. Понимай, куда уходят деньги.',
            'security' => 'Безопасность',
            'security_desc' => 'Твои данные хранятся локально. Никаких облаков — только ты и твой бюджет.',
            'telegram' => 'Telegram-бот',
            'telegram_desc' => 'В будущем — добавление трат прямо из Telegram. Уже в разработке!',
        ],
        'about_author' => 'Об авторе',
        'portfolio_roles' => 'Этот проект создан как часть портфолио, демонстрирующего навыки в трёх ролях:',
        'contact_me' => 'Связаться со мной',
        'footer' => 'Проект для портфолио.',
        
        // Auth
        'auth_title' => 'Авторизация',
        'auth_subtitle' => 'Войдите или создайте аккаунт',
        'login_tab' => 'Вход',
        'register_tab' => 'Регистрация',
        'forgot_tab' => 'Забыли пароль?',
        'email' => 'Email',
        'password' => 'Пароль',
        'confirm_password' => 'Подтвердите пароль',
        'btn_login' => 'Войти',
        'btn_register' => 'Зарегистрироваться',
        'btn_forgot' => 'Отправить ссылку',
        'back_to_main' => '← Вернуться на главную',
        
        // Dashboard
        'dashboard_title' => 'Дашборд — Finance Tracker',
        'dashboard_header' => 'Ваш личный финансовый помощник',
        'add_transaction' => 'Добавить операцию',
        'type_income' => 'Доход',
        'type_expense' => 'Расход',
        'amount' => 'Сумма',
        'category' => 'Категория',
        'comment' => 'Комментарий',
        'btn_add' => 'Добавить',
        'today' => 'Сегодня',
        'this_week' => 'За неделю',
        'balance' => 'Баланс',
        'income' => 'Доходы',
        'expense' => 'Расходы',
        'top_category' => 'Топ категория',
        'recent_transactions' => 'Последние операции',
        'no_transactions' => 'Пока нет операций. Добавьте первую!',
        'logout' => 'Выйти',
        
        // Categories (расходы)
        'food' => 'Еда',
        'transport' => 'Транспорт',
        'entertainment' => 'Развлечения',
        'health' => 'Здоровье',
        'other_expense' => 'Другое',
        
        // Categories (доходы)
        'salary' => 'Зарплата',
        'freelance' => 'Фриланс',
        'investments' => 'Инвестиции',
        'gift' => 'Подарок',
        'other_income' => 'Другое',
    ],
    'en' => [
        'invalid_email' => 'Invalid email',
        'password_too_short' => 'Password must be at least 6 characters',
        'invalid_credentials' => 'Invalid email or password',
        'email_exists' => 'User with this email already exists',
        'registration_success' => 'Registration successful! Please log in.',
        'recovery_sent' => 'Recovery link sent to your email (demo mode).',
        'title' => 'Finance Tracker — Your Personal Finance Assistant',
        'hero_title' => '💰 Finance Tracker',
        'hero_desc' => 'A simple, secure, and convenient tool for tracking personal finances.<br>Monitor expenses, analyze habits, and achieve financial goals.',
        'btn_login_register' => 'Login / Register',
        'features' => [
            'analytics' => 'Analytics',
            'analytics_desc' => 'Visualize spending by category and time. Understand where your money goes.',
            'security' => 'Security',
            'security_desc' => 'Your data is stored locally. No clouds — just you and your budget.',
            'telegram' => 'Telegram Bot',
            'telegram_desc' => 'Coming soon: add expenses directly from Telegram. Already in development!',
        ],
        'about_author' => 'About the Author',
        'portfolio_roles' => 'This project is part of a portfolio demonstrating skills in three roles:',
        'contact_me' => 'Contact Me',
        'footer' => 'Portfolio project.',
        
        // Auth
        'auth_title' => 'Authentication',
        'auth_subtitle' => 'Log in or create an account',
        'login_tab' => 'Login',
        'register_tab' => 'Register',
        'forgot_tab' => 'Forgot Password?',
        'email' => 'Email',
        'password' => 'Password',
        'confirm_password' => 'Confirm Password',
        'btn_login' => 'Login',
        'btn_register' => 'Register',
        'btn_forgot' => 'Send Link',
        'back_to_main' => '← Back to Main',
        
        // Dashboard
        'dashboard_title' => 'Dashboard — Finance Tracker',
        'dashboard_header' => 'Your Personal Finance Assistant',
        'add_transaction' => 'Add Transaction',
        'type_income' => 'Income',
        'type_expense' => 'Expense',
        'amount' => 'Amount',
        'category' => 'Category',
        'comment' => 'Comment',
        'btn_add' => 'Add',
        'today' => 'Today',
        'this_week' => 'This Week',
        'balance' => 'Balance',
        'income' => 'Income',
        'expense' => 'Expenses',
        'top_category' => 'Top Category',
        'recent_transactions' => 'Recent Transactions',
        'no_transactions' => 'No transactions yet. Add your first one!',
        'logout' => 'Logout',
        
        // Categories
        'food' => 'Food',
        'transport' => 'Transport',
        'entertainment' => 'Entertainment',
        'health' => 'Health',
        'other_expense' => 'Other',
        'salary' => 'Salary',
        'freelance' => 'Freelance',
        'investments' => 'Investments',
        'gift' => 'Gift',
        'other_income' => 'Other',
    ],
    'ko' => [
        'invalid_email' => '잘못된 이메일',
        'password_too_short' => '비밀번호는 최소 6자 이상이어야 합니다',
        'invalid_credentials' => '잘못된 이메일 또는 비밀번호',
        'email_exists' => '이 이메일로 이미 가입된 사용자가 있습니다',
        'registration_success' => '등록이 완료되었습니다! 이제 로그인하세요.',
        'recovery_sent' => '복구 링크가 이메일로 전송되었습니다(데모 모드).',
        'title' => 'Finance Tracker — 개인 재정 관리 도우미',
        'hero_title' => '💰 Finance Tracker',
        'hero_desc' => '간단하고 안전하며 편리한 개인 재정 관리 도구입니다.<br>지출을 추적하고 습관을 분석하여 재정 목표를 달성하세요.',
        'btn_login_register' => '로그인 / 회원가입',
        'features' => [
            'analytics' => '분석',
            'analytics_desc' => '카테고리 및 시간별 지출을 시각화하세요. 돈이 어디로 가는지 이해하세요.',
            'security' => '보안',
            'security_desc' => '귀하의 데이터는 로컬에 저장됩니다. 클라우드 없이 오직 당신과 예산만 있습니다.',
            'telegram' => '텔레그램 봇',
            'telegram_desc' => '곧 출시: 텔레그램에서 직접 지출을 추가하세요. 이미 개발 중입니다!',
        ],
        'about_author' => '작성자 소개',
        'portfolio_roles' => '이 프로젝트는 다음 세 가지 역할의 기술을 보여주는 포트폴리오의 일부입니다:',
        'contact_me' => '연락하기',
        'footer' => '포트폴리오 프로젝트.',
        
        // Auth
        'auth_title' => '인증',
        'auth_subtitle' => '로그인하거나 계정을 생성하세요',
        'login_tab' => '로그인',
        'register_tab' => '회원가입',
        'forgot_tab' => '비밀번호를 잊으셨나요?',
        'email' => '이메일',
        'password' => '비밀번호',
        'confirm_password' => '비밀번호 확인',
        'btn_login' => '로그인',
        'btn_register' => '회원가입',
        'btn_forgot' => '링크 보내기',
        'back_to_main' => '← 메인으로 돌아가기',
        
        // Dashboard
        'dashboard_title' => '대시보드 — Finance Tracker',
        'dashboard_header' => '개인 재정 관리 도우미',
        'add_transaction' => '거래 추가',
        'type_income' => '수입',
        'type_expense' => '지출',
        'amount' => '금액',
        'category' => '카테고리',
        'comment' => '댓글',
        'btn_add' => '추가',
        'today' => '오늘',
        'this_week' => '이번 주',
        'balance' => '잔액',
        'income' => '수입',
        'expense' => '지출',
        'top_category' => '상위 카테고리',
        'recent_transactions' => '최근 거래 내역',
        'no_transactions' => '거래 내역이 없습니다. 첫 번째 거래를 추가하세요!',
        'logout' => '로그아웃',
        
        // Categories
        'food' => '식비',
        'transport' => '교통',
        'entertainment' => '엔터테인먼트',
        'health' => '건강',
        'other_expense' => '기타',
        'salary' => '급여',
        'freelance' => '프리랜서',
        'investments' => '투자',
        'gift' => '선물',
        'other_income' => '기타',
    ],
];

// Функция перевода (поддерживает вложенные ключи через точку)
function __($key, $lang = 'ru') {
    global $translations;
    
    if (!isset($translations[$lang])) {
        return "{{$key}}";
    }
    
    $keys = explode('.', $key);
    $value = $translations[$lang];
    
    foreach ($keys as $k) {
        if (is_array($value) && isset($value[$k])) {
            $value = $value[$k];
        } else {
            return "{{$key}}";
        }
    }
    
    return $value;
}

// Функция форматирования денег под язык
function format_money($amount, $lang = 'ru') {
    global $currency_settings;
    $settings = $currency_settings[$lang] ?? $currency_settings['en'];
    
    // Для корейского — округляем до целого (воны редко дробные)
    if ($lang === 'ko') {
        $formatted = number_format(round($amount), 0, '', $settings['thousands_sep']);
    } else {
        $formatted = number_format($amount, 2, $settings['decimal_sep'], $settings['thousands_sep']);
    }
    
    // В английском символ перед числом, в остальных — после
    if ($lang === 'en') {
        return $settings['symbol'] . $formatted;
    } else {
        return $formatted . ' ' . $settings['symbol'];
    }
}
?>