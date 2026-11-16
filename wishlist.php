
<?php
require __DIR__ . '/config.php';

verify_csrf();

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Add or remove wishlist item
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['product_id'] ?? 0);

    $check = $pdo->prepare(
        "SELECT id FROM products WHERE id = ? AND status = 'active'"
    );
    $check->execute([$id]);

    if ($check->fetch()) {
        if (in_array($id, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array_values(
                array_diff($_SESSION['wishlist'], [$id])
            );
            $_SESSION['flash'] = 'Product removed from wishlist.';
        } else {
            $_SESSION['wishlist'][] = $id;
            $_SESSION['wishlist'] = array_unique($_SESSION['wishlist']);
            $_SESSION['flash'] = 'Product added to wishlist!';
        }
    }

    go('wishlist.php');
}

$ids = $_SESSION['wishlist'];
$products = [];

if (!empty($ids)) {
    $marks = implode(',', array_fill(0, count($ids), '?'));

    $stmt = $pdo->prepare(
        "SELECT * FROM products WHERE id IN ($marks) AND status = 'active'"
    );

    $stmt->execute($ids);
    $products = $stmt->fetchAll();
}

$pageTitle = 'My Wishlist';
require __DIR__ . '/includes/header.php';
?>

<h1 class="page-title">♡ My Wishlist</h1>

<?php if (!empty($_SESSION['flash'])): ?>
    <div class="notice">
        <?= h($_SESSION['flash']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<?php if (empty($products)): ?>

<div class="empty">
    <h2>Your wishlist is empty!</h2>
    <p>Save your favourite products here.</p>
    <a href="<?= url() ?>" class="btn">Explore Products</a>
</div>

<?php else: ?>

<div class="grid">

<?php foreach ($products as $p): ?>

<article class="product">

    <a class="product-image"
       href="<?= url('product.php?id=' . $p['id']) ?>">

        <img src="<?= h($p['image']) ?>"
             alt="<?= h($p['name']) ?>">

    </a>

    <div class="product-info">

        <small><?= h($p['category']) ?></small>

        <a class="product-name"
           href="<?= url('product.php?id=' . $p['id']) ?>">
            <?= h($p['name']) ?>
        </a>

        <div class="price">
            <?= money($p['price']) ?>
        </div>

        <form method="post">
            <input type="hidden"
                   name="csrf"
                   value="<?= csrf_token() ?>">

            <input type="hidden"
                   name="product_id"
                   value="<?= $p['id'] ?>">

            <button class="btn full" type="submit">
                ♡ Remove from Wishlist
            </button>
        </form>

    </div>

</article>

<?php endforeach; ?>

</div>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
