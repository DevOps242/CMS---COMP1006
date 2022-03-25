// Generic Delete confirmation modal
function confirmDelete() {
    return confirm('Are you sure you want to delete this item?');
}

function comparePassword() {
    // get the passwords values from form
    let password1 = document.getElementById('password').value;
    let password2 = document.getElementById('confirm').value;
    let message = document.getElementById('message');

    if (password1 != password) {
        message.innerText = "Passwords must match";
        message.className = "alert alert-info";
        return false;
    }
    else {
        message.innerText = "Passwords must be a minimum of 8 characters, including 1 digit, 1 upper-case letter, and 1 lower-case letter.";
        message.className = "alert alert-secondary";
        return true;
    }
}

function showHidePassword() {
    // reference password input and showHide icon
    let password = document.getElementById('password');
    let confirmPassword = document.getElementById('confirmPassword');
    let passwordIcon = document.getElementById('passwordIcon');

    if (password.type == 'password') {
        password.type = 'text';
        confirmPassword.type = 'text';
        passwordIcon.className = 'fa-solid fa-eye-slash';
    } 
    else {
        password.type = 'password';
        confirmPassword.type = 'password';
        passwordIcon.className = 'fa-solid fa-eye';
    }
}