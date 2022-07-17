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
    <script src="https://kit.fontawesome.com/860bdcab67.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dashboard</title>

</head>

<body style="background:aliceblue">
    <div class="container">
        <p class="text-right"><?php echo $_SESSION['username'] ?><a href="logout.php">, Logout<i
                    class="fa-solid fa-arrow-right-from-bracket"></i></a></p>
        <p class="text-right"><a href="change_password.php" class="btn btn-secondary">Change Password</a></p>

        <h1 class="text-center">Welcome to Dashboard</h1>
        <p class="text-center"><?php echo checkPasswordExpiry($_SESSION['username'])?></p>
    </div>

</body>

</html>