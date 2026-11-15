<?php require __DIR__.'/config.php';verify_csrf();$id=(int)($_POST['product_id']??0);$action=$_POST['action']??'add';$s=$pdo->prepare("SELECT id,stock FROM products WHERE id=? AND status='active'");$s->execute([$id]);$p=$s->fetch();if(!$p){$_SESSION['flash']='This product is unavailable.';go('cart.php');}
if($action==='add'){$qty=max(1,(int)($_POST['quantity']??1));$current=(int)($_SESSION['cart'][$id]??0);if($current+$qty>(int)$p['stock']){$_SESSION['flash']='Requested quantity is not available in stock.';}else{$_SESSION['cart'][$id]=$current+$qty;$_SESSION['flash']='Added to your cart.';}}
if($action==='remove'){unset($_SESSION['cart'][$id]);}
go('cart.php');
