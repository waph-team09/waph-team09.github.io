<?php
require_once('sudosession_auth.php');
require_once('sudodatabase.php');

createsudosession();
debug_to_console("Session Created");

debug_to_console($_POST['username']);
debug_to_console($_POST['password']);
$username=sanitize_input($_POST['username']);
$password=sanitize_input($_POST['password']);

if(isset($_POST['username']) || isset($_POST['password'])){
    if(sudologin($username,$password)){
        debug_to_console("Login Successful");
        regenerateSudoSession();
        authenticateSudoSession($username);
    }else {
        session_destroy();
        echo "<script>alert('Invalid username/password');window.location='form.php';</script>";
        die();
    }
    
}

validatesudosession();
get_session_values();
if (!isset($_SESSION['superuser'])) {
    echo "<script>alert('You are not a SuperUser');window.location='form.php';</script>";
    exit();
}

$users = getUserList();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User List</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #e6e6fa; 
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center; 
            justify-content: flex-start;
            height: 100vh;
        }
        h2 {
            margin-top: 20px; 
            text-align: center; 
        }
        table {
            width: 80%; 
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            color: #0077CC;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout-btn {
            display: block; /* Makes the logout link a block element */
            width: 200px; /* Specific width for alignment */
            padding: 10px 20px;
            background-color: #add8e6;
            color: black;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto; /* Auto margins for horizontal centering */
        }
    </style>
</head>
<body>
    <h2>User List</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Phone Number</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                <td><?php echo htmlspecialchars($user['phonenum']); ?></td>
                <td><?php echo $user['disabled'] == 1 ? 'Disabled' : 'Enabled'; ?></td>
                <td>
                    <?php if ($user['disabled'] != 1) : ?>
                        <a href="disableuser.php?id=<?php echo $user['user_id']; ?>">Disable</a>
                    <?php else : ?>
                        <a href="enableuser.php?id=<?php echo $user['user_id']; ?>">Enable</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>
