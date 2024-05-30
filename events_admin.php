<?php
session_start();

if (!isset($_SESSION['user_id_admin'])) {
    header('location: login_form.php');
    exit;
}

@include 'connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_action'])) {
    $user_id = intval($_POST['user_id']);
    $action = $_POST['user_action'] === 'approve' ? 'approved' : 'rejected';

    $update = "UPDATE user SET status = '$action' WHERE user_id = $user_id";
    if (!mysqli_query($conn, $update)) {
        $error = "Error updating user status: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);

    if (empty($name) || empty($event_date)) {
        $error = "Name and date are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            if (!file_exists('uploads')) {
                mkdir('uploads', 0777, true);
            }

            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_path = 'uploads/' . $image_name;

            if (!move_uploaded_file($image_tmp_name, $image_path)) {
                $error = "Error uploading image.";
            }
        } else {
            $error = "Image upload error.";
        }

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


$sql = "SELECT e.*, 
        COUNT(CASE WHEN ep.status = 'going' THEN 1 END) AS going_count, 
        COUNT(CASE WHEN ep.status = 'not going' THEN 1 END) AS not_going_count 
        FROM events e 
        LEFT JOIN event_participants ep ON e.event_id = ep.event_id 
        GROUP BY e.event_id";
$result = mysqli_query($conn, $sql);


$pending_users_sql = "SELECT * FROM user WHERE status = 'pending'";
$pending_users_result = mysqli_query($conn, $pending_users_sql);

echo "<h1>ADMIN PAGE</h1>";
echo "<h2>Events</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Date</th><th>Image</th><th>Going</th><th>Not Going</th><th>Actions</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['event_id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['event_date'] . "</td>";
    echo "<td><img src='" . $row['image_url'] . "' alt='Event Image' style='max-width: 100px; max-height: 100px;'></td>";
    echo "<td>" . $row['going_count'] . "</td>";
    echo "<td>" . $row['not_going_count'] . "</td>";
    echo "<td><a href='edit_event.php?id=" . $row['event_id'] . "'>Edit</a> | <a href='delete_event.php?id=" . $row['event_id'] . "'>Delete</a></td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Add Event</h2>";
echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' enctype='multipart/form-data'>";
echo "Name: <input type='text' name='name'><br>";
echo "Description: <textarea name='description'></textarea><br>";
echo "Date: <input type='date' name='event_date'><br>";
echo "Image: <input type='file' name='image'><br>";
echo "<input type='submit' value='Add Event'>";
echo "</form>";

if (!empty($error)) {
    echo "<p>Error: $error</p>";
}

echo "<h2>Pending Registrations</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Grad Year</th><th>Deg Prog ID</th><th>Acad Org ID</th><th>Status</th></tr>";
while ($row = mysqli_fetch_assoc($pending_users_result)) {
    echo "<tr>";
    echo "<td>" . $row['user_id'] . "</td>";
    echo "<td>" . $row['fname'] . "</td>";
    echo "<td>" . $row['lname'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['grad_year'] . "</td>";
    echo "<td>" . $row['degree_program'] . "</td>";
    echo "<td>" . $row['academic_org'] . "</td>";
    echo "<td>
        <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' style='display:inline;'>
            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
            <input type='hidden' name='user_action' value='approve'>
            <input type='submit' value='Approve'>
        </form>
        <form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' style='display:inline;'>
            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
            <input type='hidden' name='user_action' value='reject'>
            <input type='submit' value='Reject'>
        </form>
    </td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><a href='logout.php'>Logout</a>";
echo "<br><a href='gallery.php'>Gallery</a>";

mysqli_close($conn);
?>
