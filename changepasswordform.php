<?php

include 'database.php';
include 'session_auth.php';
session_start();
validatesession();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f5deb3;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #ffe4e1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
        }
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: black;
            background-color: #8fbc8f;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <form action="changepassword.php" method="POST">
            <input type="hidden" name="nocsrftoken" value="<?php echo $_SESSION["nocsrftoken"]; ?>">
            <div>
                <label for="old_password">Old Password:</label>
                <input type="password" id="old_password" name="old_password" required>
            </div>
            <div>
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$" title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE" required onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:''); form.repassword.pattern = this.value;">                    
            </div>
            <div>
                <label for="repassword">Confirm Password:</label>
                <input type="password" id="repassword" name="repassword" required title="Password does not match" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');">
            </div>
            <div>
                <input type="submit" value="Change Password">
            </div>
            <div>
                <a href="index.php">Go back</a>
            </div>
        </form>
    </div>
</body>
</html>
