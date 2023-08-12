<?php
include 'config/database.php';
try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    //select query 
    $findProductCategoryQuery = "SELECT COUNT(*) FROM products WHERE Category_ID = ?";
    $findProductCategoryStmt = $con->prepare($findProductCategoryQuery);
    $findProductCategoryStmt->bindParam(1, $id);
    $findProductCategoryStmt->execute();
    $result = $findProductCategoryStmt->fetchColumn();
    // delete query
    $deleteProductCategoryQuery = "DELETE FROM categories WHERE Category_ID = ?";
    $deleteProductCategoryStmt = $con->prepare($deleteProductCategoryQuery);
    $deleteProductCategoryStmt->bindParam(1, $id);

    if($result != 0){
        header('Location: category_read.php?action=category_in_use&result=' . $result);
    }else{
        if($deleteProductCategoryStmt->execute()){
            header('Location: category_read.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

