# generate_test_data.py
import sqlite3
import random
from datetime import datetime, timedelta
import hashlib

DB_PATH = "public/finance.db"

def hash_password(password):
    """Простой хеш (для демо; в PHP используется password_hash)"""
    return hashlib.sha256(password.encode()).hexdigest()

def generate_users_and_transactions():
    conn = sqlite3.connect(DB_PATH)
    cursor = conn.cursor()

    # Очистка существующих данных
    cursor.execute("DELETE FROM transactions")
    cursor.execute("DELETE FROM users")
    conn.commit()

    # 15+ пользователей с разными профилями
    base_users = [
        # Студенты
        {"name": "Student 1", "email": "student1@example.com", "password": "pass123", "type": "student"},
        {"name": "Student 2", "email": "student2@example.com", "password": "pass123", "type": "student"},
        {"name": "Student 3", "email": "student3@example.com", "password": "pass123", "type": "student"},
        {"name": "Student 4", "email": "student4@example.com", "password": "pass123", "type": "student"},
        {"name": "Student 5", "email": "student5@example.com", "password": "pass123", "type": "student"},

        # Фрилансеры
        {"name": "Freelancer 1", "email": "freelancer1@example.com", "password": "pass123", "type": "freelancer"},
        {"name": "Freelancer 2", "email": "freelancer2@example.com", "password": "pass123", "type": "freelancer"},
        {"name": "Freelancer 3", "email": "freelancer3@example.com", "password": "pass123", "type": "freelancer"},
        {"name": "Freelancer 4", "email": "freelancer4@example.com", "password": "pass123", "type": "freelancer"},

        # Офисные работники
        {"name": "Office 1", "email": "office1@example.com", "password": "pass123", "type": "office"},
        {"name": "Office 2", "email": "office2@example.com", "password": "pass123", "type": "office"},
        {"name": "Office 3", "email": "office3@example.com", "password": "pass123", "type": "office"},

        # Пенсионеры
        {"name": "Retiree 1", "email": "retiree1@example.com", "password": "pass123", "type": "retiree"},
        {"name": "Retiree 2", "email": "retiree2@example.com", "password": "pass123", "type": "retiree"},

        # Предприниматели
        {"name": "Entrepreneur 1", "email": "biz1@example.com", "password": "pass123", "type": "entrepreneur"},
        {"name": "Entrepreneur 2", "email": "biz2@example.com", "password": "pass123", "type": "entrepreneur"},
    ]

    user_ids = {}
    for user in base_users:
        cursor.execute(
            "INSERT INTO users (email, password_hash, created_at) VALUES (?, ?, datetime('now'))",
            (user["email"], hash_password(user["password"]))
        )
        user_ids[user["email"]] = cursor.lastrowid

    expense_cats = ["food", "transport", "entertainment", "health", "other_expense"]
    income_cats = ["salary", "freelance", "investments", "gift", "other_income"]

    start_date = datetime.now() - timedelta(days=90)
    end_date = datetime.now()

    current = start_date
    while current <= end_date:
        date_str = current.strftime("%Y-%m-%d")

        for email, user_id in user_ids.items():
            profile = next(u["type"] for u in base_users if u["email"] == email)

            # === Расходы ===
            if profile == "student":
                num_expenses = random.randint(2, 5)
                base_amount = random.uniform(80, 250)
            elif profile == "freelancer":
                num_expenses = random.randint(1, 4)
                base_amount = random.uniform(200, 600)
            elif profile == "office":
                num_expenses = random.randint(1, 3)
                base_amount = random.uniform(300, 1000)
            elif profile == "retiree":
                num_expenses = random.randint(1, 2)
                base_amount = random.uniform(100, 400)
            else:  # entrepreneur
                num_expenses = random.randint(1, 4)
                base_amount = random.uniform(500, 2000)

            for _ in range(num_expenses):
                amount = round(random.uniform(base_amount * 0.3, base_amount * 2), 2)
                cat = random.choice(expense_cats)
                cursor.execute(
                    "INSERT INTO transactions (user_id, type, amount, category, comment, date) VALUES (?, 'expense', ?, ?, ?, ?)",
                    (user_id, amount, cat, f"Auto expense on {date_str}", date_str)
                )

            # === Доходы ===
            income_amount = 0
            income_cat = "other_income"

            if profile == "student" and random.random() < 0.08:
                income_amount = random.uniform(3000, 20000)
                income_cat = "gift"
            elif profile == "freelancer" and random.random() < 0.25:
                income_amount = random.uniform(15000, 120000)
                income_cat = "freelance"
            elif profile == "office" and (current.day == 1 or current.day == 15):
                income_amount = random.uniform(50000, 150000)
                income_cat = "salary"
            elif profile == "retiree" and current.day == 10:
                income_amount = random.uniform(25000, 60000)
                income_cat = "investments"
            elif profile == "entrepreneur" and random.random() < 0.18:
                income_amount = random.uniform(80000, 500000)
                income_cat = "investments"

            if income_amount > 0:
                cursor.execute(
                    "INSERT INTO transactions (user_id, type, amount, category, comment, date) VALUES (?, 'income', ?, ?, ?, ?)",
                    (user_id, income_amount, income_cat, f"Income on {date_str}", date_str)
                )

        current += timedelta(days=1)

    conn.commit()
    conn.close()
    
    print(f"✅ Сгенерировано {len(base_users)} пользователей и ~{90 * len(base_users) * 2.5:.0f} транзакций!")
    print("\nДанные для входа (все пароли: pass123):")
    for u in base_users:
        print(f"  {u['email']}")

if __name__ == "__main__":
    generate_users_and_transactions()