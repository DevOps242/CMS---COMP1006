<?php 
$pageTitle = 'Welcome';
require 'includes/header.php';

if ( !isset($_SESSION['createdOn']) ) {
    header('Location: /login.php');
}

var_dump($_SESSION);

