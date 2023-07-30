<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
</head>
<body>
    <div class="container p-0">
        
        <?php
            include 'menu/nav.php';
        ?>

        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="img/factory.jpg" alt="companyimg1">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/sportacademy.jpg" alt="companyimg2">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/assemblyline.jpg" alt="companyimg3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>

        <div class="parttwo bg-light text-center pt-4 pb-4">
            <h1>Welcome to XXX Supermarket</h1>
            <p class="lead">Welcome to our dynamic and innovative supermarket! We are dedicated to providing a seamless shopping experience and connecting customers with a wide range of quality products from around the world. Our goal is to make your grocery shopping hassle-free and enjoyable.</p>
            <a href="create_order.php" class="btn btn-primary btn-lg">Make an order now</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
