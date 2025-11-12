<?php

    session_start();

    $cart = [];
    $total_cost = 0;

    if( isset( $_GET['list'] ) && isset( $_GET['cost'] ) ){
        
        $cart       = ( isset($_SESSION['cart']) ? $_SESSION['cart'] : []);
        $total_cost = ( isset($_SESSION['total_cost']) ? $_SESSION['total_cost'] : 0);
        
        $product = $_GET['list'];
        $cost    = $_GET['cost'];

        $total_cost += $cost;

        if( isset($cart[$product])){
            $cart[$product] += 1;
        }else{
            $cart[$product] = 1;
        }
    }
    
    $_SESSION['cart']       = $cart;
    $_SESSION['total_cost'] = $total_cost;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Shopping Cart</title>
</head>
<body>
    <h1>Simple Shopping Cart</h1>
    <h2>Products</h2>
    <form action="cart2.php" method="GET">
        <p>
            Apple | 0.50€
            <input type="hidden" name='list' value='Apple'>
            <input type="hidden" name='cost' value='0.50'>
        </p>
        <input type="submit" value="Add 1">
    </form>
    <hr>
    <form action="cart2.php" method="GET">
        <p>
            Banana | 0.80€
            <input type="hidden" name='list' value='Banana'>
            <input type="hidden" name='cost' value='0.80'>
        </p>
        <input type="submit" value="Add 1">
    </form>
    <hr>
    <form action="cart2.php" method="GET">
        <p>
            Bread | 1.20€
            <input type="hidden" name='list' value='Bread'>
            <input type="hidden" name='cost' value='1.20'>
        </p>
        <input type="submit" value="Add 1">
    </form>
    <hr>
    <h2>Cart</h2>
    <?php if( isset($cart) ): ?>
        <h3>Selected Products</h3>
        <ul>
            <?php foreach($cart as $product => $amount): ?>
                <li><?= $product ?> x <?= $amount ?></li>
            <?php endforeach ?>
        </ul>
        <h3>Total Cost</h3>
        <?= $total_cost ?> €
    <?php else: ?>
        <p>Nessun prodotto selezionato!</p>
    <?php endif ?>
    <h3>Reset Cart</h3>
    <a href="http://localhost/Esercizi/Carrello%20Spesa%20Semplice/cart2.php?empty=on">Empty Cart</a>
</body>
</html>