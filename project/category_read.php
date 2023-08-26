<?php
include 'menu/validate_login.php';
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>List of Categories</title>
    <link href="css/style.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container p-0 bg-light">
        <?php
            include 'menu/nav.php';
        ?>

        <div class="page-header p-3 pb-1">
            <h1>Read Categories</h1>
        </div>
     
        <?php
        include 'config/database.php';

        $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
        $query = "SELECT Category_ID, category_name, description FROM categories";
        if (!empty($searchKeyword)) {
            $query .= " WHERE category_name LIKE :keyword";
            $searchKeyword = "%{$searchKeyword}%";
        }
        $query .= " ORDER BY Category_ID DESC";
        $stmt = $con->prepare($query);
        if (!empty($searchKeyword)) {
            $stmt->bindParam(':keyword', $searchKeyword);
        }

        $stmt->execute();
        $num = $stmt->rowCount();

        echo '<div class="p-3 pt-2">
            <a href="category_create.php" class="btn btn-primary m-b-1em">Create New Category</a>
        </div>';

        echo '<div class="p-3 pb-1">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search category..." value="' . str_replace('%', '', $searchKeyword) . '">
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
                    echo "<th>Category Name</th>";
                    echo "<th>Description</th>";
                    echo "<th>Action</th>";
                echo "</tr>";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<tr>";
                        echo "<td>{$Category_ID}</td>";
                        echo "<td class='col-2'><a href='category_read_one.php?id={$Category_ID}' class='item-link'>{$category_name}</a></td>";
                        echo "<td>{$description}</td>";

                        echo "<td class='col-3'>";
                            echo "<a href='category_read_one.php?id={$Category_ID}' class='btn btn-info m-r-1em text-white mx-2'>Read</a>";
                            echo "<a href='category_update.php?id={$Category_ID}' class='btn btn-primary m-r-1em mx-2'>Edit</a>";
                            echo "<a href='#' onclick='category_delete({$Category_ID});'  class='btn btn-danger mx-2'>Delete</a>";
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
    function category_delete(Category_ID){
        if (confirm('Are you sure to delete this product category?')){
            // if user clicked ok, pass the id to delete.php and execute the delete query
            window.location = 'category_delete.php?id=' + Category_ID;
        }
    }
    </script>
</body>
</html>
