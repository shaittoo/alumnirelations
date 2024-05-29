<?php
session_start();
@include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login_form.php');
    exit;
}
$username = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE user_id='$username'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Error fetching user data.";
    exit;
}

$user = mysqli_fetch_assoc($result);

if (isset($_POST['update'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $gradyear = mysqli_real_escape_string($conn, $_POST['gradyear']);
    $degree_program = mysqli_real_escape_string($conn, $_POST['degree']);
    $academic_org = mysqli_real_escape_string($conn, $_POST['acadorg']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); 
    $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    
    $update_query = "UPDATE user SET 
                        fname = '$fname', 
                        lname = '$lname', 
                        address = '$address', 
                        contact_num = '$contact', 
                        email = '$email', 
                        occupation = '$occupation', 
                        grad_year = '$gradyear', 
                        degree_program = '$degree_program', 
                        academic_org = '$academic_org',
                        bio = '$bio'
                    WHERE user_id = '$username'";

    if (mysqli_query($conn, $update_query)) {
        header('Location: viewProfile.php');
        exit;
    } else {
        echo "Error updating user: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/registerstyles.css">
</head>

<body>
    <div class="register-container">
        <img class="logo" src="images/1.png" alt="BackinUP Logo">
        <form class="register-form" action="" method="POST">
            <h2>EDIT PROFILE</h2>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
            ?>
            <div class="input-group">
                <label for="fname">First Name</label>
                <input class="input" type="text" id="fname" name="fname" placeholder="Enter your first name" value="<?php echo htmlspecialchars($user['fname']); ?>" required>
            </div>
            <div class="input-group">
                <label for="lname">Last Name</label>
                <input class="input" type="text" id="lname" name="lname" placeholder="Enter your last name" value="<?php echo htmlspecialchars($user['lname']); ?>" required>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <input class="input" type="text" id="address" name="address" placeholder="Enter your address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <div class="input-group">
                <label for="contact">Contact Number</label>
                <input class="input" type="text" id="contact" name="contact" placeholder="Enter your contact number" value="<?php echo htmlspecialchars($user['contact_num']); ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input class="input" type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="input-group">
                <label for="occupation">Occupation</label>
                <input class="input" type="text" id="occupation" name="occupation" placeholder="Enter your occupation" value="<?php echo htmlspecialchars($user['occupation']); ?>" required>
            </div>
            <div class="input-group">
                <label for="gradyear">Graduating Year</label>
                <input class="input" type="text" id="gradyear" name="gradyear" placeholder="Enter your graduating year" value="<?php echo htmlspecialchars($user['grad_year']); ?>" required>
            </div>
            <div class="input-group">
                <label for="degree">Degree Program</label>
                <select class="input" id="degree" name="degree" required>
                    <option value="" disabled>Select your degree program</option>
                    <option value="1" <?php if($user['degree_program'] == '1') echo 'selected'; ?>>BA (Communication & Media Studies)</option>
                    <option value="2" <?php if($user['degree_program'] == '2') echo 'selected'; ?>>BA in Political Science</option>
                    <option value="3" <?php if($user['degree_program'] == '3') echo 'selected'; ?>>BS (Biology)</option>
                    <option value="4" <?php if($user['degree_program'] == '4') echo 'selected'; ?>>BS Accountancy (4.5 yrs)</option>
                    <option value="5" <?php if($user['degree_program'] == '5') echo 'selected'; ?>>BS Applied Mathematics</option>
                    <option value="6" <?php if($user['degree_program'] == '6') echo 'selected'; ?>>BS Chemical Engineering</option>
                    <option value="7" <?php if($user['degree_program'] == '7') echo 'selected'; ?>>BS Computer Science</option>
                    <option value="8" <?php if($user['degree_program'] == '8') echo 'selected'; ?>>BS Fisheries</option>
                    <option value="9" <?php if($user['degree_program'] == '9') echo 'selected'; ?>>BS Food Technology</option>
                    <option value="10" <?php if($user['degree_program'] == '10') echo 'selected'; ?>>BS Statistics</option>
                </select>
            </div>
            <div class="input-group">
                <label for="acadorg">Academic Organization</label>
                <select class="input" id="acadorg" name="acadorg" required>
                    <option value="" disabled>Select your academic organization</option>
                    <option value="1" <?php if($user['academic_org'] == '1') echo 'selected'; ?>>Skimmers</option>
                    <option value="2" <?php if($user['academic_org'] == '2') echo 'selected'; ?>>Fisheries</option>
                    <option value="3" <?php if($user['academic_org'] == '3') echo 'selected'; ?>>Redbolts</option>
                    <option value="4" <?php if($user['academic_org'] == '4') echo 'selected'; ?>>Sotech</option>
                    <option value="5" <?php if($user['academic_org'] == '5') echo 'selected'; ?>>Elektrons</option>
                    <option value="6" <?php if($user['academic_org'] == '6') echo 'selected'; ?>>Goldies</option>
                    <option value="7" <?php if($user['academic_org'] == '7') echo 'selected'; ?>>Clovers</option>
                    <option value="8" <?php if($user['academic_org'] == '8') echo 'selected'; ?>>Bluechips/option>
                </select>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input class="input" type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-group">
                <label for="cpassword">Confirm Password</label>
                <input class="input" type="password" id="cpassword" name="cpassword" placeholder="Confirm your password" required>
            </div>
            <!-- <div class="input-group">
                <label for="user_type">Account Type</label>
                <select class="input" name="user_type" required>
                    <option value="user" selected>User</option>
                </select>
            </div> -->
            <div class="input-group">
                <label for="bio">Bio</label>
                <input class="input" type="text" id="bio" name="bio" placeholder="Enter your bio" value="<?php echo htmlspecialchars($user['bio']); ?>" required>
            </div>
            <button type="update" name="update">SAVE</button>
        </form>
    </div>
</body>

</html>

