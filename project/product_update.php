<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>

<html>
<head>
    <title>Update Product Details</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Update Product</h1>
        </div>

        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        include 'config/database.php';

        try {
            // prepare select query
            $query = "SELECT Product_ID, name, description, price, promotion_price, manufacture_date, expired_date, Category_ID, product_image FROM products WHERE Product_ID = ? LIMIT 0,1";
            $stmt = $con->prepare($query);
            // this is the first question mark
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
            $category_id = $row['Category_ID'];
            $uploadedImage = $row['product_image'];
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        if($_POST){
            include 'menu/validate_function.php';

            try{
                if(isset($_POST['delete_image'])){
                    if($uploadedImage === 'uploaded_product_img/defaultproductimg.jpg'){
                        echo "<div class='alert alert-danger m-3'>No product image found.</div>";
                    }else{
                        $defaultImage = 'uploaded_product_img/defaultproductimg.jpg';
                        $queryDeleteImg = "UPDATE products SET product_image=:image WHERE Product_ID = :id";
                        $deleteImgStmt = $con->prepare($queryDeleteImg);
                        $deleteImgStmt->bindParam(':id', $id);
                        $deleteImgStmt->bindParam(':image', $defaultImage);
                        $deleteImgStmt->execute();
    
                        if($deleteImgStmt->execute()){
                            // delete image file
                            if ($uploadedImage !== 'uploaded_product_img/defaultproductimg.jpg') {
                                if (file_exists($uploadedImage)) {
                                    unlink($uploadedImage);
                                }
                            }
                            // record deleted
                            header("Location: product_read_one.php?id={$id}&action=image_deleted");
                            exit();
                        }else{
                            echo "<div class='alert alert-danger m-3'>Unable to delete product image. Please try again.</div>";
                        }    
                    }       

                }else{
                    $query = "UPDATE products SET name=:name, description=:description, price=:price, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date, Category_ID=:category_id, product_image=:image WHERE Product_ID = :id";
                    $stmt = $con->prepare($query);
                    // posted values
                    $name = htmlspecialchars(strip_tags($_POST['name']));
                    $description = htmlspecialchars(strip_tags($_POST['description']));
                    $price = htmlspecialchars(strip_tags($_POST['price'])); 
                    $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                    $manufacture_date = htmlspecialchars(strip_tags($_POST['manufacture_date']));
                    $expired_date = htmlspecialchars(strip_tags($_POST['expired_date'])); 
                    $category_id = htmlspecialchars(strip_tags($_POST['category_id'])); 
                    // image field
                    $image = !empty($_FILES["image"]["name"]) ? "uploaded_product_img/" . sha1_file($_FILES['image']['tmp_name']) . basename($_FILES["image"]["name"]) : "";
                    $image = htmlspecialchars(strip_tags($image));
    
                    $errorMessage = validateProductForm($name, $description, $price, $promotion_price, $manufacture_date, $expired_date, $category_id, $image);
    
                    if(!empty($errorMessage)) {
                        echo "<div class='alert alert-danger m-3'>";
                            foreach ($errorMessage as $displayErrorMessage) {
                                echo $displayErrorMessage . "<br>";
                            }
                        echo "</div>";
                    }else {
                        $price = number_format((float)$price, 2);   
                        $promotion_price = number_format((float)$promotion_price, 2);
                        $stmt->bindParam(':id', $id);
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':price', $price);
                        $stmt->bindParam(':promotion_price', $promotion_price);
                        $stmt->bindParam(':manufacture_date', $manufacture_date);
                        $stmt->bindParam(':expired_date', $expired_date);
                        $stmt->bindParam(':category_id', $category_id);

                        if($image === ""){
                            $stmt->bindParam(':image', $uploadedImage);
                        }else{
                            $stmt->bindParam(':image', $image);
                        }
    
                        if ($uploadedImage !== 'uploaded_product_img/defaultproductimg.jpg' && $image !== $uploadedImage) {
                            // Remove the existing image
                            if (file_exists($uploadedImage) && $image !== "") {
                                unlink($uploadedImage);
                            }
                        }

                        // Execute the query
                        if($stmt->execute()){
                            // record updated
                            header("Location: product_read_one.php?id={$id}&action=record_updated");
                            exit();
                        }else{
                            echo "<div class='alert alert-danger m-3'>Unable to update record. Please try again.</div>";
                        }  
                    }   
                }    
                
            }catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form class="p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class="col-4">Name</td>
                    <td><input type='text' name='name' maxlength="50" value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control' maxlength="150"><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Selling Price (RM)</td>
                    <td><input type='number' name='price' step="0.01" value="<?php echo htmlspecialchars(number_format((float)$price, 2, '.', ''), ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>

                <tr>
                    <td>Promotion Price (RM)</td>
                    <td><input type='number' name='promotion_price' step="0.01" value="<?php echo htmlspecialchars(number_format((float)$promotion_price, 2, '.', ''), ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo htmlspecialchars($manufacture_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' value="<?php echo htmlspecialchars($expired_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <select name="category_id" class="form-select" readonly>
                            <?php
                            include 'config/database.php';
                            // Fetch categories from the database
                            $categoryQuery = "SELECT Category_ID, category_name FROM categories";
                            $categoryStmt = $con->prepare($categoryQuery);
                            $categoryStmt->execute();

                            while ($row = $categoryStmt->fetch(PDO::FETCH_ASSOC)) {
                                $categoryIDFromCategoriesTable = $row['Category_ID'];
                                $categoryName = $row['category_name'];

                                $selected = ($categoryIDFromCategoriesTable == $category_id) ? 'selected' : '';
                                echo "<option value='" . htmlspecialchars($categoryIDFromCategoriesTable, ENT_QUOTES) . "' $selected>" . htmlspecialchars($categoryName, ENT_QUOTES) . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Product Image</td>
                    <td>
                        <img src="<?php echo htmlspecialchars($uploadedImage, ENT_QUOTES); ?>" width="200" height="200">
                        <br><br>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <button type="submit" name="delete_image" class="btn btn-secondary">Delete product image</button>
                        <a href='product_read.php' class='btn btn-danger'>Back to product list</a>
                    </td>
                </tr>
            </table>
        </form>     
   </div> 
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

