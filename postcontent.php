<?php
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

?>

<?php include 'header.php'; ?>


    <div class="row mt-1">
        <div class="col-md-12" style='padding-bottom:20px; margin-bottom:30px;'>
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title"><?php echo $post['title']; ?></h2>
                    <?php if ($post['image1']): ?>
                        <img src="uploads/<?php echo $post['image1']; ?>" style='width: 80px; height: 80px;' class="img-fluid mb-3" alt="Image 1">
                    <?php endif; ?>
                    <p class="card-text"><?php echo $post['content']; ?></p>
                    <?php if ($post['image2']): ?>
                        <img src="uploads/<?php echo $post['image2']; ?>" style='width: 400px; height: 200px;' class="img-fluid mt-3 mb-3" alt="Image 2">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


<?php include 'footer.php'; ?>
