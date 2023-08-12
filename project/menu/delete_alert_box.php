<?php
$action = isset($_GET['action']) ? $_GET['action'] : "";
$result = isset($_GET['result']) ? $_GET['result'] : "";

if ($action == 'deleted') {
    echo "<div class='alert alert-success m-3'>Record was deleted.</div>";
}
if ($action == 'customer_in_use') {
    echo "<div class='alert alert-danger m-3'>This customer is associated with " . $result . " " . ($result == 1 ? "order" : "orders") . ", deletion cannot proceed.</div>";
}
if ($action == 'product_in_use') {
    echo "<div class='alert alert-danger m-3'>This product is associated with " . $result . " " . ($result == 1 ? "order" : "orders") . ", deletion cannot proceed.</div>";
}
if ($action == 'category_in_use') {
    echo "<div class='alert alert-danger m-3'>This product category is associated with " . $result . " " . ($result == 1 ? "product" : "products") . ", deletion cannot proceed.</div>";
}
?>