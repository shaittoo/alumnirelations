<?php
session_start();

@include 'connect.php';

$memory_id = mysqli_real_escape_string($conn, $_GET['id']);

if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_id_admin'])) {
    header('Location: gallery.php');
    exit;
}

$user_id = isset($_SESSION['user_id_admin']) ? $_SESSION['user_id_admin'] : (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);

$sql = "SELECT m.memory_id, m.image_url, m.memory_date, m.description, g.batch_year, u.fname, u.lname, m.uploader_id
        FROM memories m
        JOIN galleries g ON m.gallery_id = g.gallery_id
        JOIN user u ON m.uploader_id = u.user_id
        WHERE m.memory_id = '$memory_id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $memory = mysqli_fetch_assoc($result);
} else {
    echo "Memory not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Details</title>
</head>
<body>
    <h1>Memory Details</h1>
    <img src="<?php echo $memory['image_url']; ?>" alt="Memory Image" style="max-width: 100%;">
    <p>Date: <?php echo $memory['memory_date']; ?></p>
    <p>Description: <?php echo $memory['description']; ?></p>
    <p>Batch: <?php echo $memory['batch_year']; ?></p>
    <p>Uploader: <?php echo $memory['fname'] . " " . $memory['lname']; ?></p>

    <?php if (isset($_SESSION['user_id_admin']) || (isset($_SESSION['user_id']) && $memory['uploader_id'] == $user_id)): ?>
    <form action="delete_memory.php" method="post">
        <input type="hidden" name="memory_id" value="<?php echo $memory_id; ?>">
        <button type="submit">Delete</button>
    </form>
<?php endif; ?>


    <a href="gallery.php">Back to Gallery</a>
</body>
</html>

<?php
mysqli_close($conn);
?>
