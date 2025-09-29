# 💰 Finance Tracker — 3-in-1 Portfolio Project

![Demo](screenshots/dashboard-en.png)

A full-stack personal finance tracker built to showcase **three key roles in one project**:

- 👨‍💻 **Web Developer**: PHP, HTML/CSS, Bootstrap, SQLite, Docker  
- 📊 **Data Analyst**: Python (pandas, matplotlib) — income vs. expense insights  
- 🧪 **QA Tester**: Manual + automated test cases, bug reports  

Live demo: **Run locally with Docker** (see instructions below).

---

## 🌍 Features

- ✅ **Multi-language support**: Russian / English / Korean
- 💱 **Auto currency formatting**: ₽ / $ / ₩ based on selected language
- ➕ **Track income & expenses** with categories and comments
- 📈 **Real-time statistics**: daily/weekly balance, top categories
- 🔒 **Secure authentication**: password hashing, session management
- 📱 **Responsive UI**: works on mobile and desktop
- 🐳 **Fully containerized**: runs in Docker with one command

---

## 🛠 Tech Stack

- **Frontend**: Bootstrap 5, vanilla JavaScript
- **Backend**: PHP 8.3
- **Database**: SQLite (file-based, persistent)
- **Deployment**: Docker, docker-compose
- **Analytics**: Python, pandas, matplotlib *(coming soon)*
- **Testing**: Manual test cases, Selenium *(planned)*

---

## ▶️ How to Run Locally

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ivankosusech/financial_tracker_web_portfolio_project.git
   cd financial_tracker_web_portfolio_project

2. **Build and start with Docker**
    ```bash
    docker compose up --build

3. **Open in your browser**
    http://localhost:8080

4. **Project Structure**
    public/          # Web application (PHP + SQLite)
    ├── index.php    # Landing page
    ├── auth.php     # Login / Register / Forgot password
    ├── dashboard.php# Main finance dashboard
    ├── logout.php   # Session destroy
    ├── lang.php     # Multi-language support (RU/EN/KO)
    └── finance.db   # Database (auto-created)