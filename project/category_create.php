<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Add New Category</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>  
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Create Category</h1>
        </div>
      
        <?php
        if($_POST){
            include 'config/database.php';
            include 'menu/validate_function.php';
            
            try{
                $query = "INSERT INTO categories SET category_name=:category_name, description=:description";
                $stmt = $con->prepare($query);
                $category_name = $_POST['category_name'];
                $description = $_POST['description'];

                // Check if the category name already exists
                $checkQuery = "SELECT COUNT(*) FROM categories WHERE category_name = :category_name";
                $checkStmt = $con->prepare($checkQuery);
                $checkStmt->bindParam(':category_name', $category_name);
                $checkStmt->execute();
                $checkCount = $checkStmt->fetchColumn();

                $errorMessage = validateCategoryForm($category_name, $description, $checkCount);

                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    $stmt->bindParam(':category_name', $category_name);
                    $stmt->bindParam(':description', $description);

                    if ($stmt->execute()) {
                        //record saved
                        $category_id = $con->lastInsertId();
                        header("Location: category_read_one.php?id={$category_id}&action=record_saved");
                        exit();
                    } else {
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
            <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
                <table class='table table-hover table-responsive table-bordered'>
                    <tr>
                        <td class="col-4">Category Name</td>
                        <td class="col-8"><input type='text' name='category_name' id='category_name' class='form-control' maxlength="50" value="<?php echo isset($_POST['category_name']) ? $_POST['category_name'] : ''; ?>" /></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><textarea name='description' id='description' class='form-control' maxlength="200"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type='submit' value='Save' class='btn btn-primary' />
                            <a href='category_read.php' class='btn btn-danger'>Back to category list</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

