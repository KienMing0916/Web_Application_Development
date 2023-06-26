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

        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button class="buttoncontrol active" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide-to="0" aria-current="true" aria-label="Slide 1"></button>
                <button class="buttoncontrol" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button class="buttoncontrol" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="2000">
                    <img src="img/company1.jpg" class="d-block w-100" alt="company">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="img/company2.jpg" class="d-block w-100" alt="company">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="img/company3.jpg" class="d-block w-100" alt="company">
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

        <div class="parttwo bg-light text-center">
            <h1>Welcome to KM Trading Company</h1>
            <p class="lead">Your trusted partner in global trade. We are a dynamic and innovative trading company dedicated to facilitating seamless transactions and connecting businesses across borders..</p>
            <a href="#" class="btn btn-primary btn-lg">Learn More</a>
        </div>
    </div>
    <!-- end container -->
</body>
</html>
