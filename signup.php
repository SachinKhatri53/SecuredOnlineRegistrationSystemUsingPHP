<?php include "functions.php"?>
<?php

$secretKey  = '6Le_wzQgAAAAAHXsEVpgtvTgnrQByGcvZxaMs1cx';
$strongRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$firstname = trim($_POST['firstname']);
	$lastname = trim($_POST['lastname']);
	$username = trim($_POST['username']);
	$email    = trim($_POST['email']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);
	$error = [
		'username'=> '',
		'email'=> '',
		'password'=> '',
		'confirm_password'=>'',
		'firstname'=>'',
		'lastname'=>'',
		'usual_password'=>'',
		'captcha_status'=>''
		
	];
	if($firstname == ''){
		$error['firstname'] = 'Firstname cannot be empty.';
	}
	if($lastname == ''){
		$error['lastname'] = 'Lastname cannot be empty.';
	}
	if($username == ''){
		$error['username'] = 'Username cannot be empty.';
	}
	if(!($username == '') && strlen($username) < 4){
		$error['username'] = 'Username should be longer than 4 characters.';
	}
	if(username_exists($username)){
		$error['username'] = $username . ' already exists. Try another one.';
	}
	if($email == ''){
		$error['email'] = 'Email cannot be empty.';
	}
	if(email_exists($email)){
		$error['email'] = $email . " already exists. If it's you, <a href='signin.php'>Login</a>";
	}
	if($password == ''){
		$error['password'] = 'Password cannot be empty.';
	}
	if(!($password == '') && !preg_match($strongRegex, $password)) {
			$error['password'] = 'Password is not strong.';
	}
	if($confirm_password == ''){
		$error['confirm_password'] = 'Confirm Password cannot be empty.';
	}
	if($confirm_password != $password){
		$error['confirm_password'] = 'Passwords do not match.';
	}
	if(!($password == '') && preg_match("#(($email)|($username))#", $password)){
		$error['usual_password'] = 'Password cannot be similar username/email.';
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
			register_user($firstname, $lastname, $username, $email, $password);
		}
		else{ 
			$statusMsg = 'Robot verification failed, please try again.'; 
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body
    style="background:url(https://www.nouveau.co.uk/wp-content/uploads/2016/08/AdobeStock_258718314-1080x675.jpeg);background-repeat:no-repeat;background-size:cover">

    <div class="signup-form" id="signup-form">
        <h1></h1>
        <form action="" method="post">
            <h2>Sign Up</h2>
            <p>Please fill in this form to create an account!</p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-user"></span>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                placeholder="Firstname" autocomplete="off"
                                value="<?php echo isset($firstname) ? $firstname : '' ?>">
                        </div>
                        <p class="text-danger" style="font-size:12px">
                            <?php echo isset($error['firstname']) ? $error['firstname'] : '' ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fa fa-user"></span>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname"
                                autocomplete="off" value="<?php echo isset($lastname) ? $lastname : '' ?>">
                        </div>
                        <p class="text-danger" style="font-size:12px">
                            <?php echo isset($error['lastname']) ? $error['lastname'] : '' ?></p>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <span class="fa fa-user"></span>
                        </span>
                    </div>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                        autocomplete="off" value="<?php echo isset($username) ? $username : '' ?>">
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['username']) ? $error['username'] : '' ?></p>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-paper-plane"></i>
                        </span>
                    </div>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"
                        autocomplete="off" value="<?php echo isset($email) ? $email : '' ?>">
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['email']) ? $error['email'] : '' ?></p>

            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" onkeyup="passwordStrengthCheck()" id="password"
                        name="password" placeholder="Password" autocomplete="off">
                    <span class="input-group-text" id="show_password" style="cursor: pointer;"
                        onclick="togglePassword()">
                        <i class="fa-regular fa-eye-slash" id="eye_password"></i>
                    </span>
                    <p id="randomPassword"></p>

                </div>
                <a onclick="getRandomPassword()" style="color:#01265a; font-size:12px; cursor:pointer">Generate random
                    password</a>
                <hr id="hr">
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                <p id="strength_message">Very Weak</p>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="fa fa-lock"></i>
                            <i class="fa fa-check"></i>
                        </span>
                    </div>
                    <input class="form-control" type="password" onkeyup="passwordAndConfirmPasswordCheck()"
                        onclick="hidePasswordStrengthCheck()" id="confirm_password" name="confirm_password"
                        placeholder="Confirm Password" autocomplete="off">
                    <span class="input-group-text" id="show_confirm_password" style="cursor: pointer;"
                        onclick="toggleConfirmPassword()">
                        <i class="fa-regular fa-eye-slash" id="eye_confirm_password"></i>
                    </span>
                </div>
                <p class="text-danger" style="font-size:12px">
                    <?php echo isset($error['confirm_password']) ? $error['confirm_password'] : '' ?></p>

                <div id="confirm_password_check" style="margin-top: -20px;font-size: 12px;">
                    <i class="fa-regular fa-circle-xmark" id="confirm_password_check_invalid"></i>
                </div>
            </div>
            <!-- Google reCAPTCHA -->

            <div class="g-recaptcha" data-sitekey="6Le_wzQgAAAAAN8CLEvqISqetj0cMEjXeGYCzTDG"></div>
            <p class="text-danger" style="font-size:12px">
                <?php echo isset($error['captcha_status']) ? $error['captcha_status']:'' ?></p>

                
            <div class="form-group">
                <input type="submit" name="signup" class="btn btn-primary btn-block" id="btn-submit" value="Sign Up">
                <div class="text-center">Already have an account? <a href="signin.php">Sign In</a></div>
            </div>
        </form>
    </div>
    <div id="triangle"></div>
    <div id="password-hints">
        <ul>
            <li><i class="fa-regular fa-circle-xmark" id="min_char"></i>should contain at least 8 characters</li>
            <li><i class="fa-regular fa-circle-xmark" id="alpha_numeric"></i>should be alphanumeric</li>
            <li><i class="fa-regular fa-circle-xmark" id="upper_lower"></i>should contain at least one uppercase and
                lowercase letters</li>
            <li><i class="fa-regular fa-circle-xmark" id="special_char"></i>should contain at least one special
                character</li>
        </ul>
    </div>

    <script src="js/script.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>

</html>