<?php
include 'session_auth.php';
include 'database.php';

session_start();
validatesession();
get_session_values();

if (!isset($_GET['id'])) {
    header("Location: viewposts.php");
    exit();
}

$postId = $_GET['id'];
$post = getPostById($postId);
$comments = getComments($postId);
debug_to_console($comments[0]['user_id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $comment_text = $_POST['comment_text'];

    addComment($postId, $comment_text, $username);
    header("Location: viewcomments.php?id=$postId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Comments</title>
    <style>
        body {
            background-color: #ffc0cb; 
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            margin: 0;
            padding: 10px;
        }

        h2, h3 {
            color: #444;
        }

        p {
            line-height: 1.6; 
        }

        div {
            background-color: #dcdcdc; 
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            margin-top: 20px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        a {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php if ($post) : ?>
        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
        <p><?php echo htmlspecialchars($post['content']); ?></p>
    <?php else : ?>
        <p>Post not found.</p>
    <?php endif; ?>

    <h3>Comments</h3>
    <?php if (!empty($comments)) : ?>
        <?php foreach ($comments as $comment) : ?>
            <div>
                <p>Comment By: <?php echo htmlspecialchars(getNamefromID($comment['user_id'])); ?></p>
                <p><?php echo htmlspecialchars($comment['content']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No comments available for this post.</p>
    <?php endif; ?>

    <h3>Add a Comment</h3>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $postId; ?>" method="POST">
        <input type="hidden" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']) ?>" required>
        <label for="comment_text">Your Comment:</label>
        <textarea id="comment_text" name="comment_text" rows="4" required></textarea>
        <input type="submit" value="Add Comment">
    </form>
    <a href="viewposts.php">Back to Posts</a>
</body>
</html>
