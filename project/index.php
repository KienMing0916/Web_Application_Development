<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
</head>
<body>
    <!-- container -->
    <div class="container p-0">
        
        <?php
            include 'menu.php';
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
            <h1>Welcome to KM Trading Company</h1>
            <p class="lead">Your trusted partner in global trade. We are a dynamic and innovative trading company dedicated to facilitating seamless transactions and connecting businesses across borders..</p>
            <a href="#" class="btn btn-primary btn-lg">Learn More</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
