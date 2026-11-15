<?php
require __DIR__.'/config.php';
$pageTitle='Discover products';
$q=trim($_GET['q'] ?? '');
$cat=trim($_GET['category'] ?? '');
$sql="SELECT * FROM products WHERE status='active'";
$params=[];
if($q!==''){ $sql.=" AND (name LIKE ? OR description LIKE ? OR category LIKE ?)"; $params=["%$q%","%$q%","%$q%"]; }
if($cat!==''){ $sql.=" AND category=?"; $params[]=$cat; }
$sort=$_GET['sort'] ?? 'featured';
$sql .= match($sort){'price_low'=>' ORDER BY price ASC','price_high'=>' ORDER BY price DESC','newest'=>' ORDER BY id DESC',default=>' ORDER BY featured DESC,id DESC'};
$stmt=$pdo->prepare($sql);$stmt->execute($params);$products=$stmt->fetchAll();
$categories=$pdo->query("SELECT DISTINCT category FROM products WHERE status='active' ORDER BY category")->fetchAll(PDO::FETCH_COLUMN);
require __DIR__.'/includes/header.php';
?>
<section class="hero"><div><span class="eyebrow">THE SHOP EASE EDIT</span><h1>Find your next<br><em>everyday favourite.</em></h1><p>Discover useful finds, fresh styles and little upgrades for every day.</p><a class="btn light" href="#products">Explore collection</a></div><div class="hero-art"><div class="orb"></div><div class="hero-card">THE<br><strong>GOOD<br>FINDS</strong><small>Curated for you</small></div></div></section>
<div class="section-head"><div><span class="eyebrow">BROWSE YOUR WAY</span><h2>Shop by category</h2></div></div>
<div class="chips"><a class="<?= $cat===''?'selected':'' ?>" href="<?= url() ?>">All products</a><?php foreach($categories as $c): ?><a class="<?= $cat===$c?'selected':'' ?>" href="<?= url('index.php?category='.urlencode($c)) ?>"><?= h($c) ?></a><?php endforeach; ?></div>
<section id="products"><div class="section-head"><div><span class="eyebrow">MADE FOR EVERYDAY</span><h2><?= $q!==''?'Search results':'Popular right now' ?></h2><p class="muted"><?= count($products) ?> products to explore</p></div><form><input type="hidden" name="q" value="<?= h($q) ?>"><input type="hidden" name="category" value="<?= h($cat) ?>"><select name="sort" onchange="this.form.submit()"><option value="featured">Featured</option><option value="newest" <?= $sort==='newest'?'selected':'' ?>>Newest</option><option value="price_low" <?= $sort==='price_low'?'selected':'' ?>>Price: low to high</option><option value="price_high" <?= $sort==='price_high'?'selected':'' ?>>Price: high to low</option></select></form></div>
<div class="grid"><?php foreach($products as $p): ?><article class="product"><a class="product-image" href="<?= url('product.php?id='.$p['id']) ?>"><img src="<?= h($p['image']) ?>" alt="<?= h($p['name']) ?>"><span><?= h($p['badge'] ?: 'SHOP EASE PICK') ?></span></a><div class="product-info"><small><?= h($p['category']) ?></small><a class="product-name" href="<?= url('product.php?id='.$p['id']) ?>"><?= h($p['name']) ?></a><div class="price"><?= money($p['price']) ?> <?php if($p['old_price']): ?><del><?= money($p['old_price']) ?></del><?php endif; ?></div><form method="post" action="<?= url('cart_action.php') ?>"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="product_id" value="<?= $p['id'] ?>"><input type="hidden" name="action" value="add"><button class="btn full">Add to cart</button></form></div></article><?php endforeach; ?></div>
<?php if(!$products): ?><div class="empty"><h3>No products found</h3><p>Try another search or browse all products.</p><a class="btn" href="<?= url() ?>">View all products</a></div><?php endif; ?></section>
<?php require __DIR__.'/includes/footer.php'; ?>
