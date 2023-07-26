<?php
session_start();

include "includes/functions.inc.php";

if (!isUserLoggedIn()) {
    header("Location: home.php");
    exit();
}
if ($_SESSION['admin'] == "true"){
    header("Location: admin.php");
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

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/suggestion.css">
        <link rel="stylesheet" href="styles/header3.css">

        <link rel="stylesheet" href="">

        <link rel="stylesheet" href="
            <?php 
                if (!isset($_GET['phone_id'])) {
                    echo 'styles/listSuggestion.css';
                } else {
                    echo 'styles\listDetail.css';
                }
            ?>
        ">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <title>Suggestion</title>
    </head>
    <body>
        <div class="header">
            <div class='left-section'>
            <p><?php echo $_SESSION['username']; ?></p>
            </div>
            <div class='middle-section'>    
                <a href="http://localhost/k-tech/">
                    <img class="logo" src="resources/k-tech-horizontal.png" alt="">
                </a>
            </div>
            <div class='right-section'>
                <a onclick="goBack()">Back</a>
                <script>
                    function goBack() {
                        <?php 
                            if (!isset($_GET['phone_id'])) {
                                echo 'window.location.href = "home.php";';
                            } else {
                                echo 'window.location.href = "suggestion.php";';
                            }
                        ?>
                    }
                </script>
            </div>
        </div>
        <div class="content">
            <?php 
                if (! isset($_GET['phone_id'])) {
                    include "includes/listSuggestion.inc.php"; 
                } else {
                    include "includes/listDetail.inc.php";
                }
                
            ?>
        </div>
    </body>
</html>