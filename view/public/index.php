<?php 
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

if (!isset($_GET['id'])) {
    $pageTitle = 'Welcome';
    require_once 'includes/header.php';
    ?>
    <!-- <div class="container text-center mb-3">
        <h2>Welcome to your Public Page</h2>
    </div> -->
    <div class="container mt-3 text-center ">
        <div class="row">
            <h3>Pixilar Services<h3>
        </div>
        </br>
        <div class="row">
            <div class="col-4">
                <h6>Designing for the future Pixilar CMS</h6>
                <img src="../../storage/app/images/s6.jpeg" class="img-thumbnail" alt="..." width="380" height="380">
            </div>
            <div class="col-4">
                <h6>Design, Build and Customize with Pixilar CMS</h6>
                <img src="../../storage/app/images/s7.jpeg" class="img-thumbnail" alt="..."  width="380" height="340">
            </div>
            <div class="col-4">
                <h6>Software Integration with Pixilar CMS</h6>
                <img src="../../storage/app/images/s8.png" class="img-thumbnail" alt="..."  width="380" height="340">
            </div>
        </div>
        <div>
            <h6><b><a href="../admin/register.php">Register</a></b> now and start creating with Pixilar!</h6>
        </div>
    </div>


<?php 
} else {
    $pageID = $_GET['id'];

    try{
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
        $image      = $result['pageImg'];

        $db = null;

        $pageTitle = $name;
        require_once 'includes/header.php';

    } catch (Exception $error) {
        Log::error("Public Page Error: " . $error->getMessage());
        // Send user to general eror page.
        header('Location: ../../view/error.php');
        exit;
    }
 
?>

<div class="container mt-3 mb-3">
    <!-- <h3 class="text-center mt-3 mb-3">Welcome to <? //php echo $name; ?></h3> -->
    <div class="container mt-3"> 
        <div class="row mt-3">
            <?php 
                if (file_exists('../../storage/app/images/'.$image)) {
                    // Check to see if the image exsist
                    echo ' 
                        <div class="container text-center mt-3 mb-3">
                            <h3>'. $title .'</h3>
                        </div>
                        <!-- Image Section -->
                        <div class="col-5">
                            <div class="container">
                                <div class="card">
                                    <img class="rounded mx-auto d-block" src="../../storage/app/images/'.$image.'" width="420" height="570"/>
                                </div>
                            </div>
                        </div>
                        <!-- Content Section -->
                        <div class="col-7">
                            <div class="container">
                                <p class="lead">'. nl2br($content) .'</p>
                            </div>
                        </div>
                        ';
                } else {
                    echo' 
                        <!-- Content Section -->
                        <div class="col-12 text-center mt-3 mb-3">
                            <div class="container">
                                <h3>'. $title .'</h3>
                            </div>
                                <div class="container"> 
                                    <p class="lead">'. $content .'</p>
                                </div>
                        </div>
                        ';
                }
            ?>
        </div>
    </div>
</div>

<?php 

// End else statement
}   

require_once 'includes/footer.php';
?>

