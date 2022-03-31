<?php 
$pageTitle = 'Welcome';
require_once('../../utilities/shared.php');
require_once 'includes/header.php';

// Check to make sure the user is logged in before accessing this page.
if (!isset($_SESSION['userGUID'])) {
    header("Location: login.php");
    exit;
} 

?>

<div class= "container">
    <div class="container text-center">
        <h3 class="mt-3 mb-3">Welcome to the Admin Dashboard</h3>

        <div class="container">
            <div class="row">
                <div class="col">
                    <h5>Column 1</h5>
                </div>
                <div class="col">
                    <h5>Column 2</h5>
                </div>
            </div>
        </div>
    </div>
</div>

