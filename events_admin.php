<?php
session_start();

// Check if the user is logged in and is an admin
// You can uncomment this logic if needed in the future
/*
if(!isset($_SESSION['admin_name'])) {
    header('location: login_form.php');
    exit;
}
*/

// Include database connection file
@include 'connect.php';

// Initialize error variable
$error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    // Check if name and date are empty
    if (empty($name) || empty($event_date)) {
        $error = "Name and date are required.";
    } else {
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = 'uploads/' . $image_name;
            if (!move_uploaded_file($image_tmp_name, $image_path)) {
                $error = "Error uploading image.";
            }
        } else {
            $error = "Image upload error.";
        }

        // Insert event into the database
        if (empty($error)) {
            $sql = "INSERT INTO events (name, description, event_date, image_url) VALUES ('$name', '$description', '$event_date', '$image_path')";
            if (mysqli_query($conn, $sql)) {
                header('location: events_admin.php');
                exit;
            } else {
                $error = "Error inserting event into the database.";
            }
        }
    }
}

// Fetch events from the database
$sql = "SELECT * FROM events";
$result = mysqli_query($conn, $sql);

// Display events
echo "<h1>ADMIN PAGE</h1>";
echo "<h2>Events</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Date</th><th>Image</th><th>Actions</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['event_id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['event_date'] . "</td>";
    echo "<td><img src='" . $row['image_url'] . "' alt='Event Image' style='max-width: 100px; max-height: 100px;'></td>";
    echo "<td><a href='edit_event.php?id=" . $row['event_id'] . "'>Edit</a> | <a href='delete_event.php?id=" . $row['event_id'] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";

// Display add event form
echo "<h2>Add Event</h2>";
echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' enctype='multipart/form-data'>";
echo "Name: <input type='text' name='name'><br>";
echo "Description: <textarea name='description'></textarea><br>";
echo "Date: <input type='date' name='event_date'><br>";
echo "Image: <input type='file' name='image'><br>";
echo "<input type='submit' value='Add Event'>";
echo "</form>";

// Display error message if any
if (!empty($error)) {
    echo "<p>Error: $error</p>";
}

// Close database connection
mysqli_close($conn);
?>
