# Joaz Hair Products E-commerce Platform

A modern e-commerce platform built with Laravel 12 for selling women's hair products. Features include Paystack payment integration, admin and customer roles, order management, and delivery tracking.

## 🚀 Features

-   **User Management**: Admin and Customer roles with Spatie Laravel Permission
-   **Product Management**: Categories, products with images, inventory tracking
-   **Order System**: Complete order lifecycle with status tracking
-   **Payment Integration**: Paystack payment gateway (NGN & USD)
-   **Delivery System**: Pickup and delivery options with tracking
-   **Voucher System**: Discount codes and promotional offers
-   **Responsive Design**: Mobile-friendly admin and customer interfaces

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

-   PHP 8.2 or higher
-   Composer
-   MySQL/PostgreSQL
-   Node.js & NPM
-   Git

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd joaz
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

Edit your `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=joaz
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Create Database

Create a new database named `joaz`:

```sql
CREATE DATABASE joaz;
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed the Database

```bash
php artisan db:seed
```

### 8. Install Frontend Dependencies

```bash
npm install
```

### 9. Build Assets

```bash
npm run build
```

### 10. Storage Setup

```bash
php artisan storage:link
```

## 🔧 Configuration

### Paystack Configuration

Add your Paystack credentials to `.env`:

```env
PAYSTACK_PUBLIC_KEY=your_public_key
PAYSTACK_SECRET_KEY=your_secret_key
PAYSTACK_WEBHOOK_SECRET=your_webhook_secret
```

### Mail Configuration (Optional)

Configure your mail settings in `.env` for order notifications.

## 👥 Default Users

After seeding, the following users are created:

### Admin User

-   **Email**: `admin@example.com`
-   **Password**: `password`
-   **Access**: `/admin/login`

### Customer User

-   **Email**: `customer@example.com`
-   **Password**: `password`

## 🚀 Running the Application

### Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

### Admin Panel

Visit: `http://localhost:8000/admin/login`

### Asset Compilation (Development)

```bash
npm run dev
```

## 📁 Project Structure

```
joaz/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin controllers
│   │   ├── Customer/       # Customer controllers
│   │   └── PaymentController.php
│   ├── Models/             # Eloquent models
│   └── Services/           # PaymentService
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   └── views/
│       ├── admin/         # Admin views
│       ├── customer/      # Customer views
│       └── layouts/       # Layout templates
└── routes/
    └── web.php           # Web routes
```

## 🔐 Authentication & Authorization

-   **Admin Routes**: Protected by `role:admin` middleware
-   **Customer Routes**: Protected by `role:customer` middleware
-   **Public Routes**: Shop, product listings, payment callbacks

## 💳 Payment Integration

The platform uses Paystack for payment processing:

-   Supports NGN and USD currencies
-   Webhook handling for payment verification
-   Transaction logging and management

## 📱 Admin Features

-   **Dashboard**: Analytics and recent orders
-   **Products**: CRUD operations with image management
-   **Categories**: Product categorization
-   **Orders**: Order management and status updates
-   **Customers**: Customer management and order history
-   **Transactions**: Payment transaction logs
-   **Vouchers**: Discount code management

## 🛍️ Customer Features

-   **Shop**: Browse products by category
-   **Cart**: Add, update, and remove items
-   **Checkout**: Address selection and payment
-   **Orders**: Order history and tracking
-   **Profile**: Account management

## 🧪 Testing

```bash
php artisan test
```

## 📝 API Documentation

The platform includes RESTful APIs for:

-   Product management
-   Order processing
-   Payment integration
-   User authentication

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This project is licensed under the MIT License.

## 🆘 Support

For support, email support@joaz.com or create an issue in the repository.

---

**Happy Coding! 🎉**
