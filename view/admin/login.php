<?php 
$pageTitle = 'Login';
require 'includes/header.php';



session_start();
session_destroy();

if ( isset($_SESSION['createdOn']) ) {
    header('Location: /index.php');
} 
?> 

<div class="container text-center mb-3 mt-3" > 
    <h3>Login to your Admin Portal</h3>
    
    <div class="cardContainer"> 
        <div class="card">
            <div class="container">
            <form>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">Password</label>
                    </div>
                    <div class="col-auto">
                        <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                    </div>
                    <div class="col-auto">
                        <span id="passwordHelpInline" class="form-text">
                        Must be 8-20 characters long.
                        </span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php require 'includes/footer.php';?>

<!-- http://localhost:8888/Assignments/CMS-Assignment2/view/admin/login.php -->