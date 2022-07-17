<?php include "db.php"?>
<?php
session_start();

// redirects to intended location/page
function redirect($location){
    return header("Location: " . $location);
    exit;
}

//confirms if the SQL query is running
function confirm_Query($result) {
    global $connection;
    if (!$result){
        die ('Query Failed' . mysqli_error($connection));
    }
}

//escapes special characters while accepting string from form
function escape($string){
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

//checks if the user already exists during registration
function username_exists($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    $row = mysqli_num_rows($result);
    
    if ($row > 0){
        return true;
    }
    else{
        return false;
    }
}

//checks if the email already exists during registration
function email_exists($user_email){
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$user_email'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    $row = mysqli_num_rows($result);
    
    if ($row > 0){
        return true;
    }
    else{
        return false;
    }
}


//registers new user
function register_user($firstname, $lastname, $username, $email, $password){
    global $connection;
    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname = mysqli_real_escape_string($connection, $lastname);
    $username = mysqli_real_escape_string($connection, $username);
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    $is_validated = 0;
    date_default_timezone_set("Asia/Kathmandu");
    $date=date("Y/m/d");

    $verification_key = md5(time().$username);
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

    $stmt = mysqli_prepare($connection, "INSERT INTO users(firstname, lastname, username, user_password, user_email, vkey, is_validated, date) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, 'ssssssss', $firstname, $lastname, $username, $password, $email, $verification_key, $is_validated, $date);
                mysqli_stmt_execute($stmt);
                confirm_Query($stmt);
                mysqli_stmt_close($stmt);

    if($stmt){
        $_SESSION['logged_in'] = "logged_in";
        $subject="Email Verification";
        $from = "noreply@ismt.com";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $message ="
        <html>
        <head>
        <title>Email Verification</title>
        </head>
        <body>
        <h2>Dear $username,</h2>
        <p>Thank you for requesting user registration. Please click link given below to activate your user account.</p>
        <center><a href='http://localhost:8080/CyberSecurity/email_verification.php?vkey=$verification_key&email=$email'>Verify</a><center>
        </body>
        </html>";
        
        mail($email, $subject, $message, $headers);

        echo '<script type="text/javascript"> window.open("thankyou.php", "_blank")</script>';
    }
}


//user login
function login_user($username, $password){
    global $connection;
    $username = trim($username);
    $password = trim($password);
    $username = escape($username);
    $password = escape($password);
    
    $query = "SELECT * FROM users WHERE (user_email = '{$username}' OR username = '{$username}') AND is_validated = 1";
    $select_user = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_array($select_user)) {
    $db_user_id = $row ['uid'];
    $db_username = $row ['username'];
    $db_user_email = $row ['user_email'];
    $db_user_password = $row ['user_password'];
    $db_is_verified = $row['is_validated'];
        if (password_verify($password, $db_user_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['user_email'] = $db_user_email;
        $_SESSION['logged_in'] = "logged_in";
        sendOtpEmail($db_user_email);
        redirect("login_verification.php");
        }
    }
}


//after registration, activates the user account through provided link as an email
function getVerificationKey($email, $vkey){
    global $connection;
    $email = escape($email);
    $vkey = escape($vkey);
    $query = "UPDATE users SET vkey = '0', is_validated = 1 WHERE user_email = '{$email}' AND vkey = '{$vkey}'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    if(!$result){
        return false;
    }
    recordPasswords($email);
    return true;
}


//checks if the registered user is verified or not
function notVerifiedUser($username){
    global $connection;
    $username = escape(trim($username));
    $query = "SELECT * FROM users WHERE (username = '{$username}' OR user_email = '{$username}' ) AND is_validated = 0";
    $select_user = mysqli_query($connection, $query);
    confirm_Query($select_user);
    $row = mysqli_num_rows($select_user);
    if ($row > 0){
        return true;
    }
    else{
        return false;
    }
}


//While logging in, it sends a 8 digits code to email for two factor authentication
function sendOtpEmail($email){
    $verification_code = rand(100000, 999999);
    $_SESSION['verification_code'] = $verification_code;
    $_SESSION['email'] = $email;
        $subject="Two Factor Authentication";
        $from = 'noreply@cybersecurity.com';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $message="<html>
        <head>
        <title>Email Verification</title>
        </head>
        <body>
        <h2>Hi there,</h2>
        <p>Your verification code is: $verification_code</p>
        <p>CONFIDENTIALITY NOTICE: If you have received this communication in error, 
        please immediately delete this message.</p>
        </body>
        </html>";
        
        mail($email, $subject, $message, $headers);
}


//upon successful verified user registration and change password processes, stores the passwords of particular user.
function recordPasswords($email){
    global $connection;
    $query = "SELECT * FROM users WHERE user_email = '{$email}'";
    $select_user = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_user)) {
    $db_user_name = $row ['username'];
    $db_user_password = $row ['user_password'];
    $stmt = mysqli_prepare($connection, "INSERT INTO passwords(username, password) VALUES(?, ?)");
                mysqli_stmt_bind_param($stmt, 'ss', $db_user_name, $db_user_password);
                mysqli_stmt_execute($stmt);
                confirm_Query($stmt);
                mysqli_stmt_close($stmt);
    }
    return true;
    
}


//changes password of verified user
function changePassword($username, $newPassword){
    global $connection;
    $username = escape($username);
    $password = escape($newPassword);
    date_default_timezone_set("Asia/Kathmandu");
    $date=date("Y/m/d");
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
        $query = "UPDATE users SET user_password = '{$hashed_password}', date = '{$date}' WHERE username = '{$username}'";
        $result = mysqli_query($connection, $query);
        confirm_Query($result);
        if(!$result){
            return false;
        }
        return true;   
}

//while changning new password, prevents from entering already used password
function checkPasswordHistory($username, $password){
    global $connection;
    $query = "SELECT * FROM passwords WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    while ($row = mysqli_fetch_array ($result)) {
        $row_password = $row['password'];
            if(password_verify($password, $row_password)){
                return false;
            }
    }
    return true;
}


//checks if user has provided correct old passsword while changing with new one
function checkOldPassword($username, $oldPassword){
    global $connection;
    $username = escape($username);
    $password = escape($oldPassword);
    $select_query = "SELECT user_password FROM users WHERE username = '$username'";
    $query_result = mysqli_query($connection, $select_query);

    while ($row = mysqli_fetch_array($query_result)) {
            $db_user_password = $row ['user_password'];
            if (password_verify($password, $db_user_password)) {
                return true;
            }
        }
}


//returns the difference of two dates
function dateDiffInDays($date1, $date2){
      $diff = strtotime($date2) - strtotime($date1);
      return abs(round($diff / 86400));

}

//checks if the password has expired or not.
//if password exceeds 60 days without changing, forces user to change the password
function checkPasswordExpiry($username){
    global $connection;
    date_default_timezone_set("Asia/Kathmandu");
    $date=date("Y/m/d");
    $username = escape($username);
    $select_query = "SELECT date FROM users WHERE username = '$username'";
    $query_result = mysqli_query($connection, $select_query);

    while ($row = mysqli_fetch_array($query_result)) {
            $db_date = $row ['date'];
            $count = 60-dateDiffInDays($db_date, $date);
           if($count>1 && $count<=60){
                echo "Your password will expire after ". $count . " day/s.";
            }
            else{
                $_SESSION['expiry_message']="Your password has expired. Please change your password.";
                redirect("change_password.php");
            }           
    }
}

?>