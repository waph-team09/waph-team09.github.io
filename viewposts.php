<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Posts</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #ffe4b5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        img.top-image {
            display: block;
            max-width: 20%;
            height: auto;
            margin: 0 auto 20px;
        }
        h2 {
            color: #333;
            text-align: center;
        }
        h3, p, strong {
            color: #000000; 
        }
        p {
            margin: 5px 0;
        }
        strong {
            color: red;
        }
        .home-button {
            display: inline-block;
            background-color: #c0c0c0;
            color: #000000;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }
        .center {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <img src="https://buffer.com/resources/content/images/resources/wp-content/uploads/2017/05/feature-image@2x.png" alt="Feature Image" class="top-image">
    <h2>VIEW POSTS</h2>
    <?php
    include 'session_auth.php';
    include 'database.php';
    session_start();
    validatesession();

    $posts = getPosts();
    if (!empty($posts)) {
        foreach ($posts as $post) {
            echo '<div class="container">';
            echo '<h3>' . htmlspecialchars($post['title']) . '</h3>';
            echo '<p>' . htmlspecialchars($post['content']) . '</p>';
            echo '<p><strong>Posted By:</strong> ' . htmlspecialchars($post['username']) . '</p>';
            echo '<p><strong>Posted At:</strong> ' . formatTimestamp($post['created_at']) . '</p>';
            echo '<p>';
            if (isset($_SESSION['username']) && $post['username'] == $_SESSION['username']) {
                echo '<a href="editpost.php?id=' . $post['post_id'].'&nocsrftoken='. $_SESSION['nocsrftoken'] . '">Edit</a> | ';
                echo '<a href="deletepost.php?id=' . $post['post_id'].'&nocsrftoken='. $_SESSION['nocsrftoken'] . '">Delete</a> | ';
            }
            echo '<a href="viewcomments.php?id=' . $post['post_id']. '">View Comments</a>';
            echo '</p>';
            echo '</div>';
        }
    } else {
        echo '<p>No posts available.</p>';
    }
    ?>
    <div class="center">
        <a href="index.php" class="home-button">Home</a>
    </div>
</body>
</html>
