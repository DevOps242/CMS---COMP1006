<?php
require_once __DIR__ . '/../../model/Database.php';

// Get the data from the form
$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];

$errorCode = 0;
$serverMessage = null;
$flag = false;


// Validate the information sent from the user
if (empty($firstName) || empty($lastName)) {
    $errorCode = 1;
    $serverMessage = "Error, all fields must be filled";
    $flag = true;

} elseif (preg_match('~[0-9]+~', $firstName) || preg_match('~[0-9]+~', $lastName)) {
    $errorCode = 1;
    $serverMessage = "Error, Name fields should not contain numbers";
    $flag = true;
}

//  Check to validate email
if (empty($email)) {
    $serverMessage = "Error, all fields must be filled";
    $flag = true;

} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorCode = 2;
    $serverMessage = "Error, Valid email must be provided.";
    $flag = true;

} else {
    // Check if the email is already taken by another user.
    try {
        $db = (new Database())->connect;
        $sql = "SELECT * FROM CMSUsers WHERE userEmail = :email";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':email', $email);
        $cmd->execute();
        $results = $cmd->fetch();

        if (!empty($results)) {
            $errorCode = 2;
            $serverMessage = "Error, Email already taken, please choose another.";
            $flag = true;
        }

        $db = null;
    } catch (Exception $error) {
        Log::error('Registration Error: ' . json_encode($error->getMessage()));
    }
}

// Check to validate password
if (empty($password) || empty($confirmPassword)) {
    $errorCode = 3;
    $serverMessage = "Error, all fields must be filled";
    $flag = true;

} else if (!$password === $confirmPassword) {
    $errorCode = 3;
    $serverMessage = "Error, Password fields do not match";
    $flag = true;
}

if ($flag === false) {
    // Connect to database and add user.
    try {
        //hash the user's password 
        $password = password_hash($password, PASSWORD_DEFAULT);

        // create uuid 
        $guid = uniqid($email, true);
        // setting the users status
        $userStatus = 'active';

        // Connect to Database and add the users to database
        $db = new Database();
        $query = "INSERT INTO CMSUsers (userFirstName, userLastName, userEmail, userPassword, userGUID, userStatus) VALUES (:userFirstName, :userLastName, :userEmail, :userPassword, :userGUID, :userStatus)";
        $cmd = $db->connect->prepare($query);
        $cmd->bindParam(':userFirstName', $firstName, PDO::PARAM_STR, 100);
        $cmd->bindParam(':userLastName', $lastName, PDO::PARAM_STR, 100);
        $cmd->bindParam(':userEmail', $email, PDO::PARAM_STR, 150);
        $cmd->bindParam(':userPassword', $password, PDO::PARAM_STR, 255);
        $cmd->bindParam(':userGUID', $guid, PDO::PARAM_STR, 255);
        $cmd->bindParam(':userStatus', $userStatus, PDO::PARAM_STR, 20);
        $cmd->execute();
        
        $serverMessage = "Users created successfully";

        $db = null;
        // Redirect back to the page.
        header('Location: ../../view/admin/register.php?message=' . $serverMessage);
        exit;
    } catch (Exception $error) {
        Log::error('Registration Error: ' . json_encode($error->getMessage()));
    }
} else {
    //  Redirect back to the register page with the error.
    header('Location: ../../view/admin/register.php?message=' . $serverMessage);
    exit;
}
