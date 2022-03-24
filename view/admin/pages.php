<?php 
$pageTitle = 'Page | ' . ' ' ;
require 'includes/header.php';



session_start();
session_destroy();

if ( isset($_SESSION['createdOn']) ) {
    header('Location: /index.php');
} 
?> 





<?php require 'includes/footer.php';?>