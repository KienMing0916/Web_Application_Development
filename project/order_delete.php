<?php
include 'config/database.php';
try {     
    $id=isset($_GET['id']) ? $_GET['id'] :  die('ERROR: Record ID not found.');
    // delete query
    $deleteOrderQuery ="DELETE order_summary, order_details FROM order_summary INNER JOIN order_details ON order_summary.Order_ID = order_details.Order_ID WHERE order_summary.Order_ID = ?";
    $deleteOrderStmt = $con->prepare($deleteOrderQuery);
    $deleteOrderStmt->bindParam(1, $id);

    if ($deleteOrderStmt->execute()) {
        header('Location: order_read.php?action=deleted');
    } else {
        die('Unable to delete record.');
    }
}
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

