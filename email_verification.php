<?php include "functions.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <script src="https://kit.fontawesome.com/860bdcab67.js" crossorigin="anonymous"></script>
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body style="margin-top:10%; background:aliceblue">
    <?php 
if (isset($_GET['vkey']) && isset($_GET['email'])){
    $vkey = $_GET['vkey'];
    $email = $_GET['email'];
    if(getVerificationKey($email, $vkey)){
        echo"<h3 class='text-success text-center'>CONGRATULATIONS!<br>Your account has been activated</h3>";
        echo"<center><a href='signin.php' class='btn btn-success'>Sign In</a></center>";
     }
    else{
        echo "<p class='text-danger text-center'>Sorry! Your account could not be activated</p>";
    }
}
?>
</body>

</html>