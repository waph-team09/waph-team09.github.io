<?php

require 'session_auth.php';
require 'database.php';

createnewsession();


if (isset($_POST["username"]) and isset($_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $loginResult = checklogin_mysql($username, $password);

    if ($loginResult === true) {
        regenerateSession();
        authenticatesession($_POST["username"]);
        $_SESSION['user_id']=getuserid($_POST["username"]);
        $_SESSION['fullname']=getName($_POST["username"]);
        debug_to_console("Session Authenticated");
    } else {
        session_destroy();
        echo "<script>alert('$loginResult');window.location='form.php';</script>";
        die();
    }
}
validatesession();
// get_session_values();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #8fbc8f;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #f0fff0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            text-decoration: none; 
        }
        .btn-primary {
            color: black;
            background-color: #fa8072;
            border-color: #007bff;
        }
        .btn-danger {
            color: black;
            background-color: #6b8e23;
            border-color: #dc3545;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h2>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</h2>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <a href="newpost.php" class="btn btn-primary mr-2">Add New Post</a>
                <a href="viewposts.php" class="btn btn-primary mr-2">View User Posts</a>
                <a href="changepasswordform.php" class="btn btn-primary mr-2">Change Password</a>
                <a href="editprofile.php" class="btn btn-primary mr-2">Edit Your Profile</a>
                <div class="text-right">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
