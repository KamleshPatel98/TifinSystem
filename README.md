Bilkul. Aapke screenshot ke basis par `resources/views` ka structure README me add karke **complete updated README.md** neeche de raha hoon.

Aap isse directly apni `README.md` file me replace kar sakte hain.

```
# 🍱 Tiffin Management System

A web-based **Tiffin Management System** built with **Laravel 12** to manage tiffin service operations, customers, vendors, subscription plans, payments, transactions, leaves, ledgers, and location-based data.

The system provides an admin panel for managing day-to-day tiffin business operations in a centralized and organized way.

---

## 🚀 Project Overview

**Tiffin Management System** is designed for tiffin service providers to manage their complete business workflow from a single web application.

The system helps manage:

* Customer records
* Tiffin plans
* Customer subscriptions
* Payments
* Vendors
* Vendor joining/resignation requests
* Customer addresses
* States, cities and areas
* Leave management
* Business transactions
* Customer/vendor ledgers
* Website settings
* Dashboard and authentication

---

# ✨ Features

## 🔐 Authentication

* Admin login
* Secure authentication using Laravel authentication
* Change password
* Logout
* Protected admin panel
* Super Admin authorization

---

## 📊 Dashboard

The admin dashboard provides a centralized view of the application and its important modules.

It provides quick access to:

* Customers
* Vendors
* Plans
* Subscriptions
* Payments
* Transactions
* Leaves
* Ledgers
* Location management
* Website settings

---

# 👨‍💼 Customer Management

Complete customer management functionality.

### Features

* Add customer
* View customer details
* Edit customer
* Delete customer
* Search customer
* Manage customer address
* Assign tiffin plans
* Manage customer payments
* Manage customer subscriptions
* Update subscription status

---

# 🏪 Vendor Management

Vendor management is available for authorized **Super Admin** users.

### Features

* Add vendor
* View vendors
* Edit vendor
* Delete vendor
* Vendor joining requests
* Vendor resignation requests
* Suspended vendor list
* Vendor status management

---

# 📋 Tiffin Plan Management

Manage different tiffin plans offered by the business.

### Features

* Create plan
* View plans
* Edit plan
* Delete plan
* Manage plan details
* Assign plans to customers

---

# 🔄 Subscription Management

Manage customer subscriptions from the admin panel.

### Features

* View subscriptions
* Assign plans to customers
* Subscription status management
* Subscription deletion
* Customer-wise subscription management

---

# 💰 Payment Management

The payment module helps manage customer payment records.

### Features

* Record customer payments
* View payment records
* Customer-wise payment management
* Payment tracking

---

# 💳 Transaction Management

The system provides transaction management for tracking business financial activities.

### Features

* Add transaction
* View transactions
* Edit transaction
* Delete transaction
* Transaction tracking

---

# 📒 Ledger Management

The ledger module provides a consolidated view of financial records.

### Features

* View ledger
* Track financial entries
* Generate ledger PDF
* Maintain transaction history

### PDF Export

The application uses **Laravel DomPDF** for generating ledger PDF documents.

---

# 🏖️ Leave Management

Manage leave records through the admin panel.

### Features

* Add leave
* View leaves
* Edit leave
* Delete leave
* Leave record management

---

# 🌍 Location Management

The application provides hierarchical location management.

### Location Structure
```

Country ↓ State ↓ City ↓ Area

```

### Modules

* State Management
* City Management
* Area Management
* Dynamic location dropdowns

The application also provides dropdown endpoints for:

* Country
* State
* City
* Area

---

# ⚙️ Website Settings

The admin can manage website-related information through the settings section.

### Features

* View website data
* Update website data
* Manage basic application information

---

# 🗂️ Views Structure

The Laravel Blade views are organized inside the `resources/views` directory.

The current application uses a modular Blade view structure for authentication, dashboard, customers, vendors, plans, subscriptions, payments, transactions, leaves, ledgers, locations, and settings.
```

resources/ └── views/ │ ├── components/ │ ├── alert.blade.php │ ├── datepicker.blade.php │ └── show-image.blade.php │ ├── dropdowns/ │ ├── area.blade.php │ ├── city.blade.php │ └── state.blade.php │ ├── includes/ │ ├── approved-status.blade.php │ ├── geography-create-ajax.blade.php │ └── is-active.blade.php │ ├── layouts/ │ ├── auth.blade.php │ └── panel.blade.php │ ├── panel/ │ │ │ ├── auth/ │ │ └── ... │ │ │ ├── customers/ │ │ └── ... │ │ │ ├── geography/ │ │ └── ... │ │ │ ├── leaves/ │ │ └── ... │ │ │ ├── ledgers/ │ │ └── ... │ │ │ ├── payments/ │ │ └── ... │ │ │ ├── plans/ │ │ └── ... │ │ │ ├── settings/ │ │ └── ... │ │ │ ├── subscriptions/ │ │ └── ... │ │ │ ├── transactions/ │ │ └── ... │ │ │ └── vendors/ │ └── ... │ └── dashboard.blade.php

```

### Views Directory Description
```

| Directory / File | Description |
| --- | --- |
| `components/` | Reusable Blade components |
| `components/alert.blade.php` | Common alert/message component |
| `components/datepicker.blade.php` | Date picker component |
| `components/show-image.blade.php` | Image display component |
| `dropdowns/` | Reusable location dropdown views |
| `dropdowns/area.blade.php` | Area dropdown |
| `dropdowns/city.blade.php` | City dropdown |
| `dropdowns/state.blade.php` | State dropdown |
| `includes/` | Reusable Blade include files |
| `includes/approved-status.blade.php` | Approved status UI |
| `includes/geography-create-ajax.blade.php` | AJAX-based geography functionality |
| `includes/is-active.blade.php` | Active/inactive status UI |
| `layouts/` | Common application layouts |
| `layouts/auth.blade.php` | Authentication layout |
| `layouts/panel.blade.php` | Admin panel layout |
| `panel/` | Main admin panel views |
| `panel/auth/` | Authentication-related panel views |
| `panel/customers/` | Customer management views |
| `panel/geography/` | State, city and area management views |
| `panel/leaves/` | Leave management views |
| `panel/ledgers/` | Ledger and PDF-related views |
| `panel/payments/` | Payment management views |
| `panel/plans/` | Tiffin plan management views |
| `panel/settings/` | Website/application settings views |
| `panel/subscriptions/` | Subscription management views |
| `panel/transactions/` | Transaction management views |
| `panel/vendors/` | Vendor management views |
| `dashboard.blade.php` | Main admin dashboard |

### Blade View Architecture

The views follow a reusable layout-based structure:

```
                    ┌──────────────────────┐
                    │   layouts/panel.php  │
                    │   Admin Panel Layout  │
                    └──────────┬───────────┘
                               │
              ┌────────────────┼────────────────┐
              │                │                │
              ▼                ▼                ▼
        Dashboard          Components        Includes
              │                │                │
              └────────────────┼────────────────┘
                               │
                               ▼
                         Panel Modules
                               │
       ┌───────────────┬───────┼────────┬───────────────┐
       ▼               ▼       ▼        ▼               ▼
   Customers        Vendors   Plans   Payments     Subscriptions
       │               │       │        │               │
       └───────────────┴───────┼────────┴───────────────┘
                               │
             ┌─────────────────┼──────────────────┐
             ▼                 ▼                  ▼
        Transactions        Ledgers           Geography
                                                   │
                                          ┌────────┼────────┐
                                          ▼        ▼        ▼
                                        State     City     Area
```

---

# 🛠️ Technology Stack

## Backend

- PHP 8.2+
- Laravel 12
- Laravel Eloquent ORM
- Laravel Blade
- Laravel Authentication

## Frontend

- HTML5
- CSS3
- JavaScript
- Bootstrap / Blade UI
- Vite
- Tailwind CSS

## Database

- MySQL

## Additional Technologies

- AJAX
- Axios
- Laravel DomPDF
- Vite
- Tailwind CSS

---

# 📦 Packages & Dependencies

The project is built on Laravel 12 and PHP 8.2+.

Important backend dependency:

```
barryvdh/laravel-dompdf
```

It is used for generating PDF documents such as ledger reports.

Frontend/build dependencies include:

```
Vite
Laravel Vite Plugin
Axios
Tailwind CSS
Concurrently
```

---

# 🏗️ Project Structure

```
TifinSystem/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AreaController.php
│   │   │   ├── AuthController.php
│   │   │   ├── CityController.php
│   │   │   ├── CustomerController.php
│   │   │   ├── DropdownController.php
│   │   │   ├── LeaveController.php
│   │   │   ├── LedgerController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── PlanController.php
│   │   │   ├── SettingController.php
│   │   │   ├── StateController.php
│   │   │   ├── SubscriptionController.php
│   │   │   ├── TransactionController.php
│   │   │   └── VendorController.php
│   │   │
│   │   └── Middleware/
│   │
│   ├── Models/
│   └── helper.php
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── css/
│   ├── js/
│   └── images/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── components/
│       ├── dropdowns/
│       ├── includes/
│       ├── layouts/
│       ├── panel/
│       │   ├── auth/
│       │   ├── customers/
│       │   ├── geography/
│       │   ├── leaves/
│       │   ├── ledgers/
│       │   ├── payments/
│       │   ├── plans/
│       │   ├── settings/
│       │   ├── subscriptions/
│       │   ├── transactions/
│       │   └── vendors/
│       └── dashboard.blade.php
│
├── routes/
│   ├── web.php
│   └── console.php
│
├── storage/
│
├── tests/
│
├── vendor/
│
├── .env.example
├── artisan
├── composer.json
├── package.json
├── phpunit.xml
├── vite.config.js
└── README.md
```

---

# 🔗 Application Modules

The main application modules are organized as follows:

| Module | Description |
| --- | --- |
| Authentication | Login, logout and password management |
| Dashboard | Admin dashboard |
| Customers | Customer CRUD and related operations |
| Vendors | Vendor management |
| Plans | Tiffin plan management |
| Subscriptions | Customer subscription management |
| Payments | Payment records |
| Leaves | Leave management |
| Transactions | Business transaction management |
| Ledgers | Financial ledger and PDF |
| States | State management |
| Cities | City management |
| Areas | Area management |
| Settings | Website/application settings |

---

# 🔐 Authorization

The application uses middleware-based authorization.

Normal authenticated users can access the main panel, while vendor management functionality is protected using the **Super Admin** middleware.

Example:

```
Route::middleware(['auth'])->prefix('panel')->group(function () {

    // Application modules

    Route::middleware(['superadmin'])->group(function () {

        Route::resource('vendors', VendorController::class);

    });

});
```

---

# ⚙️ Installation

## 1\. Clone Repository

```
git clone https://github.com/KamleshPatel98/TifinSystem.git
```

Move into the project directory:

```
cd TifinSystem
```

---

## 2\. Install PHP Dependencies

```
composer install
```

---

## 3\. Create Environment File

Copy `.env.example` to `.env`:

```
cp .env.example .env
```

For Windows:

```
copy .env.example .env
```

---

## 4\. Generate Application Key

```
php artisan key:generate
```

---

## 5\. Configure Database

Open the `.env` file and configure your MySQL database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tiffin_system
DB_USERNAME=root
DB_PASSWORD=
```

Create the database in MySQL:

```
CREATE DATABASE tiffin_system;
```

---

## 6\. Run Database Migrations

```
php artisan migrate
```

If seeders are available/configured:

```
php artisan db:seed
```

Or:

```
php artisan migrate --seed
```

---

## 7\. Install Node Dependencies

```
npm install
```

---

## 8\. Start Vite Development Server

```
npm run dev
```

---

## 9\. Start Laravel Server

Open another terminal:

```
php artisan serve
```

The application will generally be available at:

```
http://127.0.0.1:8000
```

---

# 🖥️ Local Development

For development, run:

### Terminal 1

```
php artisan serve
```

### Terminal 2

```
npm run dev
```

Then open:

```
http://127.0.0.1:8000
```

---

# 🗃️ Database

The application uses a relational database structure to manage:

```
Users / Authentication
        │
        ├── Customers
        │      ├── Addresses
        │      ├── Plans
        │      ├── Subscriptions
        │      └── Payments
        │
        ├── Vendors
        │
        ├── Transactions
        │
        ├── Ledgers
        │
        └── Location
               ├── States
               ├── Cities
               └── Areas
```

---

# 🔄 Application Workflow

```
Admin Login
     │
     ▼
Dashboard
     │
     ├── Manage Customers
     │      │
     │      ├── Customer Address
     │      ├── Assign Plan
     │      ├── Subscription
     │      └── Payment
     │
     ├── Manage Vendors
     │
     ├── Manage Plans
     │
     ├── Manage Subscriptions
     │
     ├── Manage Payments
     │
     ├── Manage Leaves
     │
     ├── Manage Transactions
     │
     ├── View Ledger
     │      └── Generate PDF
     │
     └── Manage Locations
            ├── State
            ├── City
            └── Area
```

---

# 📡 Main Route Groups

The application uses Laravel resource routes for several CRUD modules.

Examples:

```
/panel/states
/panel/cities
/panel/areas
/panel/vendors
/panel/customers
/panel/plans
/panel/leaves
/panel/transactions
```

Additional modules include:

```
/panel/subscriptions
/panel/payments
/panel/ledgers
/panel/ledgers/pdf
```

---

# 📄 PDF Generation

Ledger PDF reports can be generated using:

```
/panel/ledgers/pdf
```

The application uses:

```
barryvdh/laravel-dompdf
```

for PDF generation.

---

# 🔎 Customer Search

The customer module provides a dedicated customer search functionality.

This can be used to quickly locate customer records without manually browsing the complete customer list.

---

# ⚡ Dynamic Dropdowns

The system provides dynamic location dropdown functionality for:

```
Country
State
City
Area
```

This allows location information to be selected in a hierarchical manner.

---

# 🧪 Testing

Run Laravel tests using:

```
php artisan test
```

or:

```
vendor/bin/phpunit
```

---

# 🚀 Production Build

Build frontend assets:

```
npm run build
```

Optimize Laravel configuration:

```
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

# 🔧 Useful Artisan Commands

Clear application cache:

```
php artisan optimize:clear
```

Run migrations:

```
php artisan migrate
```

Create migration:

```
php artisan make:migration create_example_table
```

Create model:

```
php artisan make:model Example -m
```

Create controller:

```
php artisan make:controller ExampleController
```

---

# 📌 Future Enhancements

Possible future improvements include:

- Customer mobile application
- Online tiffin ordering
- Online payment gateway
- Automatic subscription renewal
- WhatsApp notifications
- SMS notifications
- Daily delivery management
- Tiffin delivery tracking
- Expense management
- Profit & loss reports
- Advanced dashboard analytics
- Customer notifications
- Vendor performance reports
- Monthly/yearly business reports

---

# 👨‍💻 Developer

**Kamlesh Patel**

### GitHub

GitHub Profile

### Project Repository

TifinSystem

---

# 📜 License

This project is open-sourced software licensed under the **MIT License**.

---

# ⭐ Support

If you find this project useful, consider giving the repository a ⭐ on GitHub.

---

# 📸 Project Screenshots

Add screenshots here to showcase the application:

```
docs/
├── dashboard.png
├── customers.png
├── plans.png
├── subscriptions.png
├── payments.png
├── transactions.png
└── ledger.png
```

Example:

```
![Dashboard](docs/dashboard.png)

![Customer Management](docs/customers.png)

![Ledger](docs/ledger.png)
```

---

# 📚 Technologies Summary

```
PHP 8.2+
Laravel 12
MySQL
Blade
HTML5
CSS3
JavaScript
Bootstrap
AJAX
Axios
Vite
Tailwind CSS
Laravel DomPDF
```

---

**Tiffin Management System — Simplifying Tiffin Business Management. 🍱**

```

### Views structure me kya add kiya hai

Screenshot ke according specifically ye sections include kiye gaye hain:
```

resources/views/ ├── components/ ├── dropdowns/ ├── includes/ ├── layouts/ ├── panel/ │ ├── auth/ │ ├── customers/ │ ├── geography/ │ ├── leaves/ │ ├── ledgers/ │ ├── payments/ │ ├── plans/ │ ├── settings/ │ ├── subscriptions/ │ ├── transactions/ │ └── vendors/ └── dashboard.blade.php

```

Aur `components`, `dropdowns`, `includes`, `layouts` ke visible files bhi README me document kar diye hain.
```