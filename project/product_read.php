<?php
include 'menu/validate_login.php';
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
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Products</h1>
        </div>
     
        <?php
        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT products.Product_ID, products.name, products.description, products.price, products.promotion_price, categories.category_name, products.product_image 
                  FROM products INNER JOIN categories ON products.Category_ID = categories.Category_ID";

        if (!empty($searchKeyword)) {
            $query .= " WHERE products.name LIKE :keyword OR categories.category_name LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY products.Product_ID DESC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="product_create.php" class="btn btn-primary m-b-1em">Create New Product</a>
        </div>';

        echo '<div class="p-3 pb-1">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search product..." value="' . str_replace('%', '', $searchKeyword) . '">
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
                    echo "<th class='col-2'>Product Name</th>";
                    echo "<th class='col-1'>Product Image</th>";
                    echo "<th>Description</th>";
                    echo "<th>Selling Price (RM)</th>";
                    echo "<th class='col-1'>Category Name</th>";
                    echo "<th>Action</th>";
                echo "</tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<td>{$Product_ID}</td>";
                        echo "<td>{$name}</td>";
                        echo "<td>";
                            echo "<img src='" . htmlspecialchars($product_image, ENT_QUOTES) . "' alt='" . htmlspecialchars($name, ENT_QUOTES) . "' width='100' height='100'>";
                        echo "</td>";
                        echo "<td>{$description}</td>";
                        // line 75 d-flex justify-content-center can't write to td, otherwise it won't take full height of td
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
                        echo "<td>{$category_name}</td>";
                        echo "<td class='col-3'>";
                            echo "<a href='product_read_one.php?id={$Product_ID}' class='btn btn-info m-r-1em text-white mx-2'>Read</a>";
                            echo "<a href='product_update.php?id={$Product_ID}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                            echo "<a href='#' onclick='product_delete({$Product_ID});'  class='btn btn-danger mx-2'>Delete</a>";
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
    function product_delete(Product_ID){
        if (confirm('Are you sure to delete this product?')){
            // if user clicked ok, pass the id to delete.php and execute the delete query
            window.location = 'product_delete.php?id=' + Product_ID;
        }
    }
    </script>
</body>
</html>
