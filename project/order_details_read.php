<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Read Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Product</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';
        $query = "SELECT order_details.OrderDetail_ID, order_details.Order_ID, products.name, products.price, products.promotion_price, order_details.quantity FROM order_details INNER JOIN products ON order_details.Product_ID = products.Product_ID WHERE order_details.Order_ID =:id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $num = $stmt->rowCount();

        if($num > 0){
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                echo "<tr>";
                    echo "<th class='col-2'>Order Detail ID</th>";
                    echo "<th class='col-2'>Order ID</th>";
                    echo "<th class='col-5'>Product Name</th>";
                    echo "<th class='col-1'>Price (RM) / Unit</th>";
                    echo "<th class='col-2'>Quantity</th>";
                    // echo "<th>Action</th>";
                echo "</tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<td>{$OrderDetail_ID}</td>";
                        echo "<td>{$Order_ID}</td>";
                        echo "<td>{$name}</td>";
                        // d-flex justify-content-center can't write to td, otherwise it won't take full height of td
                        echo"<td>
                            <div class='d-flex justify-content-end'>
                                <p class='text-decoration-line-through mx-1'>" . number_format((float)$price, 2, '.', '') . "</p>
                                <p class='me-3'>" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                            </div>
                            </td>";
                        echo "<td>{$quantity}</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<a href='order_read.php' class='btn btn-danger'>Back to order list</a>";
            echo "</div>";    
        }else{
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

