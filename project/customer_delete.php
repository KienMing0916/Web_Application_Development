<?php
include 'config/database.php';
try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    //select query 
    $findCustomerQuery = "SELECT COUNT(*) FROM order_summary WHERE Customer_ID = ?";
    $findCustomerStmt = $con->prepare($findCustomerQuery);
    $findCustomerStmt->bindParam(1, $id);
    $findCustomerStmt->execute();
    $result = $findCustomerStmt->fetchColumn();
    // Select query to retrieve profile image filename
    $getProfileImageQuery = "SELECT profile_image FROM customers WHERE Customer_ID = ?";
    $getProfileImageStmt = $con->prepare($getProfileImageQuery);
    $getProfileImageStmt->bindParam(1, $id);
    $getProfileImageStmt->execute();
    $row = $getProfileImageStmt->fetch(PDO::FETCH_ASSOC);
    $uploadedImage = $row['profile_image'];
    // delete query
    $deleteCustomerQuery = "DELETE FROM customers WHERE Customer_ID = ?";
    $deleteCustomerStmt = $con->prepare($deleteCustomerQuery);
    $deleteCustomerStmt->bindParam(1, $id);

    if($result != 0){
        header('Location: customer_read.php?action=customer_in_use&result=' . $result);
    }else{
        if($deleteCustomerStmt->execute()){
            if ($uploadedImage !== 'uploaded_customer_img/defaultcustomerimg.jpg') {
                if (file_exists($uploadedImage)) {
                    unlink($uploadedImage);
                }
            }
            header('Location: customer_read.php?action=deleted');
        }else{
            die('Unable to delete record.');
        }
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

