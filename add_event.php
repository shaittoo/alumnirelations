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

// Initialize variables
$error = '';
$image_path = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    // Validate form data (you can add more validation as needed)
    if (empty($name) || empty($event_date)) {
        // Handle empty fields
        $error = "Name and date are required.";
    } else {
        // Check if file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Process the uploaded file
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = 'uploads/' . $image_name; // Set the path where the image will be stored
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Image uploaded successfully
            } else {
                // Error uploading image
                $error = "Error uploading image.";
            }
        }

        // Insert event into database
        $sql = "INSERT INTO events (name, description, event_date, image_url) VALUES ('$name', '$description', '$event_date', '$image_path')";
        if (mysqli_query($conn, $sql)) {
            // Event added successfully, redirect to admin panel
            header('location: events_admin.php');
            exit;
        } else {
            // Error inserting event
            $error = "Error: " . mysqli_error($conn);
        }
    }
}

// Close database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
</head>
<body>
    <h1>Add Event</h1>
    <?php
    if (isset($error)) {
        echo "<p>$error</p>";
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="event_date">Date:</label><br>
        <input type="date" id="event_date" name="event_date" required><br>
        <label for="image">Upload Image:</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="submit" value="Add Event">
    </form>
</body>
</html>
