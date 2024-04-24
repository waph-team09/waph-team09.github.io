<?php
 
function validatesudosession(){
    if(!$_SESSION["authenticated"] or $_SESSION["authenticated"] !=TRUE){
        session_destroy();
        echo "<script>alert('You are not authorised. Press Ok to LOGIN.');</script>";
        header("Refresh:0; url=form.php");
        die();
    }
    if($_SESSION['browser_metadata'] != $_SERVER['HTTP_USER_AGENT'] or $_SESSION['ip_address'] != $_SERVER['REMOTE_ADDR']){
        echo "<script>alert('Session Hijacking Detected');</script>";
        header("Refresh:0; url=form.php");
        die();
    }
}
function closesession(){
    session_destroy();
    echo "<script>alert('You have been logged out');</script>";
    header("Refresh:0; url=form.php");
    die();
}

function createsudosession(){
    $lifetime = 15 * 60;
    $path = "/sudo";
    $domain = "waph-team09.minifacebook.com";
    $secure = true;
    $httponly = true;
    session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    session_start();
}

function regenerateSudoSession(){
    session_destroy();
    createsudosession();
    session_regenerate_id(true);
}
function authenticateSudoSession($username){
    $_SESSION["nocsrftoken"] = generateCSRFToken();
    $_SESSION["authenticated"] = TRUE;
    $_SESSION["username"] = $username;
    $_SESSION["superuser"] = $username;
    $_SESSION['browser_metadata'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ip_address'] = $_SERVER["REMOTE_ADDR"];
}
?>