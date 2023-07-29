<?php
session_start();

include "includes/functions.inc.php";

if (isUserLoggedIn()) {
    if ($_SESSION['admin'] == "true"){
        header("Location: admin.php");
        exit();
    } else if ($_SESSION['admin'] == "false") {
        header("Location: menu.php");
    }
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

        <link rel="stylesheet" href="styles/home.css">
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/general.css">

        <title>Home</title>
    </head>
    <body>
        <div class="overlay">
            <div class="page-content">
                <div class="header">
                    <img class="logo" src="resources/k-tech-horizontal.png" alt="">
                    <div style="flex-grow: 2.4; flex-basis: 0;"></div>
                    <a class="header_links" href="login.php">Login</a>
                    <a class="header_links" href="signup.php">Signup</a>
                </div>
                <div class="content">
                    <div class="introduction">
                        <p class="title">K Tech</p>
                        <p class="description">Pick your new mobile phone here</p> 
                    </div>
                    <div class="buttons">
                        <button><a class="header_links" href="login.php">Login</a></button>
                        <button><a class="header_links" href="signup.php">Signup</a></button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>