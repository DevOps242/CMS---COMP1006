<?php 
require_once __DIR__ . '/../../model/Database.php';

//Error message veriable to return to user. 
$serverMessage = null;

// receieve the Post variables from the users
$email = trim($_POST['email']);
$password = $_POST['password'];

if ( empty($email) || empty($password) ) {                                                               // Check if the email is blank or null
    $serverMessage = "Fields must not be empty";

} else {
    $db = new Database();
    echo 'test';
    // Check if email esist in db
    try {
        $query= "SELECT * FROM CMSUsers WHERE userEmail = :email";
        $cmd = $db->connect->prepare($query);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 150);
        $cmd->execute();
        $result = $cmd->fetch($data);                                           // Get result back from database

        var_dump($result);
        //Check result if it contains the same as email.
        if ( !isset($result['userEmail']) ) {
            $serverMessage = "Email address does not exsist";
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
        }

        if (!password_verify($password, $result['userPassword']) ){
            $serverMessage = "Invalid credentials or email address";
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
        }

        session_start();
        date_default_timezone_set('US/Eastern');
        $_SESSION['createdOn'] = date("l jS \of F Y h:i:s A");
        $_SESSION['userGUID'] = $result['userGUID'];
        
        header('Location: ../../view/admin/index.php');
        
    } catch(Exception $error) {
        Log::error('Login Error: ' . json_encode($error->getMessage()) );
    } finally {
        $db->kill();
    }

}                  

