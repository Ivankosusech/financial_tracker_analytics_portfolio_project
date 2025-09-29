# analytics/analyze.py
import sqlite3
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
import os
from datetime import datetime

# Style configuration
plt.rcParams['font.size'] = 10
sns.set_style("whitegrid")

# Paths
DB_PATH = "../public/finance.db"
OUTPUT_DIR = "output"
os.makedirs(OUTPUT_DIR, exist_ok=True)

# Connect to the database
conn = sqlite3.connect(DB_PATH)
df = pd.read_sql_query("""
    SELECT t.*, u.email 
    FROM transactions t 
    JOIN users u ON t.user_id = u.id
""", conn)
conn.close()

# Extract user type from email (e.g., student1@example.com → student)
df['user_type'] = df['email'].str.extract(r'([a-z]+)\d*@')
df['date'] = pd.to_datetime(df['date'])

print(f"✅ Loaded {len(df)} transactions from {df['user_id'].nunique()} users")

# 1. 📊 Overall balance (income vs expenses)
income_total = df[df['type'] == 'income']['amount'].sum()
expense_total = df[df['type'] == 'expense']['amount'].sum()

plt.figure(figsize=(8, 5))
plt.bar(['Income', 'Expenses'], [income_total, expense_total], 
        color=['#2ecc71', '#e74c3c'])
plt.title('Total Income vs Expenses', fontsize=14, weight='bold')
plt.ylabel('Amount (₽)')
for i, v in enumerate([income_total, expense_total]):
    plt.text(i, v + v*0.01, f"{v:,.0f} ₽", ha='center', fontweight='bold')
plt.tight_layout()
plt.savefig(f'{OUTPUT_DIR}/1_overall_balance.png', dpi=150, bbox_inches='tight')
plt.show()

# 2. 🥧 Expenses by category (top 6)
top_expenses = df[df['type'] == 'expense'].groupby('category')['amount'].sum().sort_values(ascending=False).head(6)

plt.figure(figsize=(9, 6))
colors = plt.cm.viridis(range(len(top_expenses)))
plt.pie(top_expenses.values, labels=top_expenses.index, autopct='%1.1f%%', colors=colors)
plt.title('Expense Distribution by Category', fontsize=14, weight='bold')
plt.tight_layout()
plt.savefig(f'{OUTPUT_DIR}/2_expenses_pie.png', dpi=150, bbox_inches='tight')
plt.show()

# 3. 👥 Comparison by user type
group_stats = df.groupby(['user_type', 'type'])['amount'].sum().unstack(fill_value=0)
group_stats['Balance'] = group_stats.get('income', 0) - group_stats.get('expense', 0)

fig, ax = plt.subplots(figsize=(10, 6))
group_stats[['income', 'expense']].plot(kind='bar', ax=ax, color=['#2ecc71', '#e74c3c'])
ax.set_title('Income and Expenses by User Type', fontsize=14, weight='bold')
ax.set_ylabel('Amount (₽)')
ax.legend(['Income', 'Expenses'])
plt.xticks(rotation=0)
plt.tight_layout()
plt.savefig(f'{OUTPUT_DIR}/3_user_groups.png', dpi=150, bbox_inches='tight')
plt.show()

# 4. 📈 Cumulative daily balance over time
daily = df.groupby(['date', 'type'])['amount'].sum().unstack(fill_value=0)
daily['balance'] = daily.get('income', 0) - daily.get('expense', 0)
daily['cumulative'] = daily['balance'].cumsum()

plt.figure(figsize=(12, 5))
plt.plot(daily.index, daily['cumulative'], color='#4361ee', linewidth=2.5)
plt.title('Cumulative Financial Balance (90 Days)', fontsize=14, weight='bold')
plt.ylabel('Balance (₽)')
plt.grid(alpha=0.3)
plt.tight_layout()
plt.savefig(f'{OUTPUT_DIR}/4_cumulative_balance.png', dpi=150, bbox_inches='tight')
plt.show()

# 5. 🔥 Top 5 largest transactions
top_transactions = df.nlargest(5, 'amount')
print("\n🔥 Top 5 Largest Transactions:")
print(top_transactions[['email', 'type', 'category', 'amount', 'date']])

# Save summary data
group_stats.to_csv(f'{OUTPUT_DIR}/user_group_summary.csv')
print(f"\n✅ All charts and data saved to: {OUTPUT_DIR}/")