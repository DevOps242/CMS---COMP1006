<?php 
session_start();
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';





// Get the information from the form.
$logoName = $_POST['logoName'];
$logoTitle = $_POST['logoTitle'];
$logoStatus = 'active';
$userGUID = $_SESSION['userGUID'];
$logoImg = null;

// Validate fields not empty
if (empty($logoName) && !empty($logoTitle) || empty($logoName) && !empty($_FILES['logoImg']['name'])  || empty($logoTitle) && !empty($_FILES['logoImg']['name'])) {
    $serverMessage = "Error, all fields must be filled. {Logo Name and Logo Title, Logo Image}";
    header('Location: ../../view/admin/logo.php?message=' . $serverMessage);
    exit;  
} 

// Check if the files was added
if ( !empty($_FILES['logoImg']['name']) ){
        $logoImg = $_FILES['logoImg']['name'];
        // Where the file is going to be stored
        $target_dir = __DIR__ . '/../../storage/app/logos/';;
        $file = $_FILES['logoImg']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['logoImg']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        
    // Check if file already exists
    if (file_exists($path_filename_ext)) {
        // Delete the file 
        unlink($path_filename_ext);
    } 

    // Upload the file.
    move_uploaded_file($temp_name,$path_filename_ext);
    
}

try {
    if ( empty($logoName) && empty($logoTitle) && empty($_FILES['logoImg']['name'])  ){
        // Add info to the database.
        $db = new Database();
    
        // Set all Logos to inactive once a new one is added
        $query = "UPDATE CMSLogos 
                SET logoStatus = 'inactive'";

        $cmd = $db->connect->prepare($query);
        $cmd->execute();
        $db = null;

        $serverMessage = "Logo has been changed successfully";
        header('Location: ../../view/admin/logo.php?message=' . $serverMessage);
        exit;

    } else {
        // Add info to the database.
        $db = new Database();
    
        // Set all Logos to inactive once a new one is added
        $query = "UPDATE CMSLogos 
                SET logoStatus = 'inactive'
                WHERE logoStatus = 'active'";

        $cmd = $db->connect->prepare($query);
        $cmd->execute();
        $db = null;

        // Establish new connection to database
        $db = new Database();

        // query to add logo to database
        $query = "INSERT INTO CMSLogos (logoName, logoTitle, logoStatus, logoImg) VALUES (:logoName, :logoTitle, :logoStatus, :logoImg)";

        $cmd = $db->connect->prepare($query);
        
        // Bind the param values
        $cmd->bindParam(':logoName', $logoName, PDO::PARAM_STR, 255);
        $cmd->bindParam(':logoTitle', $logoTitle, PDO::PARAM_STR, 255);
        $cmd->bindParam(':logoStatus', $logoStatus, PDO::PARAM_STR, 15);
        $cmd->bindParam(':logoImg', $logoImg, PDO::PARAM_STR, 255);
        $cmd->execute();

        $serverMessage = "Logo has been changed successfully";
        header('Location: ../../view/admin/logo.php?message=' . $serverMessage);
        exit;
    }
    

} catch (Exception $error) {
    // Catch the error and redirect to the logo page with error and capture in logs.
    $serverMessage = "There was and error changinge your logo.";
    Log::error('Logo Change Error: ' . json_encode( $serverMessage . PHP_EOL . $error->getMessage()));
    // Send user to general eror page.
    header('Location: ../../view/error.php');
    exit;
}
