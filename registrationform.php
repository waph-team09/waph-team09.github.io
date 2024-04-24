<?php
include 'session_auth.php';
include 'database.php';
session_start();

$_SESSION["nocsrftoken"] = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #db7093;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            background-color: #eee8aa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #9370db;
            color: black;
            cursor: pointer;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>User Registration</h2>
                <form action="addnewuser.php" method="POST">
                    <input type="hidden" name="nocsrftoken" value="<?php echo $_SESSION["nocsrftoken"]; ?>">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$" title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 lowercase, and 1 UPPERCASE" required onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:''); form.repassword.pattern = this.value;">                    
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm Password:</label>
                        <input type="password" id="repassword" name="repassword" required title="Password does not match" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: '');">
                    </div>
                    <div class="text-center">
                        <button type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center" style="margin-top: 20px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Cincinnati_University_Bearcats_textlogo.svg/1280px-Cincinnati_University_Bearcats_textlogo.svg.png" alt="University of Cincinnati Bearcats Logo" style="max-width: 100%; height: auto;">
        
    </div>
</body>
</html>
