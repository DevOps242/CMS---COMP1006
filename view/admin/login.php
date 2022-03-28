<?php 
$pageTitle = 'Login';
require 'includes/header.php';

?>

<div class="container text-center mb-3 mt-3" > 
    <h3 id="pageHeader">Login to your Admin Portal</h3>
    
    <div class="cardContainer" > 
        <div class="card">
            <div class="container">
                <?php 
                    if(isset($_GET['message'])) {
                        echo '<p class="text-danger mt-3"> <b>'. $_GET['message'] .'</b></p>';
                    } 
                ?>
                <form method="POST" action="../../controller/loginHandler.php">
                    <div class="mb-3 mt-3">
                        <input type="text" class="form-control" placeholder="example@example.com" name="email" aria-label="Last name" required>
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <input type="password" id="password" class="form-control" placeholder="Password" name="password" aria-describedby="passwordHelpInline" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center mb-2">
                        <div class="col-auto">
                            <span id="passwordHelpInline" class="form-text text-info">Show Password:</span>  
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-eye" id="passwordIcon" onclick="showHidePassword()"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mb-3">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require 'includes/footer.php';

?>