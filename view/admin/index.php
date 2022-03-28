<?php 
$pageTitle = 'Welcome';
require_once('../../utilities/shared.php');
require_once 'includes/header.php';


if ( !isset($_SESSION['createdOn']) ) {
    header('Location: login.php');
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

