<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Include necessary files
include('config.php');

// Initialize variables
$title = $content = '';
$title_err = $content_err = '';
$image1_err = $image2_err = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate content
    if (empty(trim($_POST["content"]))) {
        $content_err = "Please enter content.";
    } else {
        $content = trim($_POST["content"]);
    }

    // Validate image1
    if ($_FILES["image1"]["error"] != 4) { // Check if file was uploaded
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES["image1"]["name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_types)) {
            $image1_err = "Invalid file type. Please upload an image file.";
        }
    }

    // Validate image2
    if ($_FILES["image2"]["error"] != 4) { // Check if file was uploaded
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES["image2"]["name"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_types)) {
            $image2_err = "Invalid file type. Please upload an image file.";
        }
    }

    // Check for errors before inserting into database
    if (empty($title_err) && empty($content_err) && empty($image1_err) && empty($image2_err)) {
        // Handle image uploads
        $image1 = $image2 = '';
        if ($_FILES["image1"]["error"] == 0) {
            $image1 = $_FILES["image1"]["name"];
            move_uploaded_file($_FILES["image1"]["tmp_name"], "uploads/" . $image1);
        }
        if ($_FILES["image2"]["error"] == 0) {
            $image2 = $_FILES["image2"]["name"];
            move_uploaded_file($_FILES["image2"]["tmp_name"], "uploads/" . $image2);
        }

        // Prepare an insert statement
        $sql = "INSERT INTO posts (title, content, image1, image2) VALUES (?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_title, $param_content, $param_image1, $param_image2);

            // Set parameters
            $param_title = $title;
            $param_content = $content;
            $param_image1 = $image1;
            $param_image2 = $image2;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to manage_posts.php after successful post creation
                header("Location: manage_posts.php");
                exit;
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>

<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Post News</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" id="title" name="title" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" id="content" name="content" rows="5"><?php echo $content; ?></textarea>
                            <span class="invalid-feedback"><?php echo $content_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="image1">Image 1</label>
                            <input type="file" class="form-control-file <?php echo (!empty($image1_err)) ? 'is-invalid' : ''; ?>" id="image1" name="image1">
                            <span class="invalid-feedback"><?php echo $image1_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="image2">Image 2</label>
                            <input type="file" class="form-control-file <?php echo (!empty($image2_err)) ? 'is-invalid' : ''; ?>" id="image2" name="image2">
                            <span class="invalid-feedback"><?php echo $image2_err; ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
