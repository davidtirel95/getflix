const form = document.getElementById('form');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
const password_verification = document.getElementById('password_verification');

form.addEventListener("submit", function(event){
    if(password.value != password2.value) {
        event.preventDefault();
        //password_verification.removeAttribute("hidden");
    } 
})