<?php
session_start();


if(!isset($_SESSION['user_id_admin'])) {
    header('location: login_form.php');
    exit;
}


@include 'connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_id = mysqli_real_escape_string($conn, $_POST['event_id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    if (empty($name) || empty($event_date)) {
        $error = "Name and date are required.";
    } else {
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = 'uploads/' . $image_name;
            if (!move_uploaded_file($image_tmp_name, $image_path)) {
                $error = "Error uploading image.";
            }
        }

        if (empty($error)) {
            $update_sql = "UPDATE events SET name='$name', description='$description', event_date='$event_date'";
            if (!empty($image_path)) {
                $update_sql .= ", image_url='$image_path'";
            }
            $update_sql .= " WHERE event_id=$event_id";

            if (mysqli_query($conn, $update_sql)) {
                header('location: events_admin.php');
                exit;
            } else {
                $error = "Error updating event in the database.";
            }
        }
    }
}

if (isset($_GET['id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM events WHERE event_id=$event_id";
    $result = mysqli_query($conn, $sql);

    // Check if the event exists
    if (mysqli_num_rows($result) == 1) {
        // Fetch event data
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $description = $row['description'];
        $event_date = $row['event_date'];
    } else {
        $error = "Event not found.";
    }
} else {
    $error = "Event ID is missing.";
}

echo "<h1>Edit Event</h1>";
echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' enctype='multipart/form-data'>";
echo "<input type='hidden' name='event_id' value='$event_id'>";
echo "Name: <input type='text' name='name' value='$name'><br>";
echo "Description: <textarea name='description'>$description</textarea><br>";
echo "Date: <input type='date' name='event_date' value='$event_date'><br>";
echo "Image: <input type='file' name='image'><br>";
echo "<input type='submit' value='Update Event'>";
echo "</form>";

if (!empty($error)) {
    echo "<p>Error: $error</p>";
}

mysqli_close($conn);
?>
