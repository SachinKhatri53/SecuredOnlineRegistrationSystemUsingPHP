var username = document.getElementById("usename");
var email = document.getElementById("email");
var password = document.getElementById("password");
var confirmPassword = document.getElementById("confirm_password");
var confirmPasswordCheck = document.getElementById("confirm_password_check");
var passwordHints = document.getElementById("password-hints");
var hr = document.getElementById("hr");
var strengthMessage = document.getElementById("strength_message");
var showPassword = document.getElementById("show_password");
var showConfirmPassword = document.getElementById("show_confirm_password");
var eyePassword = document.getElementById("eye_password");
var eyeConfirmPassword = document.getElementById("eye_confirm_password");
var submitButton = document.getElementById("btn-submit");


var minChar = document.getElementById("min_char");
var alphaNumeric = document.getElementById("alpha_numeric");
var upperLower = document.getElementById("upper_lower");
var specialChar = document.getElementById("special_char");

var upperCaseChars = "(.*[A-Z].*)";
var lowerCaseChars = "(.*[a-z].*)";
var numbers = "(.*[0-9].*)";
var specialChars = "(.*[`,~,!,@,#,$,%,^,&,*,-,_].*$)";

function passwordStrengthCheck() {
  
  if(password.value != ""){
    passwordHints.style.display = "block"; 
    document.getElementById("triangle").style.display = "block"; 
    hr.style.display = "block";
    strengthMessage.style.display="block";
    showPassword.style.display="block";
    minCharCheck();
    alphaNumericCheck();
    upperLowerCaseCheck();
    specialCharCheck();
    weakPasswordStrengthMeter();
    moderatePasswordStrengthMeter();
    strongPasswordStrengthMeter();
    passwordAndConfirmPasswordCheck();
  }
  else{
    passwordHints.style.display = "none";
    hr.style.display = "none";
    document.getElementById("triangle").style.display = "none"; 
    strengthMessage.style.display="none";
    showPassword.style.display="none";
  }
}

function passwordAndConfirmPasswordCheck(){
  if(confirmPassword.value == ""){
    showConfirmPassword.style.display="none";
    confirmPasswordCheck.style.display = "none";
  }
  else{
    showConfirmPassword.style.display="block";
    confirmPasswordCheck.style.display = "block";
    if(confirmPassword.value != password.value){
      confirmPasswordCheck.innerHTML = "Passwords do not match."
      confirmPasswordCheck.style.color = "red";
    }
    else{
      confirmPasswordCheck.innerHTML = "Passwords match."
      confirmPasswordCheck.style.color = "green";
    }
  }
}
function minCharCheck(){
  if((password.value).length >= 8){
    minChar.style.color = "green";
    minChar.classList.remove("fa-circle-xmark");
    minChar.classList.add("fa-circle-check");
    return true;
  }
  else{
    minChar.style.color = "red";
    minChar.classList.remove("fa-circle-check");
    minChar.classList.add("fa-circle-xmark");
    return false;
  }
}
function alphaNumericCheck(){
  if(((password.value).match(numbers) && (password.value).match(lowerCaseChars)) || ((password.value).match(numbers) && (password.value).match(upperCaseChars))){
    alphaNumeric.style.color = "green";
    alphaNumeric.classList.remove("fa-circle-xmark");
    alphaNumeric.classList.add("fa-circle-check");
    return true;
  }
  else{
    alphaNumeric.style.color = "red";
    alphaNumeric.classList.remove("fa-circle-check");
    alphaNumeric.classList.add("fa-circle-xmark");
    return false;
  }
}
function upperLowerCaseCheck(){
  if((password.value).match(upperCaseChars) && (password.value).match(lowerCaseChars)){
    upperLower.style.color = "green";
    upperLower.classList.remove("fa-circle-xmark");
    upperLower.classList.add("fa-circle-check");
    return true;
  }
  else{
    upperLower.style.color = "red";
    upperLower.classList.remove("fa-circle-check");
    upperLower.classList.add("fa-circle-xmark");
    return false;
  }
}
function specialCharCheck(){
  if((password.value).match(specialChars)){
    specialChar.style.color = "green";
    specialChar.classList.remove("fa-circle-xmark");
    specialChar.classList.add("fa-circle-check");
    return true;
  }
  else{
    specialChar.style.color = "red";
    specialChar.classList.remove("fa-circle-check");
    specialChar.classList.add("fa-circle-xmark");
    return false;
  }
}
function weakPasswordStrengthMeter(){
  if((alphaNumericCheck() && minCharCheck()) || (upperLowerCaseCheck() && minCharCheck())){
    hr.style.width = "50%";
    hr.style.borderColor = "#ffd43b";
    strengthMessage.innerHTML = "Weak"
    strengthMessage.style.color = "#ffd43b";
  }
  else{
    hr.style.borderColor = "red";
	  hr.style.width = "25%";
    strengthMessage.innerHTML = "Very Weak"
    strengthMessage.style.color = "red";
  }
}
function moderatePasswordStrengthMeter(){
  if((alphaNumericCheck() && minCharCheck() && upperLowerCaseCheck()) || (alphaNumericCheck() && minCharCheck() && specialCharCheck()) || (minCharCheck() && specialCharCheck())){
    hr.style.width = "75%";
    hr.style.borderColor = "orange";
    strengthMessage.innerHTML = "Moderate"
    strengthMessage.style.color = "orange";
  }
}
function strongPasswordStrengthMeter(){
  if((minCharCheck() && alphaNumericCheck() && upperLowerCaseCheck() && specialCharCheck())){
    hr.style.width = "100%";
    hr.style.borderColor = "green";
    strengthMessage.innerHTML = "Strong"
    strengthMessage.style.color = "green";
  }
}

function togglePassword(){
  if (password.type === "password") {
    password.type = "text";
    eyePassword.classList.remove("fa-eye-slash")
    eyePassword.classList.add("fa-eye")
  } else {
    password.type = "password";
    eyePassword.classList.remove("fa-eye")
    eyePassword.classList.add("fa-eye-slash")
  }
}

function toggleConfirmPassword(){
  if (confirmPassword.type === "password") {
    confirmPassword.type = "text";
    eyeConfirmPassword.classList.remove("fa-eye-slash")
    eyeConfirmPassword.classList.add("fa-eye")
  } else {
    confirmPassword.type = "password";
    eyeConfirmPassword.classList.remove("fa-eye")
    eyeConfirmPassword.classList.add("fa-eye-slash")
  }
}

function hidePasswordStrengthCheck(){
  passwordHints.style.display = "none";
  document.getElementById("triangle").style.display = "none"; 
}
var randomPassword = document.getElementById("randomPassword");
function passwordGenerator( len ) {
  var length = (len)?(len):(10);
  var string = "abcdefghijklmnopqrstuvwxyz"; //to upper 
  var numeric = '0123456789';
  var punctuation = '!@#$%^&*()_+~`|}{[]\:;?><,./-=';
  var password = "";
  var character = "";
  var crunch = true;
  while( password.length<length ) {
      entity1 = Math.ceil(string.length * Math.random()*Math.random());
      entity2 = Math.ceil(numeric.length * Math.random()*Math.random());
      entity3 = Math.ceil(punctuation.length * Math.random()*Math.random());
      hold = string.charAt( entity1 );
      hold = (password.length%2==0)?(hold.toUpperCase()):(hold);
      character += hold;
      character += numeric.charAt( entity2 );
      character += punctuation.charAt( entity3 );
      password = character;
  }
  password=password.split('').sort(function(){return 0.5-Math.random()}).join('');
  return password.substr(0,len);
}
function getRandomPassword() {
  password.type = "text";
  password.value = passwordGenerator();
}