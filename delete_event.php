<?php
session_start();

if (!isset($_SESSION['user_id_admin'])) {
    header('location: login_form.php');
    exit;
}

@include 'connect.php';

if (isset($_GET['id'])) {
    $event_id = mysqli_real_escape_string($conn, $_GET['id']);

    mysqli_begin_transaction($conn);
    try {
        $sql = "DELETE FROM event_participants WHERE event_id = '$event_id'";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Error deleting event participants: " . mysqli_error($conn));
        }

        $sql = "DELETE FROM events WHERE event_id = '$event_id'";
        if (!mysqli_query($conn, $sql)) {
            throw new Exception("Error deleting event: " . mysqli_error($conn));
        }

        mysqli_commit($conn);
        header('location: events_admin.php');
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo $e->getMessage();
    }
} else {
    header('location: events_admin.php');
    exit;
}

mysqli_close($conn);
?>
