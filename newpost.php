<?php
include 'database.php';
include "session_auth.php";
session_start();
validatesession();
get_session_values();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <style>
        body {
            background-color: #66cdaa;
            font-family: 'Times New Roman', Times, serif;
            color: #000000; 
            padding: 20px; 
        }
        h1 {
            color: #444;
            text-align: center; 
            margin-bottom: 20px; 
        }
        form {
            background-color: #9370db; 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
            max-width: 500px; 
            margin: auto;
        }
        label {
            display: block; 
            margin-bottom: 5px; 
        }
        input[type="text"],
        textarea {
            width: 100%; 
            padding: 8px; 
            margin-bottom: 15px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
        }
        input[type="submit"] {
            background-color: #db7093;
            color: black; 
            padding: 10px 15px;
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            width: 100%;
        }
        a {
            display: block; /* Make it a block element */
            text-align: center; /* Center the text */
            margin-top: 20px; /* Add some space above */
        }
    </style>
</head>
<body>
    <h1>Create New Post</h1>
    <form action="createnewpost.php" method="POST">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="4" required></textarea>
        </div>
        <div>
            <input type="submit" value="Create Post">
        </div>
    </form>
    <a href="index.php">Go Back</a>
</body>
</html>
