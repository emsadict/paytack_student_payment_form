<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include necessary files
include('config.php');

// Fetch post details if ID is provided
$post = null;
if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Check if image files are uploaded
    if ($_FILES['image1']['tmp_name']) {
        $image1 = $_FILES['image1']['name'];
        $image1_tmp = $_FILES['image1']['tmp_name'];
        move_uploaded_file($image1_tmp, "uploads/" . $image1);
    } else {
        $image1 = $post['image1'];
    }

    if ($_FILES['image2']['tmp_name']) {
        $image2 = $_FILES['image2']['name'];
        $image2_tmp = $_FILES['image2']['tmp_name'];
        move_uploaded_file($image2_tmp, "uploads/" . $image2);
    } else {
        $image2 = $post['image2'];
    }

    // Update post in database
    $update_sql = "UPDATE posts SET title = '$title', content = '$content', image1 = '$image1', image2 = '$image2' WHERE id = $post_id";
    $update_result = mysqli_query($conn, $update_sql);
    if ($update_result) {
        // Redirect to manage_posts.php after successful update
        header("Location: manage_posts.php");
        exit;
    } else {
        // Handle error
        echo "Error updating post!";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-auto">
            <h2 class="text-primary">Edit Post</h2>
        </div>
        <div class="col-auto">
            <a href="admin.php" class="btn btn-secondary">Back to Admin</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8" style='padding:20px;'>
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $post_id; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="5"><?php echo $post['content']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image1">Image 1</label>
                            <input type="file" class="form-control-file" id="image1" name="image1">
                        </div>
                        <div class="form-group">
                            <label for="image2">Image 2</label>
                            <input type="file" class="form-control-file" id="image2" name="image2">
                        </div>
                        <button type="submit" class="btn btn-primary" style='float:right; margin: right 30%;'>Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
