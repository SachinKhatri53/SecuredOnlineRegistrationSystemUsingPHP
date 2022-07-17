var oldPassword = document.getElementById("oldPassword");
var newPassword = document.getElementById("newPassword");
var confirmPassword = document.getElementById("confirmPassword");

var showOldPassword = document.getElementById("showOldPassword");
var showNewPassword = document.getElementById("showNewPassword");
var showConfirmPassword = document.getElementById("showConfirmPassword");


var eyeOldPassword = document.getElementById("eyeOldPassword");
var eyeNewPassword = document.getElementById("eyeNewPassword");
var eyeConfirmPassword = document.getElementById("eyeConfirmPassword");

function showOldEye(){
    if(oldPassword.value != ""){
        showOldPassword.style.display = "block";
    }
    else{
        showOldPassword.style.display = "none";
    }
}
function showNewEye(){
    if(newPassword.value != ""){
        showNewPassword.style.display = "block";
    }
    else{
        showNewPassword.style.display = "none";
    }
}
function showConfirmEye(){
    if(confirmPassword.value != ""){
        showConfirmPassword.style.display = "block";
    }
    else{
        showConfirmPassword.style.display = "none";
    }
}
function toggleOldPassword(){    
    if (oldPassword.type === "password") {
        oldPassword.type = "text";
        eyeOldPassword.classList.remove("fa-eye-slash")
        eyeOldPassword.classList.add("fa-eye")
        } else {
        oldPassword.type = "password";
        eyeOldPassword.classList.remove("fa-eye")
        eyeOldPassword.classList.add("fa-eye-slash")
    }
}
function toggleNewPassword(){    
    if (newPassword.type === "password" || confirmPassword.type === "password") {
        newPassword.type = "text";
        confirmPassword.type = "text";
        eyeNewPassword.classList.remove("fa-eye-slash")
        eyeNewPassword.classList.add("fa-eye")
        eyeConfirmPassword.classList.remove("fa-eye-slash")
        eyeConfirmPassword.classList.add("fa-eye")
        } else {
        newPassword.type = "password";
        confirmPassword.type = "password";
        eyeNewPassword.classList.remove("fa-eye")
        eyeNewPassword.classList.add("fa-eye-slash")
        eyeConfirmPassword.classList.remove("fa-eye")
        eyeConfirmPassword.classList.add("fa-eye-slash")
    }
}
