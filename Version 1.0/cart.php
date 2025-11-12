<?php

    session_start();

    if( isset($_GET['empty']) || !isset($_SESSION['cart'])){
        $_SESSION['cart'] = [];
    }
    if(isset($_GET['list'])){
        $products = $_GET['list'];

        $cart = $_SESSION['cart'];

        foreach($products as $product){
            if( isset($cart[$product]) ){
                $cart[$product] += 1;
            }else{
                $cart[$product] = 1;
            }
        }

        $_SESSION['cart'] = $cart;
    }
    
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Shopping Cart</title>
</head>
<body>
    <h1>Simple Shopping Cart</h1>
    <h2>Products</h2>
    <form action="cart.php" method="GET">
        <input type="checkbox" name='list[]' value='Apple'>
        <label for="apple">Apple | 0.50€</label>
        <br>
        <input type="checkbox" name='list[]' value='Bread'>
        <label for="Bread">Bread | 1.20€</label>
        <br>
        <input type="checkbox" name='list[]' value='Banana'>
        <label for="Banana">Banana | 0.80€</label>
        <br><br>
        <a href=".\cart.php?empty=on">Svuota Carrello</a>
        <br><br>
        <input type="submit">
    </form>
    <h2>Cart</h2>
    <ul>
            <?php if($_SESSION != null && key_exists('cart', $_SESSION)): ?>
                <?php foreach($_SESSION['cart'] as $product => $amount): ?>
                    <li><?= $product ?>: <?= $amount ?></li>
                <?php endforeach ?>
            <?php endif ?>
    </ul>
</body>
</html>