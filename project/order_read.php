<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>List of order summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Order Summary</h1>
        </div>
     
        <?php
        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT order_summary.Order_ID, customers.firstname, customers.lastname, order_summary.order_date, order_summary.total_amount FROM order_summary INNER JOIN customers ON order_summary.Customer_ID = customers.Customer_ID";
        if (!empty($searchKeyword)) {
            $query .= " WHERE customers.firstname LIKE :keyword OR customers.lastname LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY order_summary.Order_ID ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="order_create.php" class="btn btn-primary m-b-1em">Create New Order</a>
        </div>';

        echo '<div class="p-3 pb-1">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search customer name..." value="' . str_replace('%', '', $searchKeyword) . '">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>';

        include 'menu/delete_alert_box.php';
        
        if($num > 0){
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";
                echo "<tr>";
                    echo "<th class='col-2'>Order ID</th>";
                    echo "<th class='col-3'>Customer Name</th>";
                    echo "<th class='col-2'>Order Date</th>";
                    echo "<th class='col-2'>Total Amount (RM)</th>";
                    echo "<th class='col-3'>Action</th>";
                echo "</tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<td>{$Order_ID}</td>";
                        echo "<td>{$firstname} {$lastname}</td>";
                        echo "<td>{$order_date}</td>";
                        echo"<td>
                            <div class='d-flex justify-content-end'>
                                <p class='me-3'>" . number_format((float)$total_amount, 2, '.', '') . "</p>
                            </div>
                        </td>";
                        echo "<td class='col-3'>";
                            echo "<a href='order_details_read.php?id={$Order_ID}' class='btn btn-info m-r-1em text-white mx-2'>Read</a>";
                            echo "<a href='order_update.php?id={$Order_ID}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                            echo "<a href='#' onclick='order_delete({$Order_ID});'  class='btn btn-danger mx-2'>Delete</a>";
                        echo "</td>";

                    echo "</tr>";
                }
                echo "</table>";
            echo "</div>";    
        }else{
            echo '<div class="p-3">
                <div class="alert alert-danger">No records found.</div>
            </div>';
        }
        ?>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script type='text/javascript'>
    // confirm record deletion
    function order_delete(Order_ID){
        if (confirm('Are you sure?')){
            // if user clicked ok, pass the id to delete.php and execute the delete query
            window.location = 'order_delete.php?id=' + Order_ID;
        }
    }
    </script>
</body>
</html>
