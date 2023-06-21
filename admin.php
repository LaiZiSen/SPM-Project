<?php
session_start();

include "includes/functions.inc.php";

if ($admin = !isUserLoggedIn()) {
    header("Location: home.php");
    exit();
} 
if ($_SESSION['admin'] == "false"){
    header("Location: menu.php");
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

        <title>Admin</title>
    </head>
    <body>
        <div class="overlay">
            <div class="page-content">
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
                        <a class="header-link" href="includes/logout.inc.php">Logout</a>
                    </div>
                </div>
                <div class="content">   
                    <button onclick="redirect('user_list.php')">User List</button>
                    <button onclick="redirect('phone_list.php')">Phone List</button> 
                    <script>
                        function redirect(page) {
                            window.location.href = page;    
                        }
                    </script>
                </div>
            </div>
        </div>
    </body>
</html>