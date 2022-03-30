<?php 
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

try{
    $pageID = $_GET['id'];
    // Connect to the database
    $db = new Database();

    // Delete the users from the database.
    $query = "DELETE FROM CMSPages WHERE pageID = :pageID";
    $cmd = $db->connect->prepare($query);
    $cmd->bindParam(':pageID', $pageID, PDO::PARAM_INT);
    $cmd->execute();
    $serverMessage = "Page has been deleted successfully";
    
    $db = null;

    // redirect to the user's page.
    header('Location: ../../view/admin/pages.php?successMessage=' .$serverMessage);
    exit;

} catch (Exception $error) {
    $serverMessage = "There was an error processing your delete request";
    Log::error('Delete Page Process Error:' . json_encode($error->getMessage()));
    header('Location: ../../view/admin/pages.php?errorMessage=' .$serverMessage);
    exit;
}
