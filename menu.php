<?php
session_start();

include "includes/functions.inc.php";

if (!isUserLoggedIn()) {
    header("Location: home.php");
    exit();
} 
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">

        <link rel="stylesheet" href="styles/menu.css">
        <link rel="stylesheet" href="styles/header2.css">
        <link rel="stylesheet" href="styles/general.css">

        <title>Menu</title>
    </head>
    <body>
        <div class="overlay">
            <div class="page-content">
                <div class="header">
                    <div class='left-section'>
                    <p><?php echo $_SESSION['username']; ?></p>
                    </div>
                    <div class='middle-section'>    
                        <img class="logo" src="resources/k-tech-horizontal.png" alt="">
                    </div>
                    <div class='right-section'>
                        <a class="header-link" href="includes/logout.inc.php">Logout</a>
                    </div>
                </div>
                <div class="content">
                </div>
            </div>
        </div>
    </body>
</html>