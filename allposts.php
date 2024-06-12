<?php
session_start();

// Check if user is logged in
//if(!isset($_SESSION['admin'])){
  //  header("Location: login.php"); // Redirect to login page if not logged in
    //exit;
//}

// Include necessary files
include('config.php');

// Fetch posts from the database
$sql = "SELECT * FROM posts";
$result = mysqli_query($conn, $sql);
?>
<?php include 'header.php'; ?>

        <!-- Main content -->
        <main class="col-md-12">
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-sm-3 mb-3">
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