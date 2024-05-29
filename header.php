<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <title>Header</title>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <img src="images/2.png">
            <div class="user-actions">
                <?php 
                if(isset($_SESSION['user_name']) || isset($_SESSION['admin_name'])): 
                    $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : $_SESSION['admin_name'];
                ?>
                    <span>Welcome, <?php echo htmlspecialchars($username); ?>!</span>
                <?php endif; ?>
                <a href="events_user.php"> EVENTS </a>
                <a href="gallery.html"> GALLERY </a>
                <a href="viewProfile.php"> PROFILE </a>
                <a href="index.php"> <i class="fa-solid fa-right-from-bracket"></i> LOGOUT </a>
            </div>
        </div>
    </div>
</header>
</body>
</html>
