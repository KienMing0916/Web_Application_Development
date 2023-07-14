<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>List of Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Products</h1>
        </div>
     
        <?php
        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT id, name, description, price, promotion_price FROM products";
        if (!empty($searchKeyword)) {
            $query .= " WHERE name LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY id ASC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="product_create.php" class="btn btn-primary m-b-1em">Create New Product</a>
        </div>';

        echo '<div class="p-3">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search product..." value="' . str_replace('%', '', $searchKeyword) . '">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>';
        
        if($num > 0){
        
            echo "<div class='p-3'>";
                echo "<table class='table table-hover table-responsive table-bordered'>";//start table
                echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Description</th>";
                    echo "<th>Price</th>";
                    echo "<th>Action</th>";
                echo "</tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>{$description}</td>";
                        if ($promotion_price < $price && ($promotion_price != 0)){
                            echo"<td class='d-flex justify-content-end'>
                                    <p class='text-decoration-line-through mx-1'>" . number_format((float)$price, 2, '.', '') . "</p>
                                    <p>" . number_format((float)$promotion_price, 2, '.', '') . "</p>
                                </td>";
                        }else{
                            echo "<td class='text-end'>" . number_format((float)$price, 2, '.', '') . "</td>";
                        }
                        echo "<td class='col-3'>";
                            echo "<a href='product_read_one.php?id={$id}' class='btn btn-info m-r-1em text-white mx-2'>Read</a>";
                            echo "<a href='product_update.php?id={$id}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                            echo "<a href='#' onclick='delete_product({$id});'  class='btn btn-danger mx-2'>Delete</a>";
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
