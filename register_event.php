<?php
session_start();

@include 'connect.php';

// if (!isset($_SESSION['user_name'])) {
//     header('location: login_form.php');
//     exit;
// }

if (isset($_GET['id']) && isset($_GET['status'])) {
    $event_id = $_GET['id'];
    $status = $_GET['status'];

    if ($status !== 'going' && $status !== 'not going') {
        header('location: events_user.php');
        exit;
    }

    $user_id = $_SESSION['user_id'];

    $check_query = "SELECT * FROM event_participants WHERE event_id = '$event_id' AND user_id = '$user_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $update_query = "UPDATE event_participants SET status = '$status' WHERE event_id = '$event_id' AND user_id = '$user_id'";
        mysqli_query($conn, $update_query);
    } else {
        $insert_query = "INSERT INTO event_participants (event_id, user_id, status) VALUES ('$event_id', '$user_id', '$status')";
        mysqli_query($conn, $insert_query);
    }

    header('location: events_user.php');
    exit;
} else {
    header('location: events_user.php');
    exit;
}

mysqli_close($conn);
?>
