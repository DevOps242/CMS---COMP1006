<?php 
require_once __DIR__ . '/../../model/Database.php';

//Error message veriable to return to user. 
$serverMessage = null;

// receieve the Post variables from the users
$email = $_POST['email'];
$password = $_POST['password'];

if ( empty($email) || empty($password) ) {                                                               // Check if the email is blank or null
    $serverMessage = "Fields must not be empty";

} else {
    $db = new Database();

    // Check if email esist in db
    try {
        $query= "SELECT * FROM CMSUsers WHERE userEmail = :email";
        $cmd = $db->connect->prepare($query);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 150);
        $cmd->execute();
        $result = $cmd->fetch();                                           // Get result back from database

        //Check result if it contains the same as email.
        if ( empty($result['userEmail']) ) {
            $serverMessage = "Email address does not exsist";
            Log::info('Login Email does not exsist:' . json_encode($email));
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
            exit();
        }

        if (!password_verify($password, $result['userPassword']) ){
            $serverMessage = "Invalid credentials or email address";
            Log::info('Login Invalid Credentials:' . json_encode($email));
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
            exit();
        }

        session_start();
        date_default_timezone_set('US/Eastern');
        $_SESSION['createdOn'] = date("l jS \of F Y h:i:s A");
        $_SESSION['userGUID'] = $result['userGUID'];
        $_SESSION['userID'] = $result['userID'];
        
        header('Location: ../../view/admin/index.php');
        exit();
        
    } catch(Exception $error) {
        Log::error('Login Error: ' . json_encode($error->getMessage()) );
    } finally {
        $db = null;
    }

}                  

