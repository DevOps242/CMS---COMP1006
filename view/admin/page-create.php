<?php 
$pageTitle = 'Create Pages';
require_once 'includes/header.php';
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

// Check to make sure the user is logged in before accessing this page.
if (!isset($_SESSION['userGUID'])) {
    header("Location: login.php");
    exit;
} 

?>

<div class="container text-center mb-3 mt-3" > 
    <h3 id="pageHeader">Create your Public Pages</h3>
    
    <div class="cardContainer" > 
        <div class="card">
            <div class="container">
                <?php 
                    if(isset($_GET['message'])) {
                       if($_GET['message'] !== 'Page has been created successfully') {
                            echo '<p class="text-danger mt-3"> <b>'. $_GET['message'] .'</b></p>';
                        } else {
                            echo '<p class="text-success mt-3"> <b>'. $_GET['message'] .'</b></p>';
                        }
                    } 
                ?>
                
                <form method="POST" action="<?php dirname(__FILE__)?>../../controller/pages/createHandler.php" enctype="multipart/form-data">
                    <div class="row g-3 mt-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Page Name" name="pageName" aria-label="Page Name" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Page Title" name="pageTitle" aria-label="Page Title" required>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">            
                        <label for="exampleFormControlTextarea1" class="form-label">Page Contents:</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="pageContent" placeholder="This is my page"></textarea>                
                    </div>
                    <div class="mb-3 mt-3">            
                       <p> <img  style="display:none;" id="image-output" width="200" height="170" /> </p>         
                    </div>

                    <div class="row g-3">
                        <div class="col">
                            <div class="mb-3">
                            <label for="formFile" class="form-label">Page Image</label>
                            <input class="form-control" type="file" id="formFile" name="pageImg" accept="image/*" onChange="loadFile(event)">
                            </div>
                        </div>

                        <div class="col">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Page Status:</label>
                            <div class="form-check form-switch d-flex justify-content-center mt-3 mb-3" >
                                <input type="hidden" id="checkBoxStatus" name="pageStatus" value="active">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" value="active" checked onClick="toggleActiveStatus()">
                                <label class="form-check-label text-success" for="flexSwitchCheckChecked" id="userStatus">Active</label> 
                            </div>    
                        </div>
                     </div>
                   
                    
                    <button type="submit" class="btn btn-primary mb-3" id="registerBtn" >Create Page</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require_once 'includes/footer.php';

?>