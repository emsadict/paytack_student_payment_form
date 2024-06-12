<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['admin'])){
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include necessary files
include('config.php');

// Initialize variables
$username = $email = $error = "";

// Check if user ID is provided in URL
if(isset($_GET['id'])){
    $user_id = $_GET['id'];

    // Fetch user data from database
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    //$user = mysqli_fetch_assoc($result);
   // $user=$user_id;
    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $email = $row['email'];
    } else {
        $error = "User not found";
    }
}

// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Update user in database
    $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$user_id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $success = "User updated successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <a href="admin.php" class="btn btn-secondary">Back to Admin</a>
        </div>
        <div class="col-auto">
            <h2 class="text-primary justify-content-center">Edit User</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8" style='padding:20px;'>
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $user_id; ?>" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>