<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="d-flex align-items-center ms-1">
        <a class="navbar-brand ms-2" href="index.php">
            <img src="img/factorylogo.png" alt="factorylogo" width="50" height="40" class="ms-3">
            <span style="vertical-align: middle;">KM</span>
        </a>
    </div>
    <button class="navbar-toggler me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end pe-3" id="navbarNav">
        <ul class="navbar-nav ps-3">
            <li class="nav-item p-1">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/webapplicationdevelopment/project/index.php') echo 'active'; ?>" href="index.php">Home</a>
            </li>
            <li class="nav-item p-1 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <li><a class="dropdown-item" href="category_create.php">Create Category</a></li>
                    <li><a class="dropdown-item" href="category_read.php">Read Category</a></li>
                </ul>
            </li>
            <li class="nav-item p-1 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Product</a>
                <ul class="dropdown-menu" aria-labelledby="productDropdown">
                    <li><a class="dropdown-item" href="product_create.php">Create Product</a></li>
                    <li><a class="dropdown-item" href="product_read.php">Read Product</a></li>
                </ul>
            </li>
            <li class="nav-item p-1 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="customerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Customer</a>
                <ul class="dropdown-menu" aria-labelledby="customerDropdown">
                    <li><a class="dropdown-item" href="customer_create.php">Create Customer</a></li>
                    <li><a class="dropdown-item" href="customer_read.php">Read Customer</a></li>
                </ul>
            </li>
            <li class="nav-item p-1 dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="orderDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Order</a>
                <ul class="dropdown-menu" aria-labelledby="orderDropdown">
                    <li><a class="dropdown-item" href="order_create.php">Create Order</a></li>
                </ul>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link <?php if ($_SERVER['PHP_SELF'] == '/webapplicationdevelopment/project/contactus.php') echo 'active'; ?>" href="contactus.php">Contact Us</a>
            </li>
            <li class="nav-item p-1">
                <a class="nav-link" href="?logout=true">Logout</a>
            </li>
        </ul>
    </div>
</nav>

