<?php 
$pageTitle = 'View Pages' ;
require 'includes/header.php';
require_once __DIR__ . '/../../model/Database.php';
require_once __DIR__ . '/../../utilities/Log.php';

// Check to make sure the user is logged in before accessing this page.
if (!isset($_SESSION['userGUID'])) {
    header("Location: login.php");
    exit;
} 

?> 
<div class="container text-center mb-3 mt-3" > 
    <h3 id="pageHeader">Manage your Public Pages</h3>
    <div class="container">
        <?php 
            if (isset($_GET['successMessage'])){
                echo '<p class="server-message text-success mt-3"> <b>'. $_GET['successMessage'] .'</b></p>';

            } elseif (isset($_GET['errorMessage'])) {
                echo '<p class="server-message text-danger mt-3"> <b>'. $_GET['errorMessage'] .'</b></p>';
            }
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Page Name:</th>
                    <th>Page Title:</th>
                    <th>Page Content:</th>
                    <th>Status:</th>
                    <th>Modified By:</th>
                    <th>Modified Date:</th>
                    <th>Edit:</th>
                    <th>Delete:</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    try {
                        // Connect to the database
                        $db = new Database();

                        // Retrieve the users from the database.
                        $query = "SELECT P.pageName, P.pageTitle, P.pageContent, P.pageStatus, P.pageModifiedOn, P.pageID, U.userFirstName, U.userLastName
                                  FROM CMSPages AS P
                                  JOIN CMSUsers AS U 
                                  WHERE P.userGUID = U.userGUID";
                        $cmd = $db->connect->prepare($query);
                        $cmd->execute();
                        $results = $cmd->fetchAll();
                        
                        if(count($results) === 0 ) {
                            echo '<p class="text-danger">There are currently any pages to display, create pages here: <a href="page-create.php">Create Pages</a>';
                        } else {
                            foreach($results as $page) {
                                echo '<tr>
                                        <td>'. $page['pageName']. '</td>
                                        <td>'. $page['pageTitle']. '</td>
                                        <td>'. substr($page['pageContent'],0 ,50). '</td>
                                        <td>'. $page['pageStatus']. '</td>
                                        <td>'. $page['userFirstName']. ' ' .$page['userLastName'] . '</td>
                                        <td>'. $page['pageModifiedOn']. '</td>
                                        <td>
                                            <a class="icon-button" href="page-edit.php?id='.$page['pageID'].'">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="icon-button" href="../../controller/pages/deleteHandler.php?id='.$page['pageID'].'" onClick="return confirmDelete()">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
                                        </td>
                                    </tr>';
                            }
                        }   
                    } catch (Exception $error) {
                        Log::error('Admin Users Display Error:' . json_encode($error));
                    }
 
                    $db = null;

                ?>
                <tr></tr>
            </tbody>
        </table>
    </div>

<?php 
require 'includes/footer.php';

?>