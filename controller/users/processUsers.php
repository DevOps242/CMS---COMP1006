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
      exit;

    } catch (Exception $error) {
        $serverMessage = "There was an error processing your delete request";
        Log::error('Delete User Process Error:' . json_encode($serverMessage . PHP_EOL . $error->getMessage()));
        // Send user to general eror page.
        header('Location: ../../view/error.php');
        exit;
    }
      
} elseif(isset($_GET['edit'])){
  // Check to make sure the fields are not empty.
  
    $userGUID = $_GET['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $status = $_POST['status'];


    // Validate the names fields
    if( empty($firstName) || empty($lastName) ) {
        $serverMessage = "Name Fields must not be empty.";
        header('Location: ../../view/admin/user-edit.php?id='.$userGUID.'&errorMessage=' .$serverMessage);
        exit;
    } else if(preg_match('~[0-9]+~', $firstName) || preg_match('~[0-9]+~', $lastName)) {
      $serverMessage = "Name Fields must not contain numbers.";
      header('Location: ../../view/admin/user-edit.php?id='.$userGUID.'&errorMessage=' .$serverMessage);
      exit;
    }

    // Validate the email field.
    if(empty($email)) {
      $serverMessage = "Email field must not be empty.";
      header('Location: ../../view/admin/user-edit.php?id='.$userGUID.'&errorMessage=' .$serverMessage);
      exit;
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $serverMessage = "Email must be a valid email.";
      header('Location: ../../view/admin/user-edit.php?id='.$userGUID.'&errorMessage=' .$serverMessage);
      exit;
    }

    try{
      // Connect to the database
      $db = new Database();

      // Check to make sure there is no user with the same email address.
      $query = "SELECT * FROM CMSUsers WHERE userEmail = :email";
      $cmd = $cmd = $db->connect->prepare($query);
      $cmd->bindParam(':email', $email, PDO::PARAM_STR, 150);
      $cmd->execute();
      $results = $cmd->fetch();

      if ($results['userEmail'] != $email) {
        $db = null;
        $serverMessage = "Email already taken";
        header('Location: ../../view/admin/user-edit.php?id='.$userGUID.'&errorMessage=' .$serverMessage);
        exit;
      } else {
        // Update the users in the database.
        $query = "UPDATE CMSUsers 
        SET userFirstName = :firstName, userLastName = :lastName, userEmail = :email, userStatus = :status
        WHERE userGUID = :userGUID";
        $cmd = $db->connect->prepare($query);
        $cmd->bindParam(':firstName', $firstName, PDO::PARAM_STR, 100);
        $cmd->bindParam(':lastName', $lastName, PDO::PARAM_STR, 100);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 150);
        $cmd->bindParam(':status', $status, PDO::PARAM_STR, 20);
        $cmd->bindParam(':userGUID', $userGUID, PDO::PARAM_STR, 255);
        $cmd->execute();
        $serverMessage = "User editted successfully";
      }
      
      $db = null;
  
      // redirect to the user's page.
      header('Location: ../../view/admin/user-edit.php?id='.$userGUID.'&successMessage=' .$serverMessage);
      exit;
      
    } catch (Exception $error) {
        $serverMessage = "There was an error processing your edit request";
        Log::error('Edit User Process Error:' . json_encode($servrMessage . PHP_EOL . $error->getMessage()));
        // Send user to general eror page.
        header('Location: ../../view/error.php');
        exit;
    } 
}
     
  


               

    


require 'includes/footer.php';

?>