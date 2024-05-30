<?php
session_start();

if (!isset($_SESSION['user_id']) && $_SESSION['status'] !== 'approved') {
    header('location: login_form.php');
    exit;
}

@include 'connect.php';

$sql = "SELECT e.*, COUNT(CASE WHEN ep.status = 'going' THEN 1 END) AS going_count, COUNT(CASE WHEN ep.status = 'not going' THEN 1 END) AS not_going_count
        FROM events e
        LEFT JOIN event_participants ep ON e.event_id = ep.event_id
        GROUP BY e.event_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1>Events</h1>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h2>" . $row['name'] . "</h2>";
        echo "<p>" . $row['description'] . "</p>";
        echo "<p>Date: " . $row['event_date'] . "</p>";
        echo "<p>Number of People Going: " . $row['going_count'] . "</p>";
        echo "<p>Number of People Not Going: " . $row['not_going_count'] . "</p>";
        echo "<img src='" . $row['image_url'] . "' alt='Event Image' style='max-width: 100px; max-height: 100px;'>";
        echo "<a href='register_event.php?id=" . $row['event_id'] . "&status=going'>Going</a> | ";
        echo "<a href='register_event.php?id=" . $row['event_id'] . "&status=not going'>Not Going</a>";
        echo "</div>";
    }
} else {
    echo "No events found.";
}

mysqli_close($conn);
?>

<form action="logout.php" method="post">
    <button type="submit">Logout</button>
</form>

<a href="gallery.php">Gallery</a>

<a href="viewProfile.php">Profile</a>
