<?php
include 'database.php';
include "session_auth.php";
session_start();
validatesession();
get_session_values();   


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $username = $_SESSION['username'];
    

    addPost($title, $content,$username);
    header("Location: viewposts.php");
    exit();
}
?>