<?php

    // make $_SESSION avaiable
    session_start();

    // list of avaiable products

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
            "name"   => "Milk",
            "price" => 1.5
        ],

        "p4" => [
            "name"   => "Cookies",
            "price" => 2.80
        ]
    ];


    // set or load cart status and total cost status
    $cart       = ( isset($_SESSION['cart']) ? $_SESSION['cart'] : []);
    $total_cost = ( isset($_SESSION['total_cost']) ? $_SESSION['total_cost'] : 0);
    $messaggio = "";

    // if we got a POST request with an id
    if( $_SERVER['REQUEST_METHOD'] == "POST" && isset( $_POST['product_id'] )){
        


        
        $product = $_POST['product_id'];
        $cost    = $products[$product]['price'];
        $action  = $_POST['action'];


        $count = 0;

        if( $action == "Add 1"){
            $count = 1;
            $messaggio = "<p style='color:green;'> Added 1 " . $products[$product]['name'] . "</p>";
        }elseif( $action == "Add 10"){
            $count = 10;
            $messaggio = "<p style='color:green;'> Added 10 " . $products[$product]['name'] . "</p>";
        }elseif( $action == "Add 100"){
            $count = 100;
            $messaggio = "<p style='color:green;'> Added 100 " . $products[$product]['name'] . "</p>";
        }elseif( $action == "Remove 1"){
            $count = -1;
            $messaggio = "<p style='color:red;'> Removed 1 " . $products[$product]['name'] . "</p>";
        }elseif( $action == "Remove 10"){
            $count = -10;
            $messaggio = "<p style='color:red;'> Removed 10 " . $products[$product]['name'] . "</p>";
        }elseif( $action == "Remove 100"){
            $count = -100;
            $messaggio = "<p style='color:red;'> Removed 100 " . $products[$product]['name'] . "</p>";
        }

        if( $count > 0 || ( (-1 * $cost * $count ) <= $total_cost ) ){
            $total_cost += $cost * $count;
        }

        if( isset($cart[$product])){
            if( $count > 0 || ( ( -1 * $count ) <= $cart[$product] )){
                $cart[$product] += $count;
            }else{
                $messaggio = "<p style='color:blue;'> Can't remove " . (-1 * $count) . " " . $products[$product]['name'] . "</p>";
            }
        }else{
            if( $count > 0 || ( ( -1 * $count ) <= $cart[$product] )){
                $cart[$product] = $count;
            }
        }
    }

    if( $_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['action']) && $_GET['action'] == 'empty'){
        $cart = [];
        $total_cost = 0;
        $messaggio = "<p style='color:blue;'> Shopping cart emptied! </p>";
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
    <link rel="icon" type="image/x-icon" href="./media/icon.png">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Simple Shopping Cart</h1>

        <h3> <?= $messaggio ?> </h3>

        <h2 class="mb-4 mt-5">🛒 Shopping Cart</h2>
        <?php if( isset($cart) ): ?>
            <h3>✅ Selected Products</h3>
                <?php if(empty($cart) || $total_cost == 0): ?>
                    <p>No selected product!</p>
                <?php else: ?>
                    <div class="d-flex flex-row flex-wrap"> 
                            <?php foreach($cart as $product => $amount): ?>
                                <?php if($amount > 0): ?>
                                    <div class="card ms-3 mt-4 flex-shrink-1" style="width: 25rem;">
                                        <img src="./media/<?= $products[$product]['name'] ?>.jpg" class="card-img-top" alt="<?= $products[$product]['name'] ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $products[$product]['name'] ?></h5>
                                            <p class="card-text">Amount: <?= $amount ?></p>
                                            <form class="mb-4" action="cart.php" method="POST">
                                                <input type="hidden" name='product_id' value='<?= $product ?>'>
                                                <div class='col'>
                                                    <input type="submit" name="action" value="Remove 1" class="btn btn-danger">
                                                    <input type="submit" name="action" value="Remove 10" class="btn btn-danger">
                                                    <input type="submit" name="action" value="Remove 100" class="btn btn-danger">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>
        <?php endif ?>
        <div class="container cost mt-5 mb-4 ">
            <h3>Total Cost: </h3><h3><?= $total_cost ?> €</h3>
        </div>
        
        <div class="container reset">
        <a href="cart.php?action=empty"><button class="btn btn-primary">Empty Cart</button></a>
        </div>

        <br> <br>
        <hr>
        <br>
        
        <div class="container product-list">
            <h2 class="mb-4">📜 Products</h2>
            <div class="d-flex flex-row flex-wrap">
                <?php foreach($products as $id => $product): ?>
                
                <div class="card ms-3 mt-4 flex-shrink-1" style="width: 20rem;">
                    <img src="./media/<?= $product['name'] ?>.jpg" class="card-img-top" alt="<?= $product['name']?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['name'] ?></h5>
                        <p class="card-text">Price: <?= number_format($product['price'], 2, ",", ".")  . '€' ?></p>
                        <form class="mb-4" action="cart.php" method="POST">
                            <input type="hidden" name='product_id' value='<?= $id ?>'>
                            <div class='col'>
                                <input type="submit" name="action" value="Add 1" class="btn btn-primary">
                                <input type="submit" name="action" value="Add 10" class="btn btn-primary">
                                <input type="submit" name="action" value="Add 100" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>