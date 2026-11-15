
<?php
require_once __DIR__ . '/../config.php';

if (!current_user() || current_user()['role'] !== 'admin') {
    http_response_code(403);
    exit('Access denied');
}

// Upload image helper
function uploadProductImage(): ?string {
    if (empty($_FILES['image_file']['name'])) {
        return null;
    }

    $file = $_FILES['image_file'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        exit('Image upload failed.');
    }

    if ($file['size'] > 3 * 1024 * 1024) {
        exit('Image size must be below 3 MB.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($allowed[$mime])) {
        exit('Only JPG, PNG and WEBP images are allowed.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $uploadDir = __DIR__ . '/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
        exit('Could not save uploaded image.');
    }

    return url('admin/uploads/' . $filename);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $action = $_POST['action'] ?? '';

    // Delete product
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);

        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);

        go('admin/products.php');
    }

    // Add product
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $oldPrice = (float)($_POST['old_price'] ?? 0);
        $image = uploadProductImage() ?? '';
        $stock = max(0, (int)($_POST['stock'] ?? 0));
        $badge = trim($_POST['badge'] ?? '');

        if ($name !== '' && $category !== '' && $price > 0) {
            $stmt = $pdo->prepare(
                "INSERT INTO products
                (name, category, description, price, old_price,
                 image, stock, badge, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active')"
            );

            $stmt->execute([
                $name, $category, $description, $price,
                $oldPrice ?: null, $image, $stock, $badge
            ]);
        }

        go('admin/products.php');
    }

    // Edit product
    if ($action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);

        $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $existing = $stmt->fetch();

        if (!$existing) {
            exit('Product not found.');
        }

        $name = trim($_POST['name'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $oldPrice = (float)($_POST['old_price'] ?? 0);
        $stock = max(0, (int)($_POST['stock'] ?? 0));
        $badge = trim($_POST['badge'] ?? '');

        $newImage = uploadProductImage();
        $image = $newImage ?? $existing['image'];

        if ($name !== '' && $category !== '' && $price > 0) {
            $stmt = $pdo->prepare(
                "UPDATE products SET
                name = ?, category = ?, description = ?,
                price = ?, old_price = ?, image = ?,
                stock = ?, badge = ?
                WHERE id = ?"
            );

            $stmt->execute([
                $name, $category, $description,
                $price, $oldPrice ?: null, $image,
                $stock, $badge, $id
            ]);
        }

        go('admin/products.php');
    }
}

// Load products
$products = $pdo->query(
    "SELECT * FROM products ORDER BY id DESC"
)->fetchAll();

// Selected product for editing
$editProduct = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([(int)$_GET['edit']]);
    $editProduct = $stmt->fetch();
}

$pageTitle = 'Manage Products';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Manage Products | ShopEase</title>
<link rel="stylesheet" href="<?= url('assets/style.css') ?>">

<style>
.admin-wrap {
    max-width:1100px;
    margin:35px auto;
    padding:20px;
}
.admin-form {
    background:#f3f6f0;
    padding:25px;
    border-radius:10px;
    margin-bottom:30px;
}
.admin-form input,
.admin-form textarea {
    width:100%;
    padding:12px;
    margin:7px 0 15px;
    border:1px solid #ddd;
    border-radius:5px;
}
.admin-table {
    width:100%;
    border-collapse:collapse;
}
.admin-table th,
.admin-table td {
    padding:12px;
    border-bottom:1px solid #ddd;
    text-align:left;
}
.admin-table img {
    width:55px;
    height:55px;
    object-fit:cover;
}
.delete-btn {
    background:#a83232;
    color:white;
    border:0;
    padding:8px 12px;
    cursor:pointer;
}
.edit-btn {
    display:inline-block;
    background:#176b45;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:4px;
    margin-bottom:5px;
}
.cancel-btn {
    display:inline-block;
    margin-left:10px;
}
</style>
</head>

<body>
<div class="admin-wrap">

<a href="<?= url('admin/index.php') ?>">← Back to Dashboard</a>

<h1>Manage Products</h1>

<?php if ($editProduct): ?>

<h2>Edit Product</h2>

<form method="post" enctype="multipart/form-data" class="admin-form">

<input type="hidden" name="csrf" value="<?= csrf_token() ?>">
<input type="hidden" name="action" value="edit">
<input type="hidden" name="id" value="<?= (int)$editProduct['id'] ?>">

<label>Product Name</label>
<input name="name" value="<?= h($editProduct['name']) ?>" required>

<label>Category</label>
<input name="category" value="<?= h($editProduct['category']) ?>" required>

<label>Description</label>
<textarea name="description" rows="3"><?= h($editProduct['description']) ?></textarea>

<label>Price</label>
<input type="number" name="price" min="1" step="0.01"
value="<?= h((string)$editProduct['price']) ?>" required>

<label>Old Price</label>
<input type="number" name="old_price" min="0" step="0.01"
value="<?= h((string)$editProduct['old_price']) ?>">

<label>Current Product Image</label><br>
<?php if ($editProduct['image']): ?>
<img src="<?= h($editProduct['image']) ?>"
     alt="Current product image"
     style="width:100px;height:100px;object-fit:cover">
<?php endif; ?>

<br><br>

<label>Change Product Image (Optional)</label>
<input type="file" name="image_file"
accept=".jpg,.jpeg,.png,.webp">

<small>JPG, PNG or WEBP · Maximum 3 MB</small>

<br><br>

<label>Stock Quantity</label>
<input type="number" name="stock" min="0"
value="<?= (int)$editProduct['stock'] ?>">

<label>Product Badge</label>
<input name="badge" value="<?= h($editProduct['badge']) ?>">

<button class="btn">Update Product</button>

<a class="cancel-btn" href="<?= url('admin/products.php') ?>">
Cancel
</a>

</form>

<?php else: ?>

<h2>Add New Product</h2>

<form method="post" enctype="multipart/form-data" class="admin-form">

<input type="hidden" name="csrf" value="<?= csrf_token() ?>">
<input type="hidden" name="action" value="add">

<label>Product Name</label>
<input name="name" required>

<label>Category</label>
<input name="category" required>

<label>Description</label>
<textarea name="description" rows="3"></textarea>

<label>Price</label>
<input type="number" name="price" min="1" step="0.01" required>

<label>Old Price</label>
<input type="number" name="old_price" min="0" step="0.01">

<label>Upload Product Image</label>
<input type="file" name="image_file"
accept=".jpg,.jpeg,.png,.webp">

<small>JPG, PNG or WEBP · Maximum 3 MB</small>

<label>Stock Quantity</label>
<input type="number" name="stock" min="0" value="20">

<label>Product Badge</label>
<input name="badge" placeholder="BESTSELLER">

<button class="btn">Add Product</button>

</form>

<?php endif; ?>

<h2>All Products (<?= count($products) ?>)</h2>

<table class="admin-table">
<thead>
<tr>
<th>Image</th>
<th>Name</th>
<th>Price</th>
<th>Stock</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php foreach ($products as $p): ?>
<tr>

<td>
<img src="<?= h($p['image']) ?>" alt="">
</td>

<td><?= h($p['name']) ?></td>

<td><?= money($p['price']) ?></td>

<td><?= (int)$p['stock'] ?></td>

<td>

<a class="edit-btn"
href="<?= url('admin/products.php?edit=' . (int)$p['id']) ?>">
Edit
</a>

<form method="post"
onsubmit="return confirm('Delete this product?')">

<input type="hidden" name="csrf"
value="<?= csrf_token() ?>">

<input type="hidden" name="action" value="delete">

<input type="hidden" name="id"
value="<?= (int)$p['id'] ?>">

<button class="delete-btn">Delete</button>

</form>

</td>

</tr>
<?php endforeach; ?>
</tbody>
</table>

</div>
</body>
</html>
