<?php include 'header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 bg-primary p-4">
            <h3 class="text-white mb-4">Menu</h3>
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