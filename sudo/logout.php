<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            background-color: #f4f4f4; 
            color: #000000; 
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message {
            padding: 20px;
            background-color: bisque;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?php
    include 'sudodatabase.php';
    include "sudosession_auth.php";
    session_start();
    get_session_values();
    closesession();
    ?>
    <div class="message">
        <p>You have been logged out successfully.</p>
    </div>
</body>
</html>
