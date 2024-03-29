<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Product Details</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Product Details</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'record_saved') {
            echo "<div class='alert alert-success m-3'>Product record was saved.</div>";
        }

        if ($action == 'record_updated') {
            echo "<div class='alert alert-success m-3'>Product record was updated.</div>";
        }

        if ($action == 'image_deleted') {
            echo "<div class='alert alert-success m-3'>Product image was deleted.</div>";
        }

        include 'config/database.php';
        try {
            // prepare select query
            $query = "SELECT products.Product_ID, products.name, products.description, products.price, products.promotion_price, products.manufacture_date, products.expired_date, products.product_image, products.Category_ID, categories.category_name 
            FROM products INNER JOIN categories ON products.Category_ID = categories.Category_ID WHERE products.Product_ID =:id";
            
            $stmt = $con->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $image = $row['product_image'];
            $category_id = $row['Category_ID'];
            $category_name = $row['category_name'];
        }
        
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        
        <div class="p-3">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class='col-3'>Product Name</td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Selling Price (RM)</td>
                    <td><?php echo htmlspecialchars(number_format((float)$price, 2, '.', ''), ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Promotion Price (RM)</td>
                    <td>
                        <?php
                        if ($promotion_price == "0") {
                            echo '-';
                        } else {
                            echo htmlspecialchars(number_format((float)$promotion_price, 2, '.', ''), ENT_QUOTES);
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Category ID</td>
                    <td><?php echo htmlspecialchars($category_id, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Category Name</td>
                    <td><?php echo htmlspecialchars($category_name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Product Image</td>
                    <td>
                        <img src="<?php echo htmlspecialchars($image, ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" width="200" height="200">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='product_read.php' class='btn btn-danger'>Back to product list</a>
                    </td>
                </tr>
            </table>
        </div>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

