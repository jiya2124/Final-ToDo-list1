<?php session_start(); ?>
<?php require_once('constant.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="src/style.css" />
    <title>Document</title>
</head>
<body>
<!-- if user is already logged in display user profile -->    
    <?php
    if(isset($_SESSION['user_id']))
    {
        header("Location: user_profile.php");
    }
    ?>
<div class="container">
<!-- LOGIN FORM -->
    <div class = "login">
        <h1>LOGIN</h1>
        <form method="post" action='form_submit.php'>

            <input name="email" type="email" placeholder="Enter Email" 
            value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>" required><br>
            
            <input name="password" type="password" placeholder="Enter password" required><br>
<!-- Generating Errors -->
            <span>
            <?php echo isset($_SESSION['password_error']) ? $_SESSION['password_error'] : '' ?>
            <?php echo !isset($_SESSION['email']) && isset($_SESSION['error']) ? $_SESSION['error'] : '' ?>
            </span><br>
            
            <input name="submit" type="submit" value="LOGIN" />
        </form>
    </div>
</div>
</body>
</html>