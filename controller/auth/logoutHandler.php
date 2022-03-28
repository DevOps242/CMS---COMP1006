<?php 
// start sesssion so that it is available.
session_start();

// destroy any exsisting session variables
session_destroy();

// redirect the users to the login page. 
header('Location: ../../view/admin/login.php');
