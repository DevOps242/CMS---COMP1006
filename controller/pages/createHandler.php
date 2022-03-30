<?php 
session_start();
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

// Get the information from the form.
$pageName = $_POST['pageName'];
$pageTitle = $_POST['pageTitle'];
$pageContent = $_POST['pageContent'];
$pageStatus = $_POST['pageStatus'];
$userGUID = $_SESSION['userGUID'];
$pageImg = null;

// Validate fields not empty
if (empty($pageName) || empty($pageTitle) || empty($pageContent)) {
    $serverMessage = "Error, all fields must be filled. {Page Name, Page Title, and Page Content}";
    header('Location: ../../view/admin/create-pages.php?message=' . $serverMessage);
    exit;  
} 

if ( !empty($_FILES['pageImg']['name']) ){
        $pageImg = $_FILES['pageImg']['name'];
        // Where the file is going to be stored
        $target_dir = __DIR__ . '/../../storage/app/images/';;
        $file = $_FILES['pageImg']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['pageImg']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
        
    // Check if file already exists
    if (file_exists($path_filename_ext)) {
        $serverMessage = "Sorry, file already exists.";
        header('Location: ../../view/admin/create-pages.php?message=' . $serverMessage);
        exit;  
        
    } else{
        move_uploaded_file($temp_name,$path_filename_ext);
    }
}

try {
    // Add info to the database.
    $db = new Database();
    
    $query = "INSERT INTO CMSPages (pageName, pageTitle, pageContent, pageStatus, userGUID) VALUES (:pageName, :pageTitle, :pageContent, :pageStatus, :userGUID)";
    if (isset($pageImg)) {
        $query = "INSERT INTO CMSPages (pageName, pageTitle, pageContent, pageImg, pageStatus, userGUID) VALUES (:pageName, :pageTitle, :pageContent, :pageImg, :pageStatus, :userGUID)";
    }
    $cmd = $db->connect->prepare($query);
    $cmd->bindParam(':pageName', $pageName, PDO::PARAM_STR, 255);
    $cmd->bindParam(':pageTitle', $pageTitle, PDO::PARAM_STR, 255);
    $cmd->bindParam(':pageContent', $pageContent, PDO::PARAM_STR);
    if (isset($pageImg)) {
        $cmd->bindParam(':pageImg', $pageImg, PDO::PARAM_STR, 255);
    }
    $cmd->bindParam(':pageStatus', $pageStatus, PDO::PARAM_STR, 255);
    $cmd->bindParam(':userGUID', $userGUID, PDO::PARAM_STR, 255);
    $cmd->execute();

    $serverMessage = "Page has been created successfully";
    header('Location: ../../view/admin/create-pages.php?message=' . $serverMessage);
    exit;    

} catch (Exception $error) {
    $serverMessage = "There was and error creating your page.";
    Log::error('Page Creation Error: ' . json_encode( $serverMessage . PHP_EOL . $error->getMessage()));
    header('Location: ../../view/admin/create-pages.php?message=' . $serverMessage);
    exit;    
}
