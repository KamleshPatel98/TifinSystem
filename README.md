# 🍱 Tiffin Management System

A web-based **Tiffin Management System** built with **Laravel 12** for managing tiffin service operations, customers, vendors, plans, subscriptions, payments, transactions, and business records.

The system provides a centralized admin panel to manage daily tiffin business operations efficiently.

---

## 🚀 Features

### 🔐 Authentication & Authorization

* Admin authentication
* Secure login/logout
* Password management
* Role-based access control
* Super Admin authorization

### 👨‍💼 Customer Management

* Customer registration and management
* Customer profile and address management
* Customer search
* Plan assignment
* Subscription management
* Payment tracking

### 🏪 Vendor Management

* Vendor management
* Vendor joining requests
* Vendor resignation requests
* Vendor status management
* Suspended vendor management

### 📋 Tiffin Plan Management

* Create and manage tiffin plans
* Edit and delete plans
* Assign plans to customers

### 🔄 Subscription Management

* Customer subscriptions
* Plan assignment
* Subscription status management
* Customer-wise subscription records

### 💰 Payment & Transaction Management

* Customer payment records
* Business transaction management
* Transaction history
* Financial record tracking

### 📒 Ledger Management

* Customer/vendor ledger management
* Transaction-based ledger
* Ledger history
* PDF ledger generation

### 🏖️ Leave Management

* Create leave records
* Edit and delete leaves
* Leave tracking

### 🌍 Location Management

* State management
* City management
* Area management
* Dynamic location selection

### ⚙️ Website Settings

* Manage website/application settings
* Update basic application information

---

## 🛠️ Technology Stack

### Backend

* PHP 8.2+
* Laravel 12
* Laravel Eloquent ORM
* Laravel Blade

### Frontend

* HTML5
* CSS3
* JavaScript
* Tailwind CSS
* Vite
* AJAX
* Axios

### Database

* MySQL

### Additional

* Laravel DomPDF
* Authentication & Middleware
* RESTful Resource Controllers

---

## 🏗️ Project Structure

```text
TifinSystem/
├── app/
│   ├── Http/
│   ├── Models/
│   └── helper.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── public/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
├── storage/
├── tests/
├── .env.example
├── composer.json
├── package.json
└── README.md
---

## 📊 Application Workflow

```text
Admin Login
     ↓
Dashboard
     ↓
Customer Management
     ├── Plans
     ├── Subscriptions
     └── Payments
     
Vendor Management
     ↓
Transactions
     ↓
Ledger & Reports
     
Location Management
     ├── State
     ├── City
     └── Area
```

---

## 📄 PDF Reports

The system uses **Laravel DomPDF** for generating ledger PDF reports.

---

## 🔮 Future Enhancements

* Online payment integration
* WhatsApp/SMS notifications
* Tiffin delivery management
* Customer mobile application
* Expense management
* Business analytics
* Automated subscription renewal

---

## 👨‍💻 Developer

**Kamlesh Patel**

Laravel Developer | API-Driven Web & Mobile Applications

* GitHub: [KamleshPatel98](https://github.com/KamleshPatel98)
* Project: [TifinSystem](https://github.com/KamleshPatel98/TifinSystem)


---

⭐ If you find this project useful, consider giving it a star on GitHub.

**Tiffin Management System — Simplifying Tiffin Business Management. 🍱**
