<?php
session_start();

@include 'connect.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['memory_id'])) {
    header('Location: gallery.php');
    exit;
}

$memory_id = mysqli_real_escape_string($conn, $_POST['memory_id']);
$user_id = $_SESSION['user_id'] ?  $_SESSION['user_id'] :  $_SESSION['user_id_admin'];

$sql = "SELECT uploader_id, image_url, gallery_id FROM memories WHERE memory_id = '$memory_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $memory = mysqli_fetch_assoc($result);

    if ($memory['uploader_id'] == $user_id) {
        //delete image from the server
        $image_path = $memory['image_url'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $sql = "DELETE FROM memories WHERE memory_id = '$memory_id'";
        if (mysqli_query($conn, $sql)) {
          
            $gallery_id = $memory['gallery_id'];
            $sql = "SELECT COUNT(*) AS memory_count FROM memories WHERE gallery_id = '$gallery_id'";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_assoc($result)['memory_count'];

            if ($count == 0) {
                $sql = "DELETE FROM galleries WHERE gallery_id = '$gallery_id'";
                mysqli_query($conn, $sql);
            }

            header('Location: gallery.php');
            exit;
        } else {
            echo "Error deleting memory: " . mysqli_error($conn);
        }
    } else {
        echo "You do not have permission to delete this memory.";
    }
} else {
    echo "Memory not found.";
}

mysqli_close($conn);
?>
