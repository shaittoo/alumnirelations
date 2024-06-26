<?php
@include 'connect.php';

session_start();

$error = array(); 

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']); 

    $select = "SELECT * FROM user WHERE email = '$email' AND password = '$pass'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if ($row['user_type'] == 'admin') {
            $_SESSION['user_id_admin'] = $row['user_id'];
            header('location: events_admin.php'); 
            exit;
        } elseif ($row['user_type'] == 'user') {
            if ($row['status'] == 'approved') {  
                $_SESSION['user_id'] = $row['user_id'];
                header('location: events_user.php');
                exit;
            } elseif ($row['status'] == 'pending') {
                $error[] = 'Your account is not approved yet.';
            }else{
                $error[] = 'Your registration has been rejected.';
            }
        }
    } else {
        $error[] = 'Incorrect email or password!';
    }
}
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
        <img class="logo" src="images/1.png" alt="BackinUP Logo">
        <form class="login-form" action="" method="POST"> 
            <h2>LOGIN</h2>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <div class="input-group">
                <label for="email">Email</label>
                <input class="input" type="text" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input class="input" type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="submit">LOGIN</button>
            <div class="admin">
                <p> Don't have an account? <a href="register_form.php">Register now</a></p>
            </div>
        </form>
    </div>
</body>

</html>
