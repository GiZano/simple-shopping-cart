<?php

    session_start();

    $products = [
        "p1" => [
            "name"   => "Apple",
            "price" => 0.5
        ],

        "p2" => [
            "name"   => "Bread",
            "price" =>  1.20
        ],

        "p3" => [
            "name"   => "Milk (1L)",
            "price" => 1.5
        ],

        "p4" => [
            "name"   => "Cookies",
            "price" => 2.80
        ]
    ];



    $cart       = ( isset($_SESSION['cart']) ? $_SESSION['cart'] : []);
    $total_cost = ( isset($_SESSION['total_cost']) ? $_SESSION['total_cost'] : 0);

    if( isset( $_POST['product_id'] )){
        
        $cart       = ( isset($_SESSION['cart']) ? $_SESSION['cart'] : []);
        $total_cost = ( isset($_SESSION['total_cost']) ? $_SESSION['total_cost'] : 0);
        
        $product = $products[$_POST['product_id']]['name'];
        $cost    = $products[$_POST['product_id']]['price'];
        $action  = $_POST['action'];

        $count = 0;

        if( $action == "Add 1"){
            $count = 1;
        }elseif( $action == "Add 10"){
            $count = 10;
        }elseif( $action == "Add 100"){
            $count = 100;
        }

        $total_cost += $cost * $count;

        if( isset($cart[$product])){
            $cart[$product] += $count;
        }else{
            $cart[$product] = $count;
        }
    }
    elseif( isset( $_POST['empty'] )){
        $cart = [];
        $total_cost = 0;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Simple Shopping Cart</h1>
        <h2 class="mb-4">📜 Products</h2>

        <?php foreach($products as $id => $product): ?>
            <form class="item mb-4" action="cart.php" method="POST">
            <p>
                <?= $product['name'] . ' | ' . number_format($product['price'], 2, ",", ".")  . '€'?>
                <input type="hidden" name='product_id' value='<?= $id ?>'>
            </p>
            <div>
                <input type="submit" name="action" value="Add 1" class="btn btn-primary">
                <input type="submit" name="action" value="Add 10" class="btn btn-primary">
                <input type="submit" name="action" value="Add 100" class="btn btn-primary">
            </div>
            
            </form>
        <?php endforeach; ?>
        <hr>
        <h2 class="mb-4 mt-5">🛒 Shopping Cart</h2>
        <?php if( isset($cart) ): ?>
            <h3>✅ Selected Products</h3>
            <ul class="mb-4">
                <?php if(empty($cart)): ?>
                    <p>No selected product!</p>
                <?php else: ?>
                    <?php foreach($cart as $product => $amount): ?>
                        <li><?= $product ?> x <?= $amount ?></li>
                    <?php endforeach ?>
                <?php endif; ?>
            </ul>
        <?php else: ?>
            <p>No selected product!</p>
        <?php endif ?>
        <div class="container cost mt-5 mb-4 ">
            <h3>Total Cost: </h3><h3><?= $total_cost ?> €</h3>
        </div>
            
        <form action="cart.php" method="POST">
            <input type="hidden" name="empty" value="on">
            <input type="submit" value="Empty Cart" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>