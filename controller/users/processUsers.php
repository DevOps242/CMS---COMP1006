<?php 


require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

if(isset($_GET['delete'])) {
    try{
      $userGUID = $_GET['id'];
      // Connect to the database
      $db = new Database();

      // Delete the users from the database.
      $query = "DELETE FROM CMSUsers WHERE userGUID = :userGUID";
      $cmd = $db->connect->prepare($query);
      $cmd->bindParam(':userGUID', $userGUID, PDO::PARAM_STR, 255);
      $cmd->execute();
      $serverMessage = "User has been deleted successfully";
      
      $db = null;
  
      // redirect to the user's page.
      header('Location: ../../view/admin/users.php?successMessage=' .$serverMessage);

    } catch (Exception $error) {
        $serverMessage = "There was an error processing your delete request";
        Log::error('Delete User Process Error:' . json_encode($error->getMessage()));
        header('Location: ../../view/admin/users.php?errorMessage=' .$serverMessage);
    }
      
} elseif(isset($_GET['edit'])){
    try{
      // Connect to the database
      $db = new Database();

      // Update the users in the database.
      $query = "DELETE FROM CMSUsers WHERE userGUID = :userGUID";
      $cmd = $db->connect->prepare($query);
      $cmd->bindParam(':userGUID', $userGUID, PDO::PARAM_STR, 255);
      // $cmd->execute();
      $serverMessage = "User has been deleted successfully";
      
      $db = null;
  
      // redirect to the user's page.
      header('Location: ../../view/admin/users.php?successMessage=' .$serverMessage);
      
    } catch (Exception $error) {
        $serverMessage = "There was an error processing your delete request";
        Log::error('Delete User Process Error:' . json_encode($error->getMessage()));
        header('Location: ../../view/admin/users.php?errorMessage=' .$serverMessage);
    }
}
     
  


               

    


require 'includes/footer.php';

?>