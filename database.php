<?php
$mysqli = new mysqli('localhost', 'waph09', 'Pa$$w0rd', 'waphteam09');
if ($mysqli->connect_errno) {
    printf("Database Connection Failed %s\n", $mysqli->connect_error);
    exit();
}
function checklogin_mysql($username, $password)
{

    global $mysqli;

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE username= ? AND password = md5(?);");

    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if ($user['disabled'] == 1) {
            debug_to_console("User is disabled");
            return "Your account has been disabled.";
        } else {
            debug_to_console("User is enabled");
            return true;
        }
    } elseif ($result->num_rows == 0) {
        return "Invalid username or password";
    } else {
        return "Error occurred, please try again later";
    }
    
}
function addUser($username, $password, $email, $name)
{
    global $mysqli;
    $stmt = $mysqli->prepare("INSERT INTO users (email, username, password, fullname) VALUES (?, ?, md5(?),?)");
    
    $stmt->bind_param("ssss", $email, $username, $password, $name);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }

    $stmt->close();
}
function updateUserPassword($username, $password)
{
    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE users SET password = md5(?) WHERE username = ?");

    $stmt->bind_param("ss", $password, $username);

    if (!$stmt->execute()) {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        exit();
    }

    $stmt->close();
}

function getUserDetails($username){
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT fullname, phonenum FROM users WHERE username = ?");

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $stmt->bind_result($fullname, $phonenum);

    $userDetails = array();
    if ($stmt->fetch()) {
        $userDetails['full_name'] = $fullname;
        $userDetails['phone_number'] = $phonenum;
    }
    $stmt->close();
    return $userDetails;
}
function updateUserProfile($username, $fullname, $phonenum){
    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE users SET fullname = ?, phonenum = ? WHERE username = ?");

    $stmt->bind_param("sss", $fullname, $phonenum, $username);

    if ($stmt->execute()) {
        
        echo "Profile updated successfully";
    } else {
        
        echo "Error updating profile: " . $mysqli->error;
    }

    $stmt->close();

}
function getPosts(){
    global $mysqli;
    $query = "SELECT p.post_id, u.username, p.title, p.content, p.created_at 
              FROM posts p 
              LEFT JOIN users u ON p.user_id = u.user_id 
              ORDER BY p.created_at DESC";
    $stmt = $mysqli->query($query);
    $posts = array();
    if ($stmt->num_rows > 0) {
        while ($row = $stmt->fetch_assoc()) {
            $posts[] = $row;
        }
    }
    $stmt->close();
    return $posts;
}


function addPost($title, $content, $username){
    global $mysqli;
    get_session_values();
    debug_to_console("Username: " . $username);
    $user_id=getuserid($username);
    $query = "INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iss", $user_id, $title, $content);
    if ($stmt->execute()) {
        echo "Post added successfully";
    } else {
        echo "Error adding post: " . $mysqli->error;
    }
    $stmt->close();
}

function getPostById($postId){
    global $mysqli;
    $query = "SELECT p.post_id, u.username, p.title, p.content, p.created_at, p.user_id 
              FROM posts p 
              LEFT JOIN users u ON p.user_id = u.user_id 
              WHERE p.post_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $stmt->bind_result($post_id, $username, $title, $content, $created_at, $user_id);
    $post = array();
    if ($stmt->fetch()) {
        $post['post_id'] = $post_id;
        $post['username'] = $username;
        $post['title'] = $title;
        $post['content'] = $content;
        $post['created_at'] = $created_at;
        $post['user_id'] = $user_id;
    }
    $stmt->close();
    return $post;
}
function updatePost($postId, $title, $content){
    global $mysqli;
    $query = "UPDATE posts SET title = ?, content = ? WHERE post_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssi", $title, $content, $postId);
    if ($stmt->execute()) {
        echo "Post updated successfully";
    } else {
        echo "Error updating post: " . $mysqli->error;
    }
    $stmt->close();
}
function deletePost($postId){
    global $mysqli;
    $query = "DELETE FROM posts WHERE post_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $postId);
    if ($stmt->execute()) {
        echo "Post deleted successfully";
    } else {
        echo "Error deleting post: " . $mysqli->error;
    }
    $stmt->close();
}
function addComment($postId, $comment, $username){
    global $mysqli;
    $user_id = getuserid($username);
    $query = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("iis", $postId, $user_id, $comment);
    if ($stmt->execute()) {
        echo "Comment added successfully";
    } else {
        echo "Error adding comment: " . $mysqli->error;
    }
    $stmt->close();
}
function getComments($postId) {
    global $mysqli;
    
    $stmt = $mysqli->prepare("SELECT * FROM comments WHERE post_id = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    return $comments;
}
function getName($username){
    global $mysqli;
    $query = "SELECT fullname FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($fullname);
    $stmt->fetch();
    $stmt->close();
    return $fullname;
}

function getNamefromID($user_id){
    global $mysqli;
    $query = "SELECT fullname FROM users WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($fullname);
    $stmt->fetch();
    $stmt->close();
    return $fullname;
}
function getuserid($username){
    global $mysqli;
    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    return $user_id;
}
function generateCSRFToken()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function validateCSRFToken($token)
{
    debug_to_console("Token: " . $token);
    debug_to_console("Session Token: " . $_SESSION["nocsrftoken"]);
    return isset($_SESSION["nocsrftoken"]) && $token === $_SESSION["nocsrftoken"];
}

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}
function sanitize_input($input) 
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
function get_session_values(){
    debug_to_console($_SESSION["nocsrftoken"]);
    debug_to_console($_SESSION["authenticated"]);
    debug_to_console($_SESSION["username"]);
    debug_to_console($_SESSION["browser_metadata"]);
    debug_to_console($_SESSION["ip_address"]);
    debug_to_console($_SESSION["user_id"]);
}
function formatTimestamp($timestamp) {
    return date("F j, Y, g:i a", strtotime($timestamp));
}
