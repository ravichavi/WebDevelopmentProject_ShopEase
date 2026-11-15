
<?php
require_once __DIR__ . '/../config.php';

if (!current_user() || current_user()['role'] !== 'admin') {
    http_response_code(403);
    exit('Access denied');
}

// Update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    $allowedStatuses = [
        'Pending',
        'Processing',
        'Shipped',
        'Delivered',
        'Cancelled'
    ];

    if ($orderId > 0 && in_array($status, $allowedStatuses, true)) {
        $stmt = $pdo->prepare(
            "UPDATE orders SET status = ? WHERE id = ?"
        );
        $stmt->execute([$status, $orderId]);
    }

    go('admin/orders.php');
}

// Get all orders
$orders = $pdo->query(
    "SELECT * FROM orders ORDER BY id DESC"
)->fetchAll();

$pageTitle = 'Manage Orders';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Orders | ShopEase</title>
<link rel="stylesheet" href="<?= url('assets/style.css') ?>">

<style>
.admin-wrap {
    max-width:1200px;
    margin:35px auto;
    padding:20px;
}
.order-card {
    background:#f3f6f0;
    padding:20px;
    border-radius:10px;
    margin:20px 0;
}
.order-card h3 {
    margin-top:0;
}
.order-info {
    line-height:1.8;
}
.order-table {
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
.order-table th,
.order-table td {
    padding:10px;
    border-bottom:1px solid #ddd;
    text-align:left;
}
.order-status {
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
}
.update-btn {
    background:#176b45;
    color:white;
    border:0;
    padding:10px 15px;
    border-radius:5px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="admin-wrap">

<a href="<?= url('admin/index.php') ?>">← Back to Dashboard</a>

<h1>Manage Orders</h1>

<h2>Total Orders: <?= count($orders) ?></h2>

<?php if (!$orders): ?>

<p>No orders found yet.</p>

<?php else: ?>

<?php foreach ($orders as $order): ?>

<div class="order-card">

<h3>Order #<?= (int)$order['id'] ?></h3>

<div class="order-info">
<strong>Customer:</strong>
<?= h($order['customer_name']) ?><br>

<strong>Phone:</strong>
<?= h($order['phone']) ?><br>

<strong>Address:</strong>
<?= nl2br(h($order['address'])) ?><br>

<strong>Total:</strong>
<?= money($order['total']) ?><br>

<strong>Payment:</strong>
<?= h($order['payment_method']) ?><br>

<strong>Date:</strong>
<?= h($order['created_at']) ?><br>

<strong>Current Status:</strong>
<?= h($order['status']) ?>
</div>

<h4>Update Order Status</h4>

<form method="post">

<input type="hidden" name="csrf"
value="<?= csrf_token() ?>">

<input type="hidden" name="order_id"
value="<?= (int)$order['id'] ?>">

<select name="status" class="order-status">

<?php
$statuses = [
    'Pending',
    'Processing',
    'Shipped',
    'Delivered',
    'Cancelled'
];
?>

<?php foreach ($statuses as $status): ?>
<option value="<?= h($status) ?>"
<?= $order['status'] === $status ? 'selected' : '' ?>>
<?= h($status) ?>
</option>
<?php endforeach; ?>

</select>

<button class="update-btn">Update Status</button>

</form>

<h4>Ordered Products</h4>

<table class="order-table">

<thead>
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
</tr>
</thead>

<tbody>

<?php
$stmt = $pdo->prepare(
    "SELECT * FROM order_items WHERE order_id = ?"
);
$stmt->execute([$order['id']]);
$items = $stmt->fetchAll();
?>

<?php foreach ($items as $item): ?>
<tr>

<td><?= h($item['product_name']) ?></td>

<td><?= money($item['price']) ?></td>

<td><?= (int)$item['quantity'] ?></td>

</tr>
<?php endforeach; ?>

</tbody>
</table>

</div>

<?php endforeach; ?>

<?php endif; ?>

</div>

</body>
</html>
