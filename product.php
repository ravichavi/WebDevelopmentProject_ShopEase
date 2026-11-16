<?php require __DIR__.'/config.php';$id=(int)($_GET['id']??0);$s=$pdo->prepare("SELECT * FROM products WHERE id=? AND status='active'");$s->execute([$id]);$p=$s->fetch();if(!$p){http_response_code(404);exit('Product not found');}$pageTitle=$p['name'];require __DIR__.'/includes/header.php';?>
<div class="crumb"><a href="<?= url() ?>">Home</a> / <?= h($p['category']) ?> / <?= h($p['name']) ?></div><section class="detail">
    <div class="detail-image">
        <img src="<?= h($p['image']) ?>" alt="<?= h($p['name']) ?>">
    </div>
    <div><span class="eyebrow"><?= h($p['category']) ?></span><h1><?= h($p['name']) ?></h1><p class="muted"><?= h($p['description']) ?></p><div class="detail-price"><?= money($p['price']) ?> <?php if($p['old_price']): ?><del><?= money($p['old_price']) ?></del><?php endif; ?></div><p class="stock"><?= $p['stock']>0?'In stock':'Currently unavailable' ?></p><form method="post" action="<?= url('cart_action.php') ?>"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><input type="hidden" name="action" value="add"><label>Quantity</label><input class="qty" type="number" name="quantity" value="1" min="1" max="<?= max(1,(int)$p['stock']) ?>"><button class="btn">Add to cart</button>
</form>
<form method="post" action="<?= url('wishlist.php') ?>">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
    <button class="btn" type="submit">♡ Add to Wishlist</button>
</form><p class="small-note">Easy shopping • Helpful support • Order updates</p></div></section>
<?php require __DIR__.'/includes/footer.php'; ?>
