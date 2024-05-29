<?php
session_start();

@include 'connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $batch_year = mysqli_real_escape_string($conn, $_POST['batch_year']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $uploader_id = $_SESSION['user_id'] ? $_SESSION['user_id'] : $_SESSION['user_id_admin'];

    if (empty($batch_year)) {
        $error = "Batch year is required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = 'uploads/' . $image_name;
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $memory_date = date('Y-m-d');

                $sql = "SELECT gallery_id FROM galleries WHERE batch_year = '$batch_year'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $gallery_id = $row['gallery_id'];
                } else {
                    $sql = "INSERT INTO galleries (batch_year) VALUES ('$batch_year')";
                    if (mysqli_query($conn, $sql)) {
                        $gallery_id = mysqli_insert_id($conn);
                    } else {
                        $error = "Error creating gallery: " . mysqli_error($conn);
                    }
                }

                if (empty($error)) {
                    $sql = "INSERT INTO memories (gallery_id, memory_date, image_url, description, uploader_id) VALUES ('$gallery_id', '$memory_date', '$image_path', '$description', '$uploader_id')";
                    if (mysqli_query($conn, $sql)) {
                        header('location: gallery.php');
                        exit;
                    } else {
                        $error = "Error uploading memory: " . mysqli_error($conn);
                    }
                }
            } else {
                $error = "Error uploading image.";
            }
        } else {
            $error = "Image upload error.";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Memory</title>
    <link rel="stylesheet" href="css/gallery.css">
</head>
<body>
    <h1>Upload a Memory</h1>
    <?php if (!empty($error)) { echo "<p>Error: $error</p>"; } ?>
    <form action="upload_memory.php" method="post" enctype="multipart/form-data">
        <label for="batch_year">Batch Year:</label><br>
        <input type="text" id="batch_year" name="batch_year" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="image">Upload Image:</label><br>
        <input type="file" id="image" name="image" required><br>
        <input type="submit" value="Upload">
    </form>
</body>
</html>
