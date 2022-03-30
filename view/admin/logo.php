<?php 
$pageTitle = 'Change Logo';
require_once 'includes/header.php';
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';
?>

<div class="container text-center mb-3 mt-3" > 
    <h3 id="pageHeader">Change your Public Pages Logo</h3>
    
    <div class="cardContainer" > 
        <div class="card">
            <div class="container">
                <?php 
                    if(isset($_GET['message'])) {
                       if($_GET['message'] !== 'Logo has been changed successfully') {
                            echo '<p class="text-danger mt-3"> <b>'. $_GET['message'] .'</b></p>';
                        } else {
                            echo '<p class="text-success mt-3"> <b>'. $_GET['message'] .'</b></p>';
                        }
                    } 
                ?>         
                <form method="POST" action="<?php dirname(__FILE__)?>../../controller/logos/createHandler.php" enctype="multipart/form-data">
                    <div class="row g-3 mt-3 mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Logo Name" name="logoName" aria-label="Logo Name" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Logo Title" name="logoTitle" aria-label="Logo Title" required>
                        </div>
                    </div>

                    <div class="mb-3 mt-3">            
                       <p><img  style="display: none;" id="image-output" width="200" height="170" /></p>         
                    </div>

                    <div class="row g-3">
                        <div class="col">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Logo Image</label>
                                <input class="form-control" type="file" id="formFile" name="logoImg" accept="image/*" onchange="loadFile(event)">
                            </div>
                        </div>
                     </div>
                   
                    
                    <button type="submit" class="btn btn-primary mb-3" >Change Logo</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require 'includes/footer.php';

?>