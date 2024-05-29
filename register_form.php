<?php
include 'connect.php';
include 'registration.php';

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
            mysqli_query($conn, $insert);
            header('location:login_form.php');
        }
    }
}
?>
