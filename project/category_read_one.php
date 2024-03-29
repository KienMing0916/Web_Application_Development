<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Category Details</title>
    <link rel="icon" type="image/x-icon" href="img/factorylogo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Category Details</h1>
        </div>
         
        <?php
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'record_saved') {
            echo "<div class='alert alert-success m-3'>Category record was saved.</div>";
        }

        if ($action == 'record_updated') {
            echo "<div class='alert alert-success m-3'>Category record was updated.</div>";
        }

        include 'config/database.php';
        try {
            // prepare select query
            $query = "SELECT Category_ID, category_name, description FROM categories WHERE Category_ID = :id ";
            $stmt = $con->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $name = $row['category_name'];
            $description = $row['description'];
        }
        
        catch(PDOException $exception){
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        
        <div class="p-3">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Category Name</td>
                    <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='category_read.php' class='btn btn-danger'>Back to category list</a>
                    </td>
                </tr>
            </table>
        </div>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

