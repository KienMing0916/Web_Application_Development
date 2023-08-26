<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>

<html>
<head>
    <title>Update Category Details</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Update Category</h1>
        </div>

        <?php
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
            include 'config/database.php';
        try {
            $query = "SELECT Category_ID, category_name, description FROM categories WHERE Category_ID = ? LIMIT 0,1";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $category_name = $row['category_name'];
            $description = $row['description'];
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        if($_POST){
            include 'menu/validate_function.php';
            
            try{
                $query = "UPDATE categories SET category_name=:category_name, description=:description WHERE Category_ID = :id";
                $stmt = $con->prepare($query);

                $category_name = htmlspecialchars(strip_tags($_POST['category_name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));

                $errorMessage = validateCategoryForm($category_name, $description);


                if(!empty($errorMessage)) {
                    echo "<div class='alert alert-danger m-3'>";
                        foreach ($errorMessage as $displayErrorMessage) {
                            echo $displayErrorMessage . "<br>";
                        }
                    echo "</div>";
                }else {
                    $stmt->bindParam(':category_name', $category_name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':id', $id);
                    // Execute the query
                    if($stmt->execute()){
                        // record updated
                        header("Location: category_read_one.php?id={$id}&action=record_updated");
                        exit();
                    }else{
                        echo "<div class='alert alert-danger m-3'>Unable to update record. Please try again.</div>";
                    }  
                }       
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form class="p-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td class="col-4">Category Name</td>
                    <td><input type='text' name='category_name' value="<?php echo htmlspecialchars($category_name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='category_read.php' class='btn btn-danger'>Back to category list</a>
                    </td>
                </tr>
            </table>
        </form>     
   </div> 
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

