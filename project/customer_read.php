<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>List of Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Customers</h1>
        </div>

        <?php
        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT Customer_ID, username, firstname, lastname, email, status FROM customers";
        if (!empty($searchKeyword)) {
            $query .= " WHERE username LIKE :keyword OR firstname LIKE :keyword OR lastname LIKE :keyword OR email LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY CUSTOMER_ID ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="customer_create.php" class="btn btn-primary m-b-1em">Create New Customer</a>
        </div>';

        echo '<div class="p-3 pb-1">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search customer..." value="' . str_replace('%', '', $searchKeyword) . '">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>';

        include 'menu/delete_alert_box.php';

        if($num > 0){
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";//start table
                    echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Username</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Email</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr>";
                            echo "<td>{$Customer_ID}</td>";
                            echo "<td>{$username}</td>";
                            echo "<td>{$firstname}</td>";
                            echo "<td>{$lastname}</td>";
                            echo "<td>{$email}</td>";
                            echo "<td>{$status}</td>";
                
                            echo "<td class='col-3'>";
                                echo "<a href='customer_read_one.php?id={$Customer_ID}' class='btn btn-info m-r-1em text-white mx-2'>Read</a>";
                                echo "<a href='customer_update.php?id={$Customer_ID}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                                echo "<a href='#' onclick='customer_delete({$Customer_ID});'  class='btn btn-danger mx-2'>Delete</a>";
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
    function customer_delete(Customer_ID){
        if (confirm('Are you sure?')){
            // if user clicked ok, pass the id to delete.php and execute the delete query
            window.location = 'customer_delete.php?id=' + Customer_ID;
        }
    }
    </script>
</body>
</html>

