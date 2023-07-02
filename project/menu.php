<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="d-flex align-items-center ms-1">
        <img src="img/factorylogo.png" alt="factorylogo" width="50" height="40" class="d-inline-block align-text-top ms-3">
        <a class="navbar-brand ms-2" href="#">KM</a>
    </div>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end pe-3" id="navbarNav">
        <ul class="navbar-nav ps-3">
            <li class="nav-item p-1">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/webapplicationdevelopment/project/index.php') echo 'active'; ?>" href="index.php">Home</a>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/webapplicationdevelopment/project/product_create.php') echo 'active'; ?>" href="product_create.php">Create Product</a>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/webapplicationdevelopment/project/customer_create.php') echo 'active'; ?>" href="customer_create.php">Create Customer</a>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/webapplicationdevelopment/project/contactus.php') echo 'active'; ?>" href="contactus.php">Contact Us</a>
            </li>
        </ul>
    </div>
</nav>
