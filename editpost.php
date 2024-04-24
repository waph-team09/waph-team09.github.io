<?php
    include 'session_auth.php';
    include 'database.php';
    session_start();
    validatesession();
    debug_to_console('$_GET["nocsrftoken"]' . $_GET["nocsrftoken"] . '$_SESSION["nocsrftoken"]' . $_SESSION["nocsrftoken"]);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        debug_to_console("POST");
        $title = $_POST['title'];
        $content = $_POST['content'];
        $postId = $_POST['id'];
        debug_to_console("Title:".$title);
        debug_to_console("Content:".$content);
        debug_to_console("PostId:".$postId);
        
        updatePost($postId, $title, $content);

        header("Location: viewposts.php");
        exit();
    } elseif($_SERVER["REQUEST_METHOD"] == "GET") {
        debug_to_console("GET");
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
        
            if (!$post || $post['user_id'] != $_SESSION['user_id']) {
                header("Location: viewposts.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body {
            background-color: #fffacd; 
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 20px;
            color: #000000;
        }

        h2 {
            color: #444;
            text-align: center;
        }

        form {
            background-color: #afeeee; 
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            margin: 30px auto; 
        }

        div {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%; 
            padding: 8px;
            border: 1px solid #ccc; 
            border-radius: 4px;
            box-sizing: border-box; 
        }

        input[type="submit"] {
            background-color: #4CAF50; 
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h2>Edit Post</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $postId; ?>" method="POST">
        <input type="hidden" name="nocsrftoken" value="<?php echo $_SESSION["nocsrftoken"]; ?>">
        <input type="hidden" name="id" value="<?php echo $postId; ?>">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="4" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>
        <div>
            <input type="submit" value="Update Post">
        </div>
    </form>
</body>
</html>
