<?php 
$pageTitle = 'Edit User';
require_once 'includes/header.php';
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';


try {
    $userGUID = $_GET['id'];
    
    // Connect to the database
    $db = new Database();

    // Retrieve the users from the database.
    $query = "SELECT * FROM CMSUsers WHERE userGUID = :userGUID";
    $cmd = $db->connect->prepare($query);
    $cmd->bindParam(':userGUID', $userGUID, PDO::PARAM_STR, 255);
    $cmd->execute();
    $result = $cmd->fetch();
   
    // Store the users variables from the database
    $firstName  = $result['userFirstName'];
    $lastName   = $result['userLastName'];
    $email      = $result['userEmail'];
    $status     = $result['userStatus'];

    $db = null;

} catch (Exception $error) {
    Log::error('Admin Users Display Error:' . json_encode($error));
}
?>

<div class="container text-center mb-3 mt-3" > 
    <h3 id="pageHeader">Edit Admin Users for your Portal</h3>
    
    <div class="cardContainer" > 
        <div class="card">
            <div class="container">
                <?php 
                    if(isset($_GET['successMessage'])) {
                       echo '<p class="text-success mt-3"> <b>'. $_GET['successMessage'] .'</b></p>';
                    } elseif (isset($_GET['errorMessage'])) {
                        echo '<p class="text-danger mt-3"> <b>'. $_GET['errorMessage'] .'</b></p>';
                    }
                ?>
                
                <form method="POST" action="<?php dirname(__FILE__)?>../../controller/users/processUsers.php?edit&id=<?php echo $userGUID; ?>">
                    <div class="row g-3 mt-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="John" name="firstName" aria-label="First name" required value="<?php echo $firstName; ?>">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Doe" name="lastName" aria-label="Last name" required value="<?php echo $lastName; ?>">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        
                        <input type="email" class="form-control" placeholder="example@example.com" name="email" aria-label="email" required value="<?php echo $email; ?>">
                        <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
                    </div>
                    
                    <label class="form-check-label" for="flexSwitchCheckChecked">User Status:</label>
                    <div class="form-check form-switch d-flex justify-content-center mt-3 mb-3" >
                        <?php if($status === 'active') {
                            echo ' 
                            <input type="hidden" id="checkBoxStatus" name="status" value="active">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="active" checked onClick="toggleActiveStatus()">
                            <label class="form-check-label text-success" for="flexSwitchCheckChecked" id="userStatus">Active</label> ';
                        } elseif($status === 'inactive') {
                            echo ' 
                            <input type="hidden" id="checkBoxStatus" name="status" value="inactive">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="inactive" onClick="toggleActiveStatus()">
                            <label class="form-check-label text-danger" for="flexSwitchCheckChecked" id="userStatus">Inactive</label> ';
                        } ?>
                    </div>    
                
                    <button type="submit" class="btn btn-primary mb-3">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
require 'includes/footer.php';

?>