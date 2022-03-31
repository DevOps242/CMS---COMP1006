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
            Log::info('Login Admin Process:' . json_encode($$email . PHP_EOL . $serverMessage));
            $db = null;
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
            exit;
        }

        // Verify the password
        if (!password_verify($password, $result['userPassword']) ){
            $serverMessage = "Invalid credentials or email address";
            Log::info('Login Admin Process:' . json_encode($$email . PHP_EOL . $serverMessage));
            $db = null;
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
            exit;
        } 

        // Check to make sure the user account is active.
        if ($result['userStatus'] === 'inactive') {
            $serverMessage = "User status is disabled.";
            Log::info('Login Admin Process:' . json_encode($email . PHP_EOL . $serverMessage));
            $db = null;
            header('Location: ../../view/admin/login.php?message=' . $serverMessage);
            exit;
        }

        session_start();
        date_default_timezone_set('US/Eastern');
        $_SESSION['createdOn'] = date("l jS \of F Y h:i:s A");
        $_SESSION['userGUID'] = $result['userGUID'];
        $_SESSION['userID'] = $result['userID'];
        
        $db = null;
        header('Location: ../../view/admin/index.php');
        exit;
        
    } catch(Exception $error) {
        $serverMessage = "Server Error trying to execute your access";
        Log::error('Login Admin Process: ' . json_encode($error->getMessage()) . PHP_EOL . $serverMessage);
        $db = null;
        // Send user to general eror page.
        header('Location: ../../view/error.php');
        exit;
    }
}                  

