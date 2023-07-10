<!DOCTYPE HTML>
<html>
<head>
    <title>List of Customers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Customers</h1>
        </div>
     
        <?php
        // include database connection
        include 'config/database.php';

        $query = "SELECT Customer_ID, username, firstname, lastname, status FROM customers ORDER BY CUSTOMER_ID ASC";
        $stmt = $con->prepare($query);
        $stmt->execute();
        
        // this is how to get number of rows returned
        $num = $stmt->rowCount();
        // link to create record form
        echo '<div class="p-3 pt-2">
            <a href="customer_create.php" class="btn btn-primary m-b-1em">Create New Customer</a>
        </div>';

        if($num > 0){
        
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";//start table
                    echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Username</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Status</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                    // retrieve our table contents
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        // creating new table row per record
                        echo "<tr>";
                            echo "<td>{$Customer_ID}</td>";
                            echo "<td>{$username}</td>";
                            echo "<td>{$firstname}</td>";
                            echo "<td>{$lastname}</td>";
                            echo "<td>{$status}</td>";
                
                            echo "<td class='col-3'>";
                                echo "<a href='customer_read_one.php?id={$Customer_ID}' class='btn btn-info m-r-1em text-white mx-2'>Read</a>";
                                echo "<a href='customer_update.php?id={$Customer_ID}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                                echo "<a href='#' onclick='customer_product({$Customer_ID});'  class='btn btn-danger mx-2'>Delete</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            echo "</div>";    
        }else{
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

