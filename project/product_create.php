<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Add New Product</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>  
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Create Product</h1>
        </div>
      
        <?php
        if($_POST){
            include 'config/database.php';
            include 'menu/validate_function.php';

            try{
                //query for insert
                $query = "INSERT INTO products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date, created=:created, Category_ID=:category_id, product_image=:image";
                $stmt = $con->prepare($query);

                $name = $_POST['name'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $promotion_price = $_POST['promotion_price'];
                $manufacture_date = $_POST['manufacture_date'];
                $expired_date = $_POST['expired_date'];
                $category_id = $_POST['category_id'];
                //Datetime objects
                $dateStart = new DateTime($manufacture_date);
                $dateEnd = new DateTime($expired_date);
                //image field
                $image = !empty($_FILES["image"]["name"]) ? "uploaded_product_img/" . sha1_file($_FILES['image']['tmp_name']) . basename($_FILES["image"]["name"]) : "uploaded_product_img/defaultproductimg.jpg";
                $image = htmlspecialchars(strip_tags($image));

                $errorMessage = validateProductForm($name, $description, $price, $promotion_price, $manufacture_date, $expired_date, $category_id, $image);

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    // format to two decimal places
                    $price = number_format((float)$price, 2);
                    $promotion_price = number_format((float)$promotion_price, 2);

                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $promotion_price);
                    $stmt->bindParam(':manufacture_date', $manufacture_date);
                    $stmt->bindParam(':expired_date', $expired_date);
                    $stmt->bindParam(':image', $image);
                    $created = date('Y-m-d H:i:s'); // get the current date and time
                    $stmt->bindParam(':created', $created);
                    $stmt->bindParam(':category_id', $category_id);
                    
                    // Execute the query
                    if ($stmt->execute()) {
                        //record saved
                        $product_id = $con->lastInsertId();
                        header("Location: product_read_one.php?id={$product_id}&action=record_saved");
                        exit();
                    }else {
                        echo "<div class='alert alert-danger m-3'>Unable to save the record.</div>";
                    }
                }
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <div class="p-3">
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST" enctype="multipart/form-data">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="col-4">Name</td>
                        <td class="col-8"><input type='text' name='name' id='name' class='form-control' maxlength="50" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' id='description' class='form-control' maxlength="150"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Selling Price (RM)</td>
                        <td><input type='number' name='price'  id='price' class='form-control' step="0.01" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Promotion Price (RM)</td>
                        <td><input type='number' name='promotion_price' id='promotion_price' class='form-control' step="0.01" value="<?php echo isset($_POST['promotion_price']) ? $_POST['promotion_price'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Manufacture Date</td>
                        <td><input type='date' name='manufacture_date' class='form-control' value="<?php echo isset($_POST['manufacture_date']) ? $_POST['manufacture_date'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Expired Date</td>
                        <td><input type='date' name='expired_date' class='form-control' value="<?php echo isset($_POST['expired_date']) ? $_POST['expired_date'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>
                            <select name="category_id" class="form-select">
                                <option value="" selected hidden>Choose a category</option>
                                <?php
                                    include 'config/database.php';
                                    // Fetch categories from the database
                                    $categoryQuery = "SELECT Category_ID, category_name FROM categories";
                                    $categoryStmt = $con->prepare($categoryQuery);
                                    $categoryStmt->execute();

                                    while ($row = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
                                        $categoryID = $row['Category_ID'];
                                        $categoryName = $row['category_name'];
                                        $selected = (isset($_POST['category_id']) && $_POST['category_id'] == $categoryID) ? 'selected' : '';
                                        echo "<option value='$categoryID' $selected>$categoryName</option>";
                                    }                       
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Product Image</td>
                        <td><input type="file" name="image" class="form-control" accept="image/*"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='product_read.php' class='btn btn-danger'>Back to product list</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

