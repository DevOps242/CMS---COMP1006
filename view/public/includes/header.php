<?php 
$pageTitle;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CMS | Public - <?php echo $pageTitle?></title>
      
        <!-- Font Awesome Icons CDN -->
        <script src="https://kit.fontawesome.com/d42d4cbe33.js" crossorigin="anonymous"></script>

        <!-- Bootsrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

          <!-- CSS Link -->
          <link rel="stylesheet" type="text/css" href="styles/style.css">

          <!-- Favicon Icon -->
          <link rel="icon" type="image/x-icon" href="../favicon.ico">
  
    </head>
    <body>

    <?php
        require_once '../../model/Database.php';
        require_once '../../utilities/Log.php';
        try {
        
             // Connect to the database
            $db = new Database();
    
            // Retrieve the users from the database.
            $query = "SELECT * FROM CMSPages 
                     WHERE pageStatus = 'active'";
            $cmd = $db->connect->prepare($query);
            $cmd->execute();

            // Grab the pages from the database
            $results = $cmd->fetchAll();
        
            // Query database for the logo.
            $query = "SELECT * FROM CMSLogos WHERE logoStatus = 'active'";
            $cmd = $db->connect->prepare($query);
            $cmd->execute();
            $logos = $cmd->fetch();

            $db = null;
            
        }  catch (Exception $error) {
            Log::error("Public Header: ". json_encode("Error loading header content " . $error->getMessage()));
            // Send user to general eror page.
            header('Location: ../error.php');
            exit;
        }
    ?>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <?php 
                if ($logos) {
                    echo '
                        <a class="navbar-brand" href="index.php">    
                            <img class="navbar-brand" src="../../storage/app/logos/'.$logos['logoImg'].'"  width="230" height"140" />
                        </a>
                        ';
                } else {
                    echo '
                        <a class="navbar-brand" href="#">Pixilar CMS | Public Pages</a>
                        ';
                }
            ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <?php 
                        //Loop over each record return from the Pages table
                        foreach($results as $page) {
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php?id='.$page['pageID'].'">'. $page['pageName'] .'</a>
                                </li>
                                ';
                        }
                    ?>  
                </ul>
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll d-flex" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/index.php">View Admin Portal</a>
                    </li>
                </ul>     
            </div>
        </div>
    </nav>