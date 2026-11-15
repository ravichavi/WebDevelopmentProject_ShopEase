
<?php
require_once __DIR__ . '/../config.php';

// Admin access protection
if (!current_user() || current_user()['role'] !== 'admin') {
    http_response_code(403);
    exit('Access denied. Admin login required.');
}

// Dashboard statistics
$totalProducts = (int)$pdo->query(
    "SELECT COUNT(*) FROM products"
)->fetchColumn();

$totalOrders = (int)$pdo->query(
    "SELECT COUNT(*) FROM orders"
)->fetchColumn();

$totalUsers = (int)$pdo->query(
    "SELECT COUNT(*) FROM users"
)->fetchColumn();

$totalMessages = (int)$pdo->query(
    "SELECT COUNT(*) FROM messages"
)->fetchColumn();

$recentOrders = $pdo->query(
    "SELECT orders.*, users.name AS user_name
     FROM orders
     LEFT JOIN users ON orders.user_id = users.id
     ORDER BY orders.id DESC LIMIT 5"
)->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ShopEase Admin Dashboard</title>

<link rel="stylesheet"
href="<?= url('assets/style.css') ?>">

<style>
.admin-layout {
    display: grid;
    grid-template-columns: 230px 1fr;
    min-height: 80vh;
    gap: 25px;
}

.admin-sidebar {
    background: #173e34;
    padding: 25px;
    border-radius: 10px;
    color: white;
}

.admin-sidebar h2 {
    margin-top: 0;
}

.admin-sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 13px 8px;
    border-bottom: 1px solid #ffffff22;
}

.admin-main h1 {
    font-size: 30px;
}

.admin-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.admin-card {
    background: #f3f6f0;
    padding: 22px;
    border-radius: 9px;
}

.admin-card h2 {
    font-size: 30px;
    margin: 10px 0;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}

.admin-table th,
.admin-table td {
    padding: 13px;
    border-bottom: 1px solid #eee;
    text-align: left;
}

.admin-table th {
    background: #eaf0e8;
}

@media(max-width:800px) {
    .admin-layout {
        grid-template-columns: 1fr;
    }

    .admin-cards {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
</head>

<body>

<div class="container admin-layout">

<aside class="admin-sidebar">

<h2>ShopEase Admin</h2>

<a href="<?= url('admin/index.php') ?>">Dashboard</a>
<a href="<?= url('admin/products.php') ?>">Manage Products</a>
<a href="<?= url('admin/orders.php') ?>">Manage Orders</a>
<a href="<?= url('index.php') ?>">View Website</a>
<a href="<?= url('logout.php') ?>">Logout</a>

</aside>

<section class="admin-main">

<span class="eyebrow">ADMIN CONTROL PANEL</span>

<h1>Welcome to Dashboard!</h1>

<p class="muted">
Manage your ShopEase store from here.
</p>

<div class="admin-cards">

<div class="admin-card">
Products
<h2><?= $totalProducts ?></h2>
</div>

<div class="admin-card">
Orders
<h2><?= $totalOrders ?></h2>
</div>

<div class="admin-card">
Customers
<h2><?= $totalUsers ?></h2>
</div>

<div class="admin-card">
Messages
<h2><?= $totalMessages ?></h2>
</div>

</div>

<h2>Recent Orders</h2>

<table class="admin-table">

<thead>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
</tr>
</thead>

<tbody>

<?php foreach ($recentOrders as $order): ?>

<tr>
<td>#<?= (int)$order['id'] ?></td>

<td>
<?= h($order['user_name'] ?? 'Customer') ?>
</td>

<td><?= money($order['total']) ?></td>

<td><?= h($order['status']) ?></td>
</tr>

<?php endforeach; ?>

<?php if (!$recentOrders): ?>
<tr>
<td colspan="4">No orders yet.</td>
</tr>
<?php endif; ?>

</tbody>
</table>

</section>
</div>

</body>
</html>
