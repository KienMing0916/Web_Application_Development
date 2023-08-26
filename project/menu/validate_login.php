<?php
session_start();
if (!isset($_SESSION['Customer_ID'])) {
    header("Location: login.php?action=warning");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>