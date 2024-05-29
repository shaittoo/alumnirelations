<?php
session_start();


if (!isset($_SESSION['user_id_admin'])) {
    header('location: login_form.php');
    exit;
}



@include 'connect.php';

if (isset($_GET['id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM events WHERE event_id = '$event_id'";
    if (mysqli_query($conn, $sql)) {
        header('location: events_admin.php');
        exit;
    } else {
        echo "Error deleting event: " . mysqli_error($conn);
    }
} else {
    header('location: events_admin.php');
    exit;
}
mysqli_close($conn);
?>
