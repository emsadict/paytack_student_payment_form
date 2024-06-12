<?php
session_start();

// Check if user is logged in
if(!isset($_SESSION['admin'])){
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include necessary files
include('config.php');

// Fetch posts from database
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);

// Initialize posts array
$posts = [];

if(mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }
}
?>
<?php include 'header.php'; ?>

<div class="container mt-5">
    <h2 class="text-primary mb-4">Manage Posts</h2>
    <a href="admin.php" class="btn btn-secondary mb-3">Back to Admin Panel</a>
    <table class="table table-bordered">
        <thead class="bg-primary text-white">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <td><?php echo $post['id']; ?></td>
                    <td><?php echo $post['title']; ?></td>
                    <td><?php echo $post['content']; ?></td>
                    <td><?php echo $post['created_at']; ?></td>
                    <td>
                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                        <a href="manage_posts.php?action=delete&id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
