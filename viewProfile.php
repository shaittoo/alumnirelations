<?php
session_start();
@include 'connect.php';

// Redirect to login page if user is not logged in
// if (!isset($_SESSION['user_name']) && !isset($_SESSION['admin_name'])) {
//     header('Location: login_form.php');
//     exit;
// }

$email = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['admin_name'];
$query = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile</title>
    <link rel="stylesheet" href="css/profilestyles.css">
</head>

<body>
    <div class="profile-container">
        <h2>Your Profile</h2>
        <div class="profile-details">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['fname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lname']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
            <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($user['contact_num']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Occupation:</strong> <?php echo htmlspecialchars($user['occupation']); ?></p>
            <p><strong>Graduating Year:</strong> <?php echo htmlspecialchars($user['grad_year']); ?></p>
            <p><strong>Degree Program:</strong> <?php echo htmlspecialchars($user['degree_program']); ?></p>
            <p><strong>Academic Organization:</strong> <?php echo htmlspecialchars($user['academic_org']); ?></p>
            <p><strong>Bio:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
        </div>
        <div class="edit-profile-link">
            <a href="editProfile.php">Edit Profile</a>
        </div>
        <div class="delete-profile-link">
            <a href="deleteProfile.php">Delete Profile</a>
        </div>
    </div>
</body>

</html>
