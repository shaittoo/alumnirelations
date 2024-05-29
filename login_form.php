<?php

@include 'connect.php';

session_start();

if(isset($_POST['submit'])){

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $gradyear = mysqli_real_escape_string($conn, $_POST['gradyear']);
    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $acadorg = mysqli_real_escape_string($conn, $_POST['acadorg']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); // Escaping password too
    $cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);

   $select = " SELECT * FROM user WHERE email = '$email' && password = '$pass' ";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'alumni'){

         $_SESSION['user_name'] = $row['name'];
         header('location:user_page.php');

      }
     
   }else{
      $error[] = 'incorrect email or password!';
   }

};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/loginstyles.css">
</head>

<body>
    <div class="login-container">
        <img class="logo" src="images/1.png" alt="BackinUP Logo" >
        <form class="login-form">
            <h2>LOGIN</h2>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                };
            };
            ?>
            <div class="input-group">
                <label for="email">Email</label>
                <input class="input" type="text" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input class="input" type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit">LOGIN</button>
            <div class="admin">
                <p> Don't have an account? <a href="register_form.php">Register now</a></p>
            </div>
        </form>
    </div>
</body>

</html>