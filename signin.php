<?php include "functions.php"?>
<?php        
    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $secretKey  = '6Le_wzQgAAAAAHXsEVpgtvTgnrQByGcvZxaMs1cx';
        $error = [
            'username'=> '',
            'notverifieduser'=> '',
            'password'=> '',
            'captcha_status'=>''           
        ];

        if($password == ''){
            $error['password'] = 'Password cannot be empty.';
        }
        if($username == ''){
            $error['username'] = 'Username/Email cannot be empty.';
        }

        if(notVerifiedUser($username)){
            $error['username'] = 'User has not been verified';
        }
        if(!($username =='') && !notVerifiedUser($username)){
            if(!username_exists($username) || !email_exists($username)){
                $error['username'] = 'Username/Email does not exist.';
            }
        }
        
        if(!notVerifiedUser($username)){
            if(!login_user($username, $password) && username_exists($username)){
                $error['username'] = 'Check your username and passsword';
            }
        }
        
        if(empty($_POST['g-recaptcha-response'])){
            $error['captcha_status'] = 'Please check the reCAPTCHA checkbox.';	
        }
        
        foreach ($error as $key => $value){
            if(empty($value)){
                unset($error[$key]);
            }
        }
        
        if(empty($error)){
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if($responseData->success){
                    login_user($username, $password);
                }
            
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <script src="https://kit.fontawesome.com/860bdcab67.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Sign In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>

<body
    style="background:url(https://www.nouveau.co.uk/wp-content/uploads/2016/08/AdobeStock_258718314-1080x675.jpeg);background-repeat:no-repeat;background-size:cover">
    <div class="signup-form">
        <form action="" method="post">
            <div class="form-group">
                <h2>Sign In</h2>
                <p>Please fill in this form to sign in!</p>
                </hr>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fa fa-user"></span>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username/Email"
                        autocomplete="off" value="<?php echo isset($username) ? $username : '' ?>">
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['username']) ? $error['username'] : '' ?></p>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Password"
                        autocomplete="off" onkeyup="showEye()">
                    <span class="input-group-text" id="show_pass" style="cursor: pointer;display:none"
                        onclick="togglePassword()">
                        <i class="fa-regular fa-eye-slash" id="eye_password"></i>
                    </span>
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['password']) ? $error['password'] : '' ?></p>
            </div>
            <!-- Google reCAPTCHA -->

            <div class="g-recaptcha" data-sitekey="6Le_wzQgAAAAAN8CLEvqISqetj0cMEjXeGYCzTDG"></div>
            <p class="text-danger" style="font-size:12px">
                <?php echo isset($error['captcha_status']) ? $error['captcha_status']:'' ?></p>
            <div class="form-group">
                <input type="submit" name="signin" class="btn btn-primary btn-block" id="btn-submit" value="Sign in">
                <div class="text-center">
                    Don't have an account? <a href="signup.php">Sign Up</a>
                </div>
            </div>
        </form>
    </div>
    <script src="js/script_signin.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>