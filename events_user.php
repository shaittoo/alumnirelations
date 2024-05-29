<?php
session_start();

// // Check if the user is logged in and is not an admin
// if(isset($_SESSION['admin_name'])) {
//     header('location: events_admin.php');
//     exit;
// } elseif (!isset($_SESSION['user_name'])) {
//     header('location: login_form.php');
//     exit;
// }

// If the user is logged in and not an admin, display the HTML content for the user events page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - User Panel</title>
</head>
<body>
    <h1>User Page</h1>
    <!-- Your user-specific content goes here -->
</body>
</html>
