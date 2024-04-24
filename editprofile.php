<?php
include 'session_auth.php';
include 'database.php';
session_start();
validatesession();


$username = $_SESSION['username'];
$userDetails = getUserDetails($username);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = isset($_POST["nocsrftoken"]) ? $_POST["nocsrftoken"] : null;
    if (!validateCSRFToken($token)) {
        echo "CSRF Attack detected";
        exit();
    }

    $fullName = $_POST['full_name'];
    $phoneNumber = $_POST['phone_number'];

    if (empty($fullName) || empty($phoneNumber)) {
        echo "All fields are required!";
        exit();
    }

    $username = $_SESSION['username'];

    updateUserProfile($username, $fullName, $phoneNumber);
    
    echo "Profile updated successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #bdb76b;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        form {
            background: cornsilk;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px; 
        }
        h2 {
            text-align: center;
            color: #333;
        }
        div {
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="phone"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #7fffd4;
            color: black;
            cursor: pointer;
        }
        a {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Edit Profile</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <input type="hidden" name="nocsrftoken" value="<?php echo $_SESSION["nocsrftoken"]; ?>">
        <div>
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo $userDetails['full_name']; ?>" required>
        </div>
        <div>
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $userDetails['phone_number']; ?>" required>
        </div>
        <div>
            <input type="submit" value="Update Profile">
        </div>
    </form>
    <a href="index.php">Home</a>
</body>
</html>
