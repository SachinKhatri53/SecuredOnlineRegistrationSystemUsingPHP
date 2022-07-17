var password = document.getElementById("password");
var eyePassword = document.getElementById("eye_password");
var showPassword = document.getElementById("show_pass");
function showEye(){
    if(password.value != ""){
        showPassword.style.display = "block";
    }
    else{
        showPassword.style.display = "none";
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