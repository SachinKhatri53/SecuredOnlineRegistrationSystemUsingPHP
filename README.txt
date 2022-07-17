------------------------------------------
Project Title:- Online Regestration System
------------------------------------------

-------------------
Project Description
-------------------
The propsed online registration system collects user registration details where user is activated only after verifying his/her email.
While signing in, user has to pass two factor authentication.
The project contains password policies such as password combination(8 characters, alphanumeric, upper-lower case and special characters).
Other functionalities include password expiry, no repetition of password, etc.
The backend programming PHP has been used whereas UI is supported by HTML5, CSS3, Bootstrap4 and JavaScript.

--------------------
Installation Process
--------------------
step 1:- Install XAMPP in you device
step 2:- Unzip the provided folder with software such as WinRAR, 7-Zip, PeaZip, etc.
step 3:- copy/move unzipped folder inside htdocs folder of xampp folder.

Note:- Since, the project is tested in localhost,few changes have been made in php.ini(inside php folder) and sendmail.ini(inside sendmail folder) files to send mail.
-------------------
inside php.ini file
-------------------
SMTP = smtp.gmail.com
smtp_port=465
sendmail_from = your email address from which mail can be sent
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

------------------------
inside sendmail.ini file
------------------------
smtp_server=smtp.gmail.com
smtp_port=465
error_logfile=error.log
debug_logfile=debug.log
auth_username= your email address from which mail can be sent
auth_password= can be obtained from google account setting
force_sender= your email address from which mail can be sent

-------------------
Running the Project
-------------------
step 1:- run the XAMPP controller and start apache and MySQL
step 2:- follow the link http://localhost:8080/phpmyadmin/ and create database named 'cybersecurity'.
step 3:- create tables users and passwords under the structure given below:
	users:- uid int Auto Increment, firstname varchar(255), lastname varchar(255), username(255), user_email(255), user_password(255), vkey(255), is_validated int, date(255)
	passwords: pid int Auto Increment, username varchar(255), password varchar(255)
step 3:- follow the link http://localhost:8080/CyberSecurity/signup.php to start with registration process.

If you face any problem while running this project please contact at sachinkhatri53@gmail.com