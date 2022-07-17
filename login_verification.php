<?php include "functions.php" ?>
<?php
if(empty($_SESSION['logged_in']) || $_SESSION['logged_in'] == ''){
    redirect('signin.php');
    die();
}else{
    if(isset($_POST['submit-otp-code'])){
        // $username = $_SESSION['verification_code'];
        
        $verification_code = $_POST['vcode'];
        if($_SESSION['verification_code'] == $verification_code){
            redirect('dashboard.php');
        }
        else{
            $message = "Invalid verification code.";
        }
    }
}
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background:aliceblue">
    <div class="container" style="position:absolute;top:20%;left:8%">
      
        <h4 style="text-align:center">We have sent verification code to
            <?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''?>. Kindly check your email to
            login.</h4>
        <u></u>
        <p class="text-center">Note: Don't forget to check you spam message.</p></u>
        <form method="POST">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group col-md-4">
                    <input type="number" class="form-control" id="code" placeholder="Code" name="vcode" required>
                </div>
            </div>
            <p class="text-danger text-center">
                <?php
                    echo isset($message) ? $message : '';
                ?>
                </p>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="form-group col-md-2">
                    <input type="submit" class="btn btn-primary" value="Confirm identity" name="submit-otp-code">
                </div>
            </div>
        </form>
       <center><a href='signin.php'>Didn't recieve a code? Try Again.</a></center>;
    </div>
</body>

</html>