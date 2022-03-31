<?php 
$pageTitle = 'Welcome';
require_once('../../utilities/shared.php');
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';
require_once 'includes/header.php';

// Check to make sure the user is logged in before accessing this page.
if (!isset($_SESSION['userGUID'])) {
    header("Location: login.php");
    exit;
} 

try{
    // call database class
    $db = new Database();

    // Query to get the count of active and inactive users
    $query = "SELECT COUNT(*) FROM CMSUsers WHERE userStatus = 'active'";
    $cmd = $db->connect->prepare($query);
    $activeUsers = $cmd->execute();
    echo $activeUsers;
    $cmd = null;
    $db = null;

    // call database class
    $db = new Database();
    $query = "SELECT COUNT(*) FROM CMSUsers WHERE userStatus = 'inactive'";
    $cmd = $db->connect->prepare($query);
    $inactiveUsers = $cmd->execute();
    echo $inactiveUsers;
    $cmd = null;

    $query = "SELECT COUNT(*) FROM CMSPages WHERE pageStatus = 'active'";
    $cmd = $db->connect->prepare($query);
    $activePages = $cmd->execute();
    $cmd = null;

    $query = "SELECT COUNT(*) FROM CMSPages WHERE pageStatus = 'inactive'";
    $cmd = $db->connect->prepare($query);
    $inactivePages = $cmd->execute();

    $db = null;

} catch (Exception $error){
    //Catch error and redirect to error page.
    Log::error('Index Page Error:' . json_encode($error));
    // Send user to general eror page.
    header('Location: ../error.php');
    exit;
}
?>
<div class= "container mb-3 mt-3">
    
        <div class="jumbotron mb-3 mt-3 text-center">
            <h1 class="display-4">Welcome to the Admin Dashboard!</h1>
            <p class="lead">This is the start of your journey to creating awesome content.</p>
            <hr class="my-4">

            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" >
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner ">
                    <div class="carousel-item active">
                        <img src="../../storage/app/images/s6.jpeg" class="d-block w-100" alt="..." height="350px">
                    </div>
                    <div class="carousel-item">
                        <img src="../../storage/app/images/s7.jpeg" class="d-block w-100" alt="..." height="350px">
                    </div>
                    <div class="carousel-item">
                        <img src="../../storage/app/images/s8.png" class="d-block w-100" alt="..."  height="350px">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <br/>

            <p class="lead">
                <a class="btn btn-primary btn-lg" href="pages.php" role="button">Start here!</a>
            </p>
        </div>
        <div class="container text-center mb-3 mt-3">
            <div class="row">
                <div class="col mt-3 mb-3">
                    <h5>Users Created:</h5>
                    <div class="row">
                        <div class="col-6">
                            <h6>Active Users: <p><?php echo $activeUsers; ?></p> </h6>
                        </div>
                        <div class="col-6">
                            <h6>Inactive Users: <p><?php echo $inactiveUsers; ?></p></h6>
                        </div>
                    </div>
                </div>
                <div class="col  mt-3 mb-3">
                    <h5>Pages created: </h5>
                    <div class="row">
                        <div class="col-6">
                            <h6>Active Pages: <p><?php echo $activePages; ?></p> </h6>
                        </div>
                        <div class="col-6">
                            <h6>Inactive Pages: <p><?php echo $inactivePages; ?></p></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

