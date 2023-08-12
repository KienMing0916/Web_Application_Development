<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Order Details</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'create_order_successfully') {
            echo "<div class='alert alert-success m-3'>Order placed successfully.</div>";
        }

        if ($action == 'update_order_successfully') {
            echo "<div class='alert alert-success m-3'>Order updated successfully.</div>";
        }

        include 'config/database.php';
        $query = "SELECT order_details.OrderDetail_ID, order_details.Order_ID, products.name, products.price, products.promotion_price, order_details.quantity FROM order_details INNER JOIN products ON order_details.Product_ID = products.Product_ID WHERE order_details.Order_ID =:id ORDER BY order_details.OrderDetail_ID ASC";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $num = $stmt->rowCount();
        $subTotal = 0;
        $totalAmount = 0;
        $rowNumber = 1;
        // get the customer firstname, lastname and order date time
        $customerQuery = "SELECT order_summary.order_date, customers.firstname, customers.lastname FROM order_details INNER JOIN order_summary ON order_details.Order_ID = order_summary.Order_ID INNER JOIN customers ON order_summary.Customer_ID = customers.Customer_ID WHERE order_details.Order_ID = :id ORDER BY order_details.OrderDetail_ID ASC";
        $customerStmt = $con->prepare($customerQuery);
        $customerStmt->bindParam(":id", $id);
        $customerStmt->execute();
        $customerRow = $customerStmt->fetch(PDO::FETCH_ASSOC);
        $firstname = $customerRow['firstname'];
        $lastname = $customerRow['lastname'];
        $orderDateTime = $customerRow['order_date'];

        if($num > 0){
            echo "<div class='pt-2 d-flex justify-content-between'>";
                echo "<p class='ps-3'><strong>Customer Name: " . $firstname . " " . $lastname . "</strong></p>";
                echo "<p class='pe-4'><strong>Order Date: " . $orderDateTime . "</strong></p>";
            echo "</div>";
            echo "<div class='pt-0 p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th class='col-1'>No</th>";
                        echo "<th class='col-5'>Product Name</th>";
                        echo "<th class='col-1'>Price (RM) / Unit</th>";
                        echo "<th class='col-2'>Quantity</th>";
                        echo "<th class='col-1'>Amount (RM)</th>";
                    echo "</tr>";

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $subTotal = $promotion_price * $quantity;
                        $totalAmount += $subTotal;
                        echo "<tr>";
                                echo "<td>{$rowNumber}</td>";
                                echo "<td>{$name}</td>";
                                // d-flex justify-content-center can't write to td, otherwise it won't take full height of td
                                echo"<td>
                                    <div class='d-flex justify-content-end'>
                                        <p class='text-decoration-line-through mx-1'>" . number_format((float)$price, 2, '.', '') . "</p>
                                        <p class='me-4'>" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                                    </div>
                                    </td>";
                                echo "<td>{$quantity}</td>";
                                echo"<td>
                                    <div class='d-flex justify-content-end'>
                                        <p class='me-3'>" . number_format((float)$subTotal, 2, '.', '') . "</p>
                                    </div>
                                </td>";  
                        echo "</tr>";
                        $rowNumber++;
                    }
                echo "</table>";
                $formattedTotalAmount = number_format((float)$totalAmount, 2, '.', '');
                echo "<div class='d-flex justify-content-end py-0 pe-1'>";
                    echo "<p><strong>Total Amount: RM" . $formattedTotalAmount . "</strong></p>";
                echo "</div>";
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

