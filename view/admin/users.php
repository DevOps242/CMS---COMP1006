<?php 
$pageTitle = 'Users';
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
    <h3 id="pageHeader">Manager your Admin Users</h3>
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
                    <th>First Name:</th>
                    <th>Last Name:</th>
                    <th>Email:</th>
                    <th>Status:</th>
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
                        $query = "SELECT * FROM CMSUsers WHERE userGUID != :userGUID";
                        $cmd = $db->connect->prepare($query);
                        $cmd->bindParam(':userGUID', $_SESSION['userGUID'], PDO::PARAM_STR, 255);
                        $cmd->execute();
                        $results = $cmd->fetchAll();

                        foreach($results as $user) {
                            echo '<tr>
                                    <td>'. $user['userFirstName']. '</td>
                                    <td>'. $user['userLastName']. '</td>
                                    <td>'. $user['userEmail']. '</td>
                                    <td>'. $user['userStatus']. '</td>
                                    <td>
                                        <a class="icon-button" href="user-edit.php?id='.$user['userGUID'].'">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="icon-button" href="../../controller/users/processUsers.php?delete&id='.$user['userGUID'].'" onClick="return confirmDelete()">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>';
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
require_once 'includes/footer.php';

?>