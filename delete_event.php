<?php
session_start();

// Check if the user is logged in and is an admin
// You can uncomment this logic if needed in the future
/*
if (!isset($_SESSION['admin_name'])) {
    header('location: login_form.php');
    exit;
}
*/

// Include database connection file
@include 'connect.php';

// Check if event ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the event ID
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete event from the database
    $sql = "DELETE FROM events WHERE event_id = '$event_id'";
    if (mysqli_query($conn, $sql)) {
        // Redirect to events_admin.php after successful deletion
        header('location: events_admin.php');
        exit;
    } else {
        // Handle deletion error
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
    // Redirect to events_admin.php if event ID is not provided
    header('location: events_admin.php');
    exit;
}

// Close database connection
mysqli_close($conn);
?>
