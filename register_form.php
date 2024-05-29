<?php
include 'connect.php';

if(isset($_POST['submit'])){

    $fname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $gradyear = mysqli_real_escape_string($conn, $_POST['gradyear']);
    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $acadorg = mysqli_real_escape_string($conn, $_POST['acadorg']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    $profilePicture = $_FILES['profilePicture'];

    if ($profilePicture['error'] === 0) {
        $profilePicName = $profilePicture['name'];
        $profilePicTmpName = $profilePicture['tmp_name'];
        $profilePicDestination = 'uploads/' . $profilePicName;
        move_uploaded_file($profilePicTmpName, $profilePicDestination);
    } else {
        $profilePicDestination = null;
    }

    $select = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
        $error[] = 'User already exists!';
    } else {
        if($pass != $cpass){
            $error[] = 'Passwords do not match!';
        } else {
            $insert = "INSERT INTO users (first_name, last_name, address, contact_number, email, occupation, graduating_year, degree_program_id, academic_organization_id, bio, password, profile_picture, user_type)
                        VALUES ('$fname', '$lname', '$address', '$contact', '$email', '$occupation', '$gradyear', '$degree', '$acadorg', '$bio', '$pass', '$profilePicDestination', '$user_type')";

            if(mysqli_query($conn, $insert)) {
                header('Location: login_form.php');
                exit();
            } else {
                $error[] = 'Error: '. mysqli_error($conn);
            }
        }
    }

    if(isset($error)) {
        foreach($error as $err) {
            echo '<span class="error-msg">'.$err.'</span>';
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
        <form class="register-form" action="register_form.php" method="POST" enctype="multipart/form-data">
            <h2>REGISTER</h2>
            <?php
                  if(isset($error)){
                     foreach($error as $error){
                        echo '<span class="error-msg">'.$error.'</span>';
                     };
                  };
            ?>
            <div class="input-group">
                <label for="firstname">First Name</label>
                <input class="input" type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
            </div>
            <div class="input-group">
                <label for="lastname">Last Name</label>
                <input class="input" type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>
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
                <input class="input" type="text" id="gradyear" name="gradyear" placeholder="Enter your graduating year" required>
            </div>
            <div class="input-group">
                <label for="degree">Degree Program</label>
                <select class="input" id="degree" name="degree" required>
                    <option value="" disabled selected>Select your degree program</option>
                    <option value="1">BA (Communication & Media Studies)</option>
                    <option value="2">BA (Community Development)</option>
                    <option value="3">BA (History)</option>
                    <option value="4">BA (Sociology)</option>
                    <option value="5">BA in Literature</option>
                    <option value="6">BA in Political Science</option>
                    <option value="7">BA in Psychology</option>
                    <option value="8">BS (Biology)</option>
                    <option value="9">BS Accountancy (4.5 yrs)</option>
                    <option value="10">BS Applied Mathematics</option>
                    <option value="11">BS Business Administration (Marketing)</option>
                    <option value="12">BS Chemical Engineering</option>
                    <option value="13">BS Chemistry</option>
                    <option value="14">BS Computer Science</option>
                    <option value="15">BS Economics</option>
                    <option value="16">BS Fisheries</option>
                    <option value="17">BS Food Technology</option>
                    <option value="18">BS Management</option>
                    <option value="19">BS Public Health</option>
                    <option value="20">BS Statistics</option>
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
                    <option value="" disabled selected>Select your account type</option>
                    <option value="user">Alumni</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="input-group">
                <label for="bio">Bio</label>
                <input class="input" type="text" id="bio" name="bio" placeholder="Enter your bio" required>
            </div>
            <div class="input-group">
                <label for="profilePicture">Profile Picture</label>
                <input class="input" type="file" id="profilePicture" name="profilePicture" accept="image/*" required>
                <img id="preview" src="" alt="Profile Picture Preview" style="display:none; width:100px; height:100px; margin-top:10px;">
            </div>

            <button type="submit" name="submit">REGISTER</button>
        </form>
    </div>
</body>

</html>
