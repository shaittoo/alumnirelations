<?php
session_start();
@include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);


$degree_program_id = $user['degree_program'];
$degree_program_sql = "SELECT degree_program FROM degree_programs WHERE program_id = '$degree_program_id'";
$degree_program_result = mysqli_query($conn, $degree_program_sql);
$degree_program_row = mysqli_fetch_assoc($degree_program_result);
$degree_program_name = $degree_program_row ? $degree_program_row['degree_program'] : '';

$academic_org_id = $user['academic_org'];
$academic_org_sql = "SELECT organization_name FROM academic_organizations WHERE org_id = '$academic_org_id'";
$academic_org_result = mysqli_query($conn, $academic_org_sql);
$academic_org_row = mysqli_fetch_assoc($academic_org_result);
$academic_org_name = $academic_org_row ? $academic_org_row['organization_name'] : '';
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
            <p><strong>Degree Program:</strong> <?php echo htmlspecialchars($degree_program_name); ?></p>
            <p><strong>Academic Organization:</strong> <?php echo htmlspecialchars($academic_org_name); ?></p>
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
