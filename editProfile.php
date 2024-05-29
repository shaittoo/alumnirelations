<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT PROFILE</title>
    <link rel="stylesheet" href="css/registerstyles.css">
</head>

<body>
    <div class="register-container">
        <img class="logo" src="images/1.png" alt="BackinUP Logo">
        <form class="register-form">
            <h2>EDIT PROFILE</h2>
            <div class="input-group">
                <label for="firstname">First Name</label>
                <input class="input" type="text" id="firstname" name="firstname" placeholder="Enter your first name"
                    required>
            </div>
            <div class="input-group">
                <label for="lastname">Last Name</label>
                <input class="input" type="text" id="lastname" name="lastname" placeholder="Enter your last name"
                    required>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <input class="input" type="text" id="address" name="address" placeholder="Enter your address" required>
            </div>
            <div class="input-group">
                <label for="contact">Contact Number</label>
                <input class="input" type="text" id="contact" name="contact" placeholder="Enter your contact number"
                    required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input class="input" type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="occupation">Occupation</label>
                <input class="input" type="text" id="occupation" name="occupation" placeholder="Enter your occupation"
                    required>
            </div>
            <div class="input-group">
                <label for="gradyear">Graduating Year</label>
                <input class="input" type="text" id="gradyear" name="gradyear" placeholder="Enter your graduating year"
                    required>
            </div>
            <div class="input-group">
                <label for="degree">Degree Program</label>
                <select class="input" type="select" id="degree" name="degree" required>
                    <option value="" disabled selected>Select your degree program</option>
                </select>
            </div>
            <div class="input-group">
                <label for="acadorg">Academic Organization</label>
                <select class="input" type="select" id="acadorg" name="acadorg" required>
                    <option value="" disabled selected>Select your academic organization</option>
                </select>
            </div>
            <div class="input-group">
                <label for="bio">Bio</label>
                <input class="input" type="text" id="bio" name="bio" placeholder="Enter your bio" required>
            </div>
            <div class="input-group">
                <label for="profilePicture">Profile Picture</label>
                <input class="input" type="file" id="profilePicture" name="profilePicture" accept="image/*" required>
                <img id="preview" src="" alt="Profile Picture Preview"
                    style="display:none; width:100px; height:100px; margin-top:10px;">
            </div>

            <button type="submit">SAVE</button>
        </form>
    </div>
</body>

</html> -->

<?php
session_start();
@include 'connect.php';

if (!isset($_SESSION['user_name']) && !isset($_SESSION['admin_name'])) {
    header('Location: login_form.php');
    exit;
}

$username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['admin_name'];
$query = "SELECT * FROM user WHERE name='$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    // Handle form submission to update profile
    // Assuming similar code to what was provided in the previous response
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/profilestyles.css">
</head>

<body>
    <div class="profile-container">
        <h2>Edit Profile</h2>
        <form class="profile-form" action="" method="POST">
            <!-- Form fields for editing profile data -->
        </form>
    </div>
</body>

</html>
