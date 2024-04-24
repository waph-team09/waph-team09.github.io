<?php
include 'sudodatabase.php';
include 'sudosession_auth.php';

session_start();

validatesudosession();
if (!isset($_SESSION['superuser'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $userId = $_GET['id'];
    if (enableUser($userId)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Failed to enable user.";
    }
}


?>
