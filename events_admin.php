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

// Fetch events from the database
$sql = "SELECT * FROM events";
$result = mysqli_query($conn, $sql);

// Check if there are any events
if (mysqli_num_rows($result) > 0) {
    // Display events
    echo "<h1>ADMIN PAGE</h1>";
    echo "<h2>Events</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Name</th><th>Description</th><th>Date</th><th>Actions</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['event_id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['description'] . "</td>";
        echo "<td>" . $row['event_date'] . "</td>";
        echo "<td><a href='edit_event.php?id=" . $row['event_id'] . "'>Edit</a> | <a href='delete_event.php?id=" . $row['event_id'] . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No events found.";
}

// Add event form
echo "<h2>Add Event</h2>";
echo "<form action='add_event.php' method='post'>";
echo "Name: <input type='text' name='name'><br>";
echo "Description: <textarea name='description'></textarea><br>";
echo "Date: <input type='date' name='event_date'><br>";
echo "<input type='submit' value='Add Event'>";
echo "</form>";

// Close database connection
mysqli_close($conn);
?>
