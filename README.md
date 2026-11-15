# 🛍️ ShopEase – Online Shopping Website

**ShopEase** is a PHP and MySQL-based e-commerce web application designed to provide users with a simple, convenient, and user-friendly online shopping experience.

Customers can browse products, search for items, add products to their cart, manage their wishlist, and place orders. The website also includes an admin dashboard for managing products and customer orders.

🌐 **Live Website:** [https://chavibansal.freedev.app](https://chavibansal.freedev.app)

---

## 📌 Project Overview

ShopEase is an online shopping platform developed using PHP, MySQL, HTML, CSS, and JavaScript.

The main objective of this project is to provide a smooth online shopping experience while allowing administrators to manage products, users, and orders efficiently.

## ✨ Features

### 👤 User Features

- User Registration and Login
- Secure Password Hashing
- Browse Products
- Search Products
- Filter and Sort Products
- Product Details Page
- Add Products to Cart
- Remove Products from Cart
- Wishlist Management
- Checkout System
- Cash on Delivery Option
- Order History
- Contact Form

### 🔐 Admin Features

- Admin Dashboard
- Product Management
- Add New Products
- Edit Existing Products
- Delete Products
- Upload Product Images
- View Customer Orders
- Manage Order Status
- View Order Details

## 🛠️ Technologies Used

| Technology   | Purpose                           |
| ------------ | --------------------------------- |
| HTML5        | Website Structure                 |
| CSS3         | Styling and Layout                |
| JavaScript   | Client-side Interactions          |
| PHP          | Backend Development               |
| MySQL        | Database Management               |
| XAMPP        | Local Development Environment     |
| InfinityFree | Web Hosting                       |
| Git & GitHub | Version Control and Collaboration |

## 📂 Project Structure

```text
ShopEase/
│
├── admin/
│   ├── index.php
│   ├── products.php
│   ├── orders.php
│   └── uploads/
│
├── assets/
│   ├── style.css
│   └── app.js
│
├── includes/
│   ├── header.php
│   └── footer.php
│
├── config.php
├── index.php
├── product.php
├── cart.php
├── cart_action.php
├── wishlist.php
├── checkout.php
├── login.php
├── register.php
├── logout.php
├── account.php
├── orders.php
├── contact.php
└── database.sql
```

## ⚙️ Installation and Setup

Follow these steps to run ShopEase on your local computer.

### Step 1: Clone the Repository

```bash
git clone YOUR_GITHUB_REPOSITORY_URL
```

### Step 2: Move Project Folder

Move the project folder into the XAMPP `htdocs` directory.

```text
C:\xampp\htdocs\
```

### Step 3: Start XAMPP

Start the following services:

- Apache
- MySQL

### Step 4: Create Database

1. Open `http://localhost/phpmyadmin`
2. Create a database named `shopease`.
3. Select the database.
4. Import the shopease.sql file.

### Step 5: Configure Database

Update the database credentials in `config.php` according to your local MySQL configuration.

### Step 6: Run the Project

Open your browser and visit:

```text
http://localhost/ShopEase_Fresh/
```

## 🗄️ Database Structure

ShopEase uses MySQL for storing application data.

Main database tables:

- `users` – Stores user account information.
- `products` – Stores product details.
- `orders` – Stores customer order information.
- `order_items` – Stores individual products in orders.
- `messages` – Stores contact form messages.

## 🌍 Live Deployment

ShopEase is deployed using InfinityFree hosting.

**Live Website:** [https://chavibansal.freedev.app](https://chavibansal.freedev.app)

## 👥 Project Team

| Team Member | Role                           | Responsibilities                                                                         |
| ----------- | ------------------------------ | ---------------------------------------------------------------------------------------- |
| Chavi       | Main Admin & Backend Developer | Backend development, user authentication, admin dashboard and overall project management |
| Riddhi      | Backend Developer              | Cart, Checkout, Wishlist and Contact Modules                                             |
| Suyash      | Frontend Developer             | Website UI, homepage, product pages and styling                                          |
| Vivek       | Database Manager               | Database design, MySQL tables and database management                                    |
| Ayush       | Frontend Developer             | Frontend development and user interface                                                  |

## 🔮 Future Enhancements

- Online Payment Gateway Integration
- Product Reviews and Ratings
- Order Tracking System
- Email Notifications
- Improved Security Features
- Enhanced Responsive Design

## 🔒 Security

- Passwords are stored using secure password hashing.
- User inputs are validated.
- CSRF protection is implemented for forms.
- Uploaded product images are validated.
- Database credentials should never be committed to a public repository.

## 📄 License

This project is developed for educational purposes.

---

## ⭐ Thank You for Visiting ShopEase!

**ShopEase – Making Online Shopping Easier!** 🛒

