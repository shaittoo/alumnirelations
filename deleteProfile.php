<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit;
}

    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM user WHERE user_id='$user_id'";
    

    if ($conn->query($sql) === TRUE) {
        header('Location: logout.php');
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();

?>
