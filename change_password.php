<?php include "functions.php" ?>
<?php
if(empty($_SESSION['logged_in']) || $_SESSION['logged_in'] == ''){
    redirect('signin.php');
    die();
}

$secretKey  = '6Le_wzQgAAAAAHXsEVpgtvTgnrQByGcvZxaMs1cx';

$weakRegex = "/[a-z]/";
$mediumRegex = "/^(((?=.*[a-z])(?=.*[A-Z]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(?=.{6,})/";
$strongRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";

if(isset($_POST['changePassword'])){
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];
    $username = $_SESSION['username'];
    $email = $_SESSION['user_email'];
    $error = [
		'oldPassword'=> '',
		'newPassword'=> '',
		'confirmPassword'=> '',
        'captcha_status'=>''		
	];
    if($oldPassword == ''){
        $error['oldPassword'] = 'Please enter your old password.';
    }
    if($confirmPassword == ''){
        $error['confirmPassword'] = 'Confirm password cannot be empty.';
    }
    if($newPassword == ''){
        $error['newPassword'] = 'Please enter your new password.';
    }
    else if($newPassword != $confirmPassword){
        $error['confirmPassword'] = 'Passwords do not match.';
    }
    else if(!preg_match($strongRegex, $newPassword)){
		$error['newPassword'] = 'Password is not strong.';
	}
    else if(($oldPassword == $confirmPassword) || ($oldPassword == $newPassword)){
        $error['newPassword'] = 'Your password is still old.';
    }
    
    else if(!checkOldPassword($username, $oldPassword)){
        $error['oldPassword'] = 'Please enter correct old password.';
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
        if(!checkPasswordHistory($username, $newPassword)){
            $message="Password has been used before. Try new one.";
            $color="text-danger";
        }
        else{
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
                $responseData = json_decode($verifyResponse);
                if($responseData->success){
                    if(changePassword($username, $newPassword)){
                        recordPasswords($email);
                        $message="Password has been changed successfully";
                        $color="text-success";
                    }
                }
            
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
    <script src="https://kit.fontawesome.com/860bdcab67.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    #change-password {

        width: 30%;
        background: aliceblue;
        padding: 20px 40px;
        border: solid 2px black;
        position: absolute;
        top: 40px;
        right: 118px;
    }
    </style>
</head>

<body
    style="background:url(https://www.nouveau.co.uk/wp-content/uploads/2016/08/AdobeStock_258718314-1080x675.jpeg);background-repeat:no-repeat;background-size:cover">
    <p style="margin:20px;"><a href="dashboard.php" style="color:aliceblue">back</a></p>
    <div class="signup-form">
        <form action="" method="post">
            <div class="form-group">
                <h4 class="text-secondary">Change Password</h4>
                <h6>
                    <?php if(isset($_SESSION['expiry_message'])){
                                echo $_SESSION['expiry_message'];
                                unset($_SESSION['expiry_message']);
                            }
                            ?>
                </h6>
                <p class="<?php echo $color?>"><?php echo isset($message) ? $message : '' ?></p>
                </hr>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fa fa-lock"></span>
                        </span>
                    </div>
                    <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                        placeholder="Old Password" autocomplete="off" onkeyup="showOldEye()">
                    <span class="input-group-text" id="showOldPassword" style="cursor: pointer;display:none"
                        onclick="toggleOldPassword()">
                        <i class="fa-regular fa-eye-slash" id="eyeOldPassword"></i>
                    </span>
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['oldPassword']) ? $error['oldPassword'] : '' ?></p>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" id="newPassword" name="newPassword"
                        placeholder="New Password" autocomplete="off" onkeyup="showNewEye()">
                    <span class="input-group-text" id="showNewPassword" style="cursor: pointer;display:none"
                        onclick="toggleNewPassword()">
                        <i class="fa-regular fa-eye-slash" id="eyeNewPassword"></i>
                    </span>
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['newPassword']) ? $error['newPassword'] : '' ?></p>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" id="confirmPassword" name="confirmPassword"
                        placeholder="Confirm Password" autocomplete="off" onkeyup="showConfirmEye()">
                    <span class="input-group-text" id="showConfirmPassword" style="cursor: pointer;display:none"
                        onclick="toggleNewPassword()">
                        <i class="fa-regular fa-eye-slash" id="eyeConfirmPassword"></i>
                    </span>
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['confirmPassword']) ? $error['confirmPassword'] : '' ?></p>
                <div class="password-hint">
                    <ul>
                        <li>should contain at least 8 characters</li>
                        <li>should be alphanumeric</li>
                        <li>should contain at least one uppercase and lowercase letters</li>
                        <li>should contain at least one special character</li>
                    </ul>
                </div>
            </div>
            <!-- Google reCAPTCHA -->

            <div class="g-recaptcha" data-sitekey="6Le_wzQgAAAAAN8CLEvqISqetj0cMEjXeGYCzTDG"></div>
            <p class="text-danger" style="font-size:12px">
                <?php echo isset($error['captcha_status']) ? $error['captcha_status']:'' ?></p>
            <div class="form-group">
                <input type="submit" name="changePassword" class="btn btn-primary btn-block" id="btn-submit"
                    value="Change Pasword">
            </div>
        </form>
    </div>
    <script src="js/change_password.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>