<?php 
$pageTitle = 'Register';
require 'includes/header.php';


?>

<div class="container text-center mb-3 mt-3" > 
    <h3>Register for your Admin Portal</h3>
    
    <div class="cardContainer" > 
        <div class="card">
            <div class="container">
                <form method="POST">
                    <div class="row g-3 mt-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="John" name="firstName" aria-label="First name" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Doe" name="lastName" aria-label="Last name" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        
                        <input type="text" class="form-control" placeholder="example@example.com" name="email" aria-label="Last name" required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <input type="password" id="password" class="form-control" placeholder="Password" name="password" aria-describedby="passwordHelpInline" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        </div>
                        <div class="col">
                            <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm Password" name="confirmPassword" aria-describedby="passwordHelpInline" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        </div>

                    </div>
                    <div class="row g-3 align-items-center mb-2">
                        <div class="col-auto">
                            <span id="passwordHelpInline" class="form-text text-danger">Passwords must be a min of 8 characters, including 1 digit, 1 upper-case and 1 lower-case letter.</span>  
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-eye-slash" id="passwordIcon" onclick="showHidePassword()"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-3" id="registerBtn" >Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require 'includes/footer.php';

?>