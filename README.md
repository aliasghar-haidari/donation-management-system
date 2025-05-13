# 🌍 Donation Management System for NGOs

The **Donation Management System** is a web-based Laravel application designed to empower NGOs and non-profits with transparent donation tracking, fund allocation, and financial reporting using **double-entry accounting principles**.

---

## ✨ Key Highlights

-   🔐 Role-based authentication and access control
-   💰 Double-entry accounting (debit/credit logic)
-   📊 Visual dashboard with Chart.js
-   📄 Exportable financial reports (PDF)
-   📦 Clean, modular Laravel structure (MVC, Eloquent, Services)

---

## 📌 Features

### ✅ User Management

-   Role-based access: `Admin`, `Accountant`, `Staff`
-   Secure login via Laravel Auth
-   Middleware-based permission checks

### 🙋 Donor Management

-   CRUD for donors
-   Optional anonymous donations
-   Donation history per donor

### 💸 Donation Management

-   Record donations with category (e.g. Education, Medical)
-   Accept multiple payment methods: Cash, Bank, Mobile
-   Auto-generate double-entry records:
    -   **Debit**: Bank
    -   **Credit**: Donation Revenue

### 🏷️ Fund Allocation

-   Allocate donations to programs (e.g. Scholarships, Clinics)
-   Track usage of received funds
-   Accounting entries auto-created:
    -   **Debit**: Donation Revenue
    -   **Credit**: Program Expense

### 📈 Reports & Dashboard

-   Trial balance
-   General ledger per account
-   Donations summary
-   Fund allocation summary
-   Charts with Chart.js
-   PDF export with DomPDF

### 📬 Notifications (Email)

-   Notify donors with receipt and message

---

## 🧪 Tech Stack

| Layer            | Technology                               |
| ---------------- | ---------------------------------------- |
| **Backend**      | Laravel 12, PHP 8.3                      |
| **Database**     | PostgreSQL                               |
| **Visuals**      | Chart.js                                 |
| **PDF Export**   | DomPDF                                   |
| **Auth**         | Laravel Sanctum                          |
| **Architecture** | MVC + Service Layer                      |
| **Security**     | CSRF, Role-based Gates, Input Validation |

---

## 📦 Installation

### ✅ Prerequisites

-   PHP >= 8.2
-   Composer
-   PostgreSQL
-   Node.js (for assets, optional)
-   Git

### 🛠 Setup Steps

```bash
# Clone the repository
git clone https://github.com/aliasghar-haidari/donation-management-system.git
cd donation-management-system

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
# Update .env with your DB credentials

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed

# Compile assets (optional)
npm run dev

# Start local dev server
php artisan serve
```
