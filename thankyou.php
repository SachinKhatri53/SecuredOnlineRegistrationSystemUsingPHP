<?php include "functions.php" ?>
<?php
if(empty($_SESSION['logged_in']) || $_SESSION['logged_in'] == ''){
    redirect('signin.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <script src="https://kit.fontawesome.com/860bdcab67.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="padding-top:10%; background:aliceblue">
    <h3 class="text-center">We have sent verification link to <a href="http://mail.google.com/mail"
            target="_blank"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''?></a>.</h3>
    <h5 class="text-center">Kindly check your email to complete registration process.</h5>
    <h1 style="text-align:center">Thank You!</h1>
    <center><a href="signin.php" class="btn btn-success">Sign In</a>
        <a href="signup.php" class="btn btn-primary">Sign Up</a>
    </center>
</body>

</html>