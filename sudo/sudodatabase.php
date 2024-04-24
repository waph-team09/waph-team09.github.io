<?php
$mysqli = new mysqli('localhost', 'waph09', 'Pa$$w0rd', 'waphteam09');
if ($mysqli->connect_errno) {
    printf("Database Connection Failed %s\n", $mysqli->connect_error);
    exit();
}

function sudologin($username, $password)
{
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT * FROM superusers WHERE username= ? AND password = md5(?);");

    $stmt->bind_param("ss", $username, $password);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $stmt->close();
        return TRUE;
    } else {
        return FALSE;
    }
    
}

function getUserList() {
    global $mysqli;

    $result = $mysqli->query("SELECT * FROM users");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

function disableUser($userId) {
    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE users SET disabled = 1 WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

function enableUser($userId) {
    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE users SET disabled = 0 WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}
function generateCSRFToken()
{
    return bin2hex(openssl_random_pseudo_bytes(16));
}

function validateCSRFToken($token)
{
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
    debug_to_console($_SESSION["superuser"]);
}
function formatTimestamp($timestamp) {
    return date("F j, Y, g:i a", strtotime($timestamp));
}

?>