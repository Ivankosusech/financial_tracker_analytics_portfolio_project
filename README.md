# 💰 Finance Tracker — 3-in-1 Portfolio Project

![Dashboard](screenshots/dashboard-en.png)

A full-stack personal finance tracker built to demonstrate **three core professional roles in one cohesive project**:

- 👨‍💻 **Web Development**: PHP, Bootstrap, SQLite, Docker  
- 📊 **Data Analysis**: Python (pandas, matplotlib) — user behavior, income vs. expense trends  
- 🧪 **QA Testing**: Manual test cases, bug reports, and validation scenarios  

> 🔒 All data is stored locally. No external services or cloud dependencies.

---

## 🌍 Features

- ✅ **Multi-language UI**: Russian / English / Korean  
- 💱 **Auto currency formatting**: ₽ / $ / ₩ based on selected language  
- ➕ **Track income & expenses** with categories and comments  
- 📈 **Real-time dashboard**: daily/weekly balance, top spending categories  
- 👥 **Multi-user support**: isolated data per user  
- 🐳 **Dockerized**: runs in a container with one command  
- 📊 **Analytics-ready**: SQLite database compatible with Python (pandas, Jupyter)

---

## 🛠 Tech Stack

| Layer        | Technologies                          |
|--------------|---------------------------------------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, Vanilla JS |
| **Backend**  | PHP 8.3, Apache                       |
| **Database** | SQLite (file-based)                   |
| **DevOps**   | Docker, docker-compose                |
| **Analytics**| Python, pandas, matplotlib, seaborn   |
| **Testing**  | Manual QA, Selenium (planned)         |

---

## ▶️ How to Run Locally

### Prerequisites
- [Docker](https://www.docker.com/products/docker-desktop) installed

### Steps
```bash
# 1. Clone the repository
git clone https://github.com/Ivankosusech/financial_tracker_web_portfolio_project.git
cd financial_tracker_web_portfolio_project

# 2. Start the app
docker compose up --build

# 3. Open in your browser
http://localhost:8080

# 4. 📊 Data Analysis
The project includes a Python analytics module to explore user behavior:

Generate test data (16 users, ~3600 transactions)

```bash
docker compose down
python3 generate_test_data.py

# 5. Run analysis

```bash
cd analytics
pip3 install pandas matplotlib seaborn
python3 analyze.py

Output
Charts in analytics/output/:
1_overall_balance.png — total income vs expenses
2_expenses_pie.png — spending by category
3_user_groups.png — comparison by user type (student, freelancer, etc.)
4_cumulative_balance.png — 90-day balance trend
Summary CSV: user_group_summary.csv

# 6. 📁 Project Structure
.
├── public/               # Web application (PHP)
│   ├── index.php         # Landing page
│   ├── auth.php          # Login / registration
│   ├── dashboard.php     # Main finance dashboard
│   ├── lang.php          # Multi-language support
│   └── finance.db        # SQLite database
├── analytics/
│   ├── analyze.py        # Data analysis script
│   └── output/           # Generated charts & reports
├── generate_test_data.py # Multi-user test data generator
├── docker-compose.yml
├── Dockerfile
└── README.md