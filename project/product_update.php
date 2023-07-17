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
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
       .m-r-1em{ margin-right:1em; }
       .m-b-1em{ margin-bottom:1em; }
       .m-l-1em{ margin-left:1em; }
       .mt0{ margin-top:0; }
    </style>
</head>
<body>
    <div class="container">
        <?php
            include 'menu/menu.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Update Product</h1>
        </div>

        <?php
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
            include 'config/database.php';
        try {
            // prepare select query
            $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );
            // this is the first question mark
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
        }
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <?php
        if($_POST){
            try{
                $query = "UPDATE products SET name=:name, description=:description, price=:price WHERE id = :id";
                $stmt = $con->prepare($query);
                // posted values
                $name=htmlspecialchars(strip_tags($_POST['name']));
                $description=htmlspecialchars(strip_tags($_POST['description']));
                $price=htmlspecialchars(strip_tags($_POST['price'])); 

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':id', $id);
                // Execute the query
                if($stmt->execute()){
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }         
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>     
   </div> 
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

