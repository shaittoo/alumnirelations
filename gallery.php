<?php
session_start();

@include 'connect.php';

$batch_year = '';
if (isset($_POST['batch_year'])) {
    $batch_year = mysqli_real_escape_string($conn, $_POST['batch_year']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/gallery.css">
</head>
<body>
    <section class="gallery-container">
        <div class="gallery-nav">
            <h1 class="page-title">Gallery:</h1>
            <div class="batch-search">
                <form method="POST" action="gallery.php" class="input-group">
                    <label for="batch-year">Batch:</label>
                    <input class="input" type="text" id="batch-year" name="batch_year" placeholder="2020" value="<?php echo htmlspecialchars($batch_year); ?>">
                    <button class="go-btn" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="upload-memory"><a href="upload_memory.php">Upload a memory</a></div>
        <div class="image-grid">
            <?php
            if (!empty($batch_year)) {
                $sql = "SELECT m.memory_id, m.image_url
                        FROM memories m
                        JOIN galleries g ON m.gallery_id = g.gallery_id
                        WHERE g.batch_year = '$batch_year'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='grid-item'>";
                        echo "<img class='grid-image' src='" . $row['image_url'] . "' alt='Memory Image'>";
                        echo "<div class='show-info'><a href='memory_details.php?id=" . $row['memory_id'] . "'>Show Info</a></div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No images found for batch year " . htmlspecialchars($batch_year) . ".</p>";
                }
            }
            ?>
        </div>
    </section>
    <div class="logout-btn">
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
    <div class="back-to-events">
    <?php
    if (isset($_SESSION['user_id_admin'])) {
        echo '<a href="events_admin.php">Back to Events</a>';
    } else {
        echo '<a href="events_user.php">Back to Events</a>';
    }
    ?>
</div>

</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
