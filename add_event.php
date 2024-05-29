<?php
session_start();


if (!isset($_SESSION['user_id_admin'])) {
    header('location: login_form.php');
    exit;
}

@include 'connect.php';

$error = '';
$image_path = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true); 
    }

    if (empty($name) || empty($event_date)) {
        $error = "Name and date are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = 'uploads/' . $image_name; 
            if (move_uploaded_file($image_tmp_name, $image_path)) {
            } else {
                $error = "Error uploading image.";
            }
        }

        $sql = "INSERT INTO events (name, description, event_date, image_url) VALUES ('$name', '$description', '$event_date', '$image_path')";
        if (mysqli_query($conn, $sql)) {
            header('location: events_admin.php');
            exit;
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
