<?php
include 'config/database.php';
try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    //select query 
    $findProductQuery = "SELECT COUNT(*) FROM order_details WHERE Product_ID = ?";
    $findProductStmt = $con->prepare($findProductQuery);
    $findProductStmt->bindParam(1, $id);
    $findProductStmt->execute();
    $result = $findProductStmt->fetchColumn();
    // delete query
    $deleteProductQuery = "DELETE FROM products WHERE Product_ID = ?";
    $deleteProductStmt = $con->prepare($deleteProductQuery);
    $deleteProductStmt->bindParam(1, $id);

    if($result != 0){
        header('Location: product_read.php?action=product_in_use&result=' . $result);
    }else{
        if($deleteProductStmt->execute()){
            header('Location: product_read.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

