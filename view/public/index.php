<?php 
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

if (!isset($_GET['id'])) {
    $pageTitle = 'Welcome';
    require_once 'includes/header.php';
    ?>
    <div class="container text-center">
        <h4>Welcome to your Public Page</h4>
    </div>

<?php 
} else {
?> 

<?php 
    
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
    $image      = $result['pageImg'];

    $db = null;

    $pageTitle = $name;
    require_once 'includes/header.php';
}

?>