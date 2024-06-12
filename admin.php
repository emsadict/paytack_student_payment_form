<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['admin'])){
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include necessary files
include('config.php');

// Fetch posts from the database
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
?>
<?php include 'header.php'; ?>
<div class='alert alert-primary' style='width:100%; '>WELCOME TO THE ADMIN DASHBOARD </div>
<div class="container-fluid ">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 bg-primary p-4">
            <h3 class="text-white mb-4">Menu</h3>
            <hr class='text-white'>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="post_news.php">Post News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="manage_posts.php">Manage Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="manage_users.php">Manage Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="add_user.php">Create User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </aside>

        <!-- Main content -->
        <main class="col-md-9">
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="uploads/<?php echo $row['image1']; ?>" class="card-img-top" alt="Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                <p class="card-text"><?php echo substr($row['content'], 0, 100); ?>...</p>
                                <a href="postcontent.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>
    </div>
</div>

<?php include 'footer.php'; ?>
