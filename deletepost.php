<?php
include 'session_auth.php';
include 'database.php';

session_start();
validatesession();
get_session_values();

$token = isset($_GET["nocsrftoken"]) ? $_GET["nocsrftoken"] : null;
if (!validateCSRFToken($token)) {
    echo "CSRF Attack detected";
    exit();
}
else{
    if (!isset($_GET['id'])) {
        header("Location: viewposts.php");
        exit();
    }
    
    $postId = $_GET['id'];
    
    $post = getPostById($postId);
    
    
    deletePost($postId);
    
    header("Location: viewposts.php");
    exit();
}


?>
