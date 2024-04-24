<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            background-color: #cd5c5c;
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        .btn {
            background-color: #ffb6c1;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .registration-text {
            margin-bottom: 20px;
        }

        .image-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>
            <?php

            include 'session_auth.php';
            include 'database.php';
            session_start();

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $token = isset($_POST["nocsrftoken"]) ? $_POST["nocsrftoken"] : null;
                if (!validateCSRFToken($token)) {
                    echo "CSRF Attack detected";
                    exit();
                }

                $usr_regex = "/\w+/xm";
                $pwd_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$/xm";
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $name = $_POST['name'];


                if (!preg_match($pwd_regex, $password)) {
                    echo "RegEX Failed for Password";
                }

                if (!preg_match($usr_regex, $name)) {
                    echo "RegEX Failed for Name";
                }

                $email = sanitize_input($email);
                $password = sanitize_input($password);
                $username  = sanitize_input($username);
                $name = sanitize_input($name);

                if (empty($username) || empty($password) || empty($email) || empty($name)) {
                    echo "All fields are required!";
                    exit();
                }

                addUser($username, $password, $email, $name);

                echo "Registration succeeded, you can now login to the system";
            }
            ?>
        </p>
        <div class="image-container">
            <img src="https://t3.ftcdn.net/jpg/02/91/52/22/360_F_291522205_XkrmS421FjSGTMRdTrqFZPxDY19VxpmL.jpg" alt="Registration Succeeded" style="width: 300px; height: auto;">
        </div>
        <a href="form.php" class="btn">Click to Login</a>
    </div>
</body>

</html>