<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

@include 'connect.php';

if (isset($_POST['submit'])) {

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $gradyear = mysqli_real_escape_string($conn, $_POST['gradyear']);
    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $acadorg = mysqli_real_escape_string($conn, $_POST['acadorg']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); 
    $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

    if ($pass != $cpass) {
        $error[] = 'Passwords do not match!';
    } else {

        $select = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User already exists!';
        } else {
            $insert_user = "INSERT INTO user (fname, lname, address, contact_num, email, occupation, grad_year, degree_program, academic_org, bio, password, user_type, status) 
                            VALUES ('$fname', '$lname', '$address', '$contact', '$email', '$occupation', '$gradyear', '$degree', '$acadorg', '$bio', '$pass', '$user_type', 'pending')";
            if (mysqli_query($conn, $insert_user)) {
                header('Location: login_form.php');
                exit;
            } else {
                $error[] = 'Error: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="css/registerstyles.css">
</head>

<body>
    <div class="register-container">
        <img class="logo" src="images/1.png" alt="BackinUP Logo">
        <form class="register-form" action="" method="POST">
            <h2>REGISTER</h2>
            <?php
                if(isset($error)){
                    foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                    };
                };
            ?>
            <div class="input-group">
                <label for="fname">First Name</label>
                <input class="input" type="text" id="fname" name="fname" placeholder="Enter your first name" required>
            </div>
            <div class="input-group">
                <label for="lname">Last Name</label>
                <input class="input" type="text" id="lname" name="lname" placeholder="Enter your last name" required>
            </div>
            <div class="input-group">
                <label for="address">Address</label>
                <input class="input" type="text" id="address" name="address" placeholder="Enter your address" required>
            </div>
            <div class="input-group">
                <label for="contact">Contact Number</label>
                <input class="input" type="text" id="contact" name="contact" placeholder="Enter your contact number" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input class="input" type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="occupation">Occupation</label>
                <input class="input" type="text" id="occupation" name="occupation" placeholder="Enter your occupation" required>
            </div>
            <div class="input-group">
                <label for="gradyear">Graduating Year</label>
                <input class="input" type="number" id="gradyear" name="gradyear" placeholder="Enter your graduating year" min="1947" max="2026" required>

            </div>
            <div class="input-group">
                <label for="degree">Degree Program</label>
                <select class="input" id="degree" name="degree" required>
                <option value="" disabled selected>Select your degree program</option>
                    <option value="1">BA (Communication & Media Studies)</option>
                    <option value="2">BA in Political Science</option>
                    <option value="3">BS (Biology)</option>
                    <option value="4">BS Accountancy (4.5 yrs)</option>
                    <option value="5">BS Applied Mathematics</option>
                    <option value="6">BS Chemical Engineering</option>
                    <option value="7">BS Computer Science</option>
                    <option value="8">BS Fisheries</option>
                    <option value="9">BS Food Technology</option>
                    <option value="10">BS Statistics</option>
                </select>
            </div>
            <div class="input-group">
                <label for="acadorg">Academic Organization</label>
                <select class="input" id="acadorg" name="acadorg" required>
                <option value="" disabled selected>Select your academic organization</option>
                    <option value="1">Skimmers</option>
                    <option value="2">Fisheries</option>
                    <option value="3">Redbolts</option>
                    <option value="4">Sotech</option>
                    <option value="5">Elektrons</option>
                    <option value="6">Goldies</option>
                    <option value="7">Clovers</option>
                    <option value="8">Bluechips</option>
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
            <div class="input-group">
                <label for="user_type">Account Type</label>
                <select class="input" name="user_type" required>
                    <option value="user" selected>User</option>
                </select>
            </div>
            <div class="input-group">
                <label for="bio">Bio</label>
                <input class="input" type="text" id="bio" name="bio" placeholder="Enter your bio" required>
            </div>
            <button type="submit" name="submit">REGISTER</button>
            <div class="admin">
                <p>Already have an account? <a href="login_form.php">Login now</a></p>
            </div>
        </form>
    </div>
</body>

</html>
