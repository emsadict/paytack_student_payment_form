<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['admin'])){
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include necessary files
include('config.php');

// Check if user ID is provided in URL
if(isset($_GET['id'])){
    $user_id = $_GET['id'];

    // Delete user from database
    $sql = "DELETE FROM users WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $success = "User deleted successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Delete User</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Back to Admin Panel</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <?php
        if(isset($error)){
            echo "<p class='error'>$error</p>";
        }
        if(isset($success)){
            echo "<p class='success'>$success</p>";
        }
        ?>
    </div>
</body>
</html>
