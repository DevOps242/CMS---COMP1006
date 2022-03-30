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

function toggleActiveStatus() {
    let toggle = document.getElementById("flexSwitchCheckChecked");
    let userStatus  = document.getElementById("userStatus");
    let userStatusValue = document.getElementById("flexSwitchCheckChecked");
    let checkBoxValue = document.getElementById("checkBoxStatus");

    if (!toggle.checked) {
        userStatus.innerHTML = "Inactive"
        userStatus.className= "form-check-label text-danger"
        checkBoxValue.value = "inactive";
        userStatusValue.checked = false;
    } else {
        userStatus.innerHTML = "Active"
        userStatus.className= "form-check-label text-success"
        checkBoxValue.value = "active";
        userStatusValue.checked = true;

    }
    console.log(checkBoxValue.value);
}

let loadFile = (event) => {
    var image = document.getElementById('image-output');
    image.style.display = "inline-block";
	image.src = URL.createObjectURL(event.target.files[0]);
}
