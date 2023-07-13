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

        
        <link rel="stylesheet" href="styles/header.css">
        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/login-signup.css">

        <title>Signup</title>

        <style>
        </style>
    </head>
    <body>
        <div class="overlay">
            <div class="page-content">
                <div class="header" style="box-shadow: none;">
                    <a href="http://localhost/k-tech/">
                        <img class="logo" src="resources/k-tech-horizontal.png" alt="">
                    </a>
                    <div style="flex-grow: 2.4; flex-basis: 0;"></div>
                    <a class="header_links" href="login.php">Login</a>
                    <a class="header_links" href="">About Us</a>
                </div>
                <div class="content">
                    <div class="login-box">
                        <p class="title">Signup</p>
                        <form action="includes/signup.inc.php" method = "POST">
                            <p class="form-label">Username</p>
                            <input type="text" placeholder="sample" name='username'>
                            <p class="form-label">Password</p>
                            <input type="password" placeholder="password" name='password'>
                            <button type='submit' name="usersignup">Signup</button>
                            <p>Have an account?<a href="login.php">Login</a></p>

        <?php
            if (isset($_GET["error"])){
                if($_GET["error"] == "stmtFailed") {
                    echo '<p class = "error">Something went wrong try again!</p>';
                } 
                else if($_GET["error"] == "emptyInput") {
                    echo '<p class = "error">Fill in all fields!</p>';
                }
                else if($_GET["error"] == "usernameTaken") {
                    echo '<p class = "error">Your username is taken</p>';
                }
                else if($_GET["error"] == "passwordLength") {
                    echo '<p class = "error">Password should be at least 8 letters long</p>';
                }
                else if($_GET['error'] == 'passwordSameAsUsername') {
                    echo '<p class = "error">Password should not be the same as the username</p>';
                }
            }
        ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>