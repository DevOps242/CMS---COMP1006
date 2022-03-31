<?php 
$pageTitle = 'Edit Pages';
require_once 'includes/header.php';
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

// Check to make sure the user is logged in before accessing this page.
if (!isset($_SESSION['userGUID'])) {
    header("Location: login.php");
    exit;
} 

// Take user back to view page if no id is set
if(!isset($_GET['id'])) {
    $serverMessage = "Please select an item to edit.";
    header("Location: pages.php?errorMessage=".$serverMessage);
    exit;
}

try {
    $pageID = $_GET['id'];
    
    // Connect to the database
    $db = new Database();

    // Retrieve the users from the database.
    $query = "SELECT * FROM CMSPages WHERE pageID = :pageID";
    $cmd = $db->connect->prepare($query);
    $cmd->bindParam(':pageID', $pageID, PDO::PARAM_INT);
    $cmd->execute();
    $result = $cmd->fetch();
   
    // Store the users variables from the database
    $id         = $result['pageID'];
    $name       = $result['pageName'];
    $title      = $result['pageTitle'];
    $content    = $result['pageContent'];
    $status     = $result['pageStatus'];
    $image      = $result['pageImg'];

    $db = null;

} catch (Exception $error) {
    Log::error('Page Edit Error:' . json_encode($error));
    // Send user to general eror page.
    header('Location: ../error.php');
    exit;
}
?>

<div class="container text-center mb-3 mt-3" > 
    <h3 id="pageHeader">Edit your Public Page</h3>
    
    <div class="cardContainer" > 
        <div class="card">
            <div class="container">
                <?php 
                    if(isset($_GET['message'])) {
                       if($_GET['message'] !== 'Page has been edited successfully') {
                            echo '<p class="text-danger mt-3"> <b>'. $_GET['message'] .'</b></p>';
                        } else {
                            echo '<p class="text-success mt-3"> <b>'. $_GET['message'] .'</b></p>';
                        }
                    } 
                ?>
                
                <form method="POST" action="<?php dirname(__FILE__)?>../../controller/pages/editHandler.php?id=<?php echo $pageID;?>" enctype="multipart/form-data">
                    <div class="row g-3 mt-3 mb-3">
                        <div class="col">
                            <input type="hidden"  name="pageID" value="<?php echo $id;?>" >
                            <input type="text" class="form-control" placeholder="Page Name" name="pageName" aria-label="Page Name" required value="<?php echo $name;?>" >
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Page Title" name="pageTitle" aria-label="Page Title" required value="<?php echo $title;?>">
                        </div>
                    </div>
                    <div class="mb-3 mt-3">            
                        <label for="exampleFormControlTextarea1" class="form-label">Page Contents:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="pageContent" placeholder="This is my page"><?php echo nl2br($content);?></textarea>                
                    </div>
                    <div class="mb-3 mt-3">            
                       <p><img   id="image-output" width="200" height="170" src="<?php  echo '../../storage/app/images/'.$image ;?>"/></p>         
                    </div>

                    <div class="row g-3">
                        <div class="col">
                            <div class="mb-3">
                            <label for="formFile" class="form-label" >Page Image</label>
                            <input class="form-control" type="file" id="formFile" name="pageImg" accept="image/*" onchange="loadFile(event)" value="<?php echo $image;?>">
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Page Status:</label>
                            <div class="form-check form-switch d-flex justify-content-center mt-3 mb-3" >
                                <input type="hidden" id="checkBoxStatus" name="pageStatus" value="<?php echo $status;?>">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="<?php echo $status;?>" <?php $status === 'active' ? 'checked' : ''?>  onClick="toggleActiveStatus()">
                                <?php 
                                    if ($status === 'active') {
                                       echo '<label class="form-check-label text-success" for="flexSwitchCheckChecked" id="userStatus">Active</label>';
                                    } elseif($status === 'inactive') {
                                        echo '<label class="form-check-label text-danger" for="flexSwitchCheckChecked" id="userStatus">Inactive</label>';
                                    }
                                ?>  
                            </div>    
                        </div>
                     </div>
                    <button type="submit" class="btn btn-primary mb-3" id="registerBtn" >Edit Page</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require 'includes/footer.php';

?>