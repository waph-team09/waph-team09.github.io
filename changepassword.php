<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Change Result</title>
    <style>
        body {
            background-color: #dcdcdc; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background-color: #afeeee;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .back-to-login {
            display: inline-block;
            padding: 10px 20px;
            background-color: #7fffd4;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <p>
        <?php
        
    include 'database.php';
    include "session_auth.php";
    session_start();
    get_session_values();

    validatesession();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = isset($_POST["nocsrftoken"]) ? $_POST["nocsrftoken"] : null;
        if (!validateCSRFToken($token)) {
            echo "CSRF Attack detected";
            exit();
        }

        $oldPassword = $_POST['old_password'];
        $newPassword = $_POST['password'];

        if (empty($oldPassword) || empty($newPassword)) {
            echo "All fields are required!";
            exit();
        }
        $username = $_SESSION['username'];

        if (!checklogin_mysql($username, $oldPassword)) {
            echo "Incorrect old password";
            exit();
        }

        updateUserPassword($username, $newPassword);
        
        echo "Password changed successfully";
    }
    ?>
        </p>
        <a href="form.php" class="back-to-login">Back to Login</a>
    </div>
</body>
</html>
