<?php
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <?php  include 'header.php';    ?>
</head>
<body>
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="slide/slide-1.jpg" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="slide/slide-2.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="slide/slide-3.jpg" class="d-block w-100" alt="Image 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Posts -->
    <div class="container mt-5">
        <div class="row">
            <?php foreach($posts as $post): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="uploads/<?php echo $post['image1']; ?>" class="card-img-top" alt="Post Image">
                    <div class="card-body">
                        <div class="container mt-5">
                        <p class="card-text"><?php echo implode(' ', array_slice(explode(' ', $post['content']), 0, 50)); ?>...</p>
                        <a href="postcontent.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Read More</a>
            </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


     <?php include 'footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
