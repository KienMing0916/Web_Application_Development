<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>KM Speedmart - Home</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="bg-light container p-0">
        <?php
            include 'menu/nav.php';
        ?>

        <?php
        include 'config/database.php';

        $statisticsQuery = "SELECT
            (SELECT COUNT(*) FROM customers) AS total_customers,
            (SELECT COUNT(*) FROM products) AS total_products,
            (SELECT COUNT(*) FROM order_summary) AS total_orders,
    
            latest_order.Order_ID AS latest_order_id,
            CONCAT(latest_order.firstname, ' ', latest_order.lastname) AS latest_order_customer_name,
            latest_order.order_date AS latest_order_date,
            latest_order.total_amount AS latest_order_total_amount,
        
            highest_total.Order_ID AS highest_total_amount_order_id,
            CONCAT(highest_total.firstname, ' ', highest_total.lastname) AS highest_total_amount_customer_name,
            highest_total.order_date AS highest_total_amount_order_date,
            highest_total.total_amount AS highest_total_amount_total_amount

            FROM (
                SELECT Order_ID, firstname, lastname, order_date, total_amount
                FROM order_summary
                JOIN customers ON order_summary.Customer_ID = customers.Customer_ID
                ORDER BY order_date DESC
                LIMIT 1
            ) AS latest_order
            
            CROSS JOIN (
                SELECT Order_ID, firstname, lastname, order_date, total_amount
                FROM order_summary
                JOIN customers ON order_summary.Customer_ID = customers.Customer_ID
                ORDER BY total_amount DESC
                LIMIT 1
            ) AS highest_total";

        $statisticsStmt = $con->prepare($statisticsQuery);
        $statisticsStmt->execute();
        $statisticsRow = $statisticsStmt->fetch(PDO::FETCH_ASSOC);
        extract($statisticsRow);

        $topSellingQuery = "SELECT products.Product_ID, products.name, categories.category_name, SUM(order_details.quantity) AS total_quantity_sold, products.price, products.promotion_price
            FROM products
            JOIN order_details ON products.Product_ID = order_details.Product_ID
            JOIN categories ON products.Category_ID = categories.Category_ID
            GROUP BY products.Product_ID, products.name, categories.category_name, products.price, products.promotion_price
            ORDER BY total_quantity_sold DESC
            LIMIT 5";

        $topSellingStmt = $con->prepare($topSellingQuery);
        $topSellingStmt->execute();

        $noPurchasedQuery = "SELECT products.Product_ID, products.name, categories.category_name, products.price, products.promotion_price
            FROM products
            JOIN categories ON products.Category_ID = categories.Category_ID
            LEFT JOIN order_details ON products.Product_ID = order_details.Product_ID
            GROUP BY products.Product_ID, products.name, categories.category_name, products.price, products.promotion_price
            HAVING COUNT(order_details.OrderDetail_ID) = 0
            ORDER BY Product_ID ASC
            LIMIT 3";

        $noPurchasedStmt = $con->prepare($noPurchasedQuery);
        $noPurchasedStmt->execute();
        ?>

        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="img/assemblyline.jpg" alt="companyimg1">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/academy.jpg" alt="companyimg2">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="img/factory.jpg" alt="companyimg3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>

        <div class="bg-white text-center py-4">
            <h1>Welcome to KM Speedmart</h1>
            <p class="lead p-3">We are dedicated to providing a seamless shopping experience and connecting customers with a wide range of quality products. Our goal is to make your shopping hassle-free and enjoyable.</p>
            <a href="order_create.php" class="btn btn-primary btn-lg">Make an order now</a>
        </div>

        <div class="bg-light row m-0 py-4 text-center d-flex justify-content-center">
            <h1 class="pb-4">Statistics</h1>
            <div class="col-md-4 p-3">
                <div class="bg-white border border-dark rounded p-3">
                    <h5>Number of customers we have</h5>
                    <?php echo "<h2>{$total_customers}</h2>";?>
                </div>
            </div>
            <div class="col-md-4 p-3">
                <div class="bg-white border border-dark rounded p-3">
                    <h5>Number of products we have</h5>
                    <?php echo "<h2>{$total_products}</h2>";?>
                </div>
            </div>
            <div class="col-md-4 p-3">
                <div class="bg-white border border-dark rounded p-3">
                    <h5>Number of orders we made</h5>
                    <?php echo "<h2>{$total_orders}</h2>";?>
                </div>
            </div>
        </div>

        <div class="row m-0 pt-4 d-flex justify-content-center" style="background-color: #E5F7FD">
            <h1 class="pb-4 text-center">Latest Order</h1>
            <?php
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th class='col-1'>Order ID</th>";
                        echo "<th class='col-2'>Customer Name</th>";
                        echo "<th class='col-2'>Transaction Date</th>";
                        echo "<th class='col-1'>Purchased Amount (RM)</th>";
                    echo "</tr>";

                    echo "<tr>";
                            echo "<td>{$latest_order_id}</td>";
                            echo "<td>{$latest_order_customer_name}</td>";
                            echo "<td>{$latest_order_date}</td>";
                            echo"<td>
                                <div class='d-flex justify-content-end'>
                                    <p class='me-3 mb-0'>" . number_format((float)$latest_order_total_amount, 2, '.', '') . "</p>
                                </div>
                            </td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>"; 
            ?>
        </div>

        <div class="row m-0 pt-4 d-flex justify-content-center" style="background-color: #E5F7FD">
            <h1 class="pb-4 text-center">Highest Amount Order</h1>
            <?php
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th class='col-1'>Order ID</th>";
                        echo "<th class='col-2'>Customer Name</th>";
                        echo "<th class='col-2'>Transaction Date</th>";
                        echo "<th class='col-1'>Purchased Amount (RM)</th>";
                    echo "</tr>";

                    echo "<tr>";
                            echo "<td>{$highest_total_amount_order_id}</td>";
                            echo "<td>{$highest_total_amount_customer_name}</td>";
                            echo "<td>{$highest_total_amount_order_date}</td>";
                            echo"<td>
                                <div class='d-flex justify-content-end'>
                                    <p class='me-3 mb-0'>" . number_format((float)$highest_total_amount_total_amount, 2, '.', '') . "</p>
                                </div>
                            </td>";
                    echo "</tr>";
                echo "</table>";
            echo "</div>"; 
            ?>
        </div>

        <div class="row m-0 pt-4 d-flex justify-content-center" style="background-color: #E5F7FD">
            <h1 class="pb-4 text-center">Top 5 Selling Products</h1>
            <?php
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th class='col-1'>Product_ID</th>";
                        echo "<th class='col-2'>Product Name</th>";
                        echo "<th class='col-2'>Category Name</th>";
                        echo "<th class='col-2'>Quantity Sold</th>";
                        echo "<th class='col-1'>Selling Price (RM)</th>";
                    echo "</tr>";

                    while ($productRow = $topSellingStmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($productRow);
                        echo "<tr>";
                        echo "<td>{$Product_ID}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$category_name}</td>";
                        echo "<td>{$total_quantity_sold}</td>";

                        if ($promotion_price < $price && ($promotion_price != 0)){
                            echo"<td>
                                    <div class='d-flex justify-content-end'>
                                        <p class='text-decoration-line-through mx-1 mb-0'>" . number_format((float)$price, 2, '.', '') . "</p>
                                        <p class='me-2 mb-0'>" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                                    </div>
                                </td>";
                        }else{
                            echo"<td>
                                    <div class='d-flex justify-content-end'>
                                        <p class='mx-1 mb-0 me-2'>" . number_format((float)$price, 2, '.', '') . "</p>
                                        
                                    </div>
                                </td>";
                        }
                        echo "</tr>";
                    }
                echo "</table>";
            echo "</div>"; 
            ?>
        </div>

        <div class="row m-0 py-4 d-flex justify-content-center" style="background-color: #E5F7FD">
            <h1 class="pb-4 text-center">Top 3 Unpurchased Products</h1>
            <?php
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th class='col-1'>Product_ID</th>";
                        echo "<th class='col-4'>Product Name</th>";
                        echo "<th class='col-2'>Category Name</th>";
                        echo "<th class='col-1'>Selling Price (RM)</th>";
                    echo "</tr>";

                    while ($noPurchaseRow = $noPurchasedStmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($noPurchaseRow);
                        echo "<tr>";
                        echo "<td>{$Product_ID}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$category_name}</td>";
                        
                        if ($promotion_price < $price && ($promotion_price != 0)){
                            echo"<td>
                                    <div class='d-flex justify-content-end'>
                                        <p class='text-decoration-line-through mx-1 mb-0'>" . number_format((float)$price, 2, '.', '') . "</p>
                                        <p class='me-2 mb-0'>" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                                    </div>
                                </td>";
                        }else{
                            echo"<td>
                                    <div class='d-flex justify-content-end'>
                                        <p class='mx-1 mb-0 me-2'>" . number_format((float)$price, 2, '.', '') . "</p>
                                        
                                    </div>
                                </td>";
                        }
                        echo "</tr>";
                    }
                echo "</table>";
            echo "</div>"; 
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
