<?php $user = current_user(); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= h($pageTitle ?? 'ShopEase') ?> | ShopEase</title><link rel="stylesheet" href="<?= url('assets/style.css') ?>"></head><body>
<div class="topline">Big savings. Better choices. Delivered with care.</div>
<header class="header"><a class="brand" href="<?= url() ?>">Shop<span>Ease</span></a>
<form class="search" action="<?= url('index.php') ?>" method="get"><input name="q" placeholder="Search products, brands and more..." value="<?= h($_GET['q'] ?? '') ?>"><button>Search</button></form>
<nav><a href="<?= url('index.php') ?>">Home</a><a href="<?= url('orders.php') ?>">Orders</a><a href="<?= url('wishlist.php') ?>">Wishlist</a><a href="<?= url('cart.php') ?>">Cart <b class="count"><?= cart_count() ?></b></a>
<?php if ($user): ?><a href="<?= url('account.php') ?>">Hi, <?= h($user['name']) ?></a><a href="<?= url('logout.php') ?>">Logout</a><?php else: ?><a href="<?= url('login.php') ?>">Sign in</a><?php endif; ?></nav></header>
<main class="container">
