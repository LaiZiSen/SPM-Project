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

        <title>Login</title>
    </head>
    <body>
        <div class="overlay">
            <div class="page-content">
                <div class="header" style="box-shadow: none;">
                    <a href="home.php">
                        <img class="logo" src="resources/k-tech-horizontal.png" alt="">
                    </a>
                    <div style="flex-grow: 2.4; flex-basis: 0;"></div>
                    <a class="header_links" href="signup.php">Signup</a>
                    <a class="header_links" href="">About Us</a>
                </div>
                <div class="content">
                    <div class="login-box">
                        <p class="title">Login</p>
                        <form action="includes/login.inc.php" method ="POST">
                            <p class="form-label">Username</p>
                            <input type="text" name="username" placeholder="sample">
                            <p class="form-label">Password</p>
                            <input type="password" name="password"
                            placeholder="password">
                            <button type="submit" name="userlogin">Login</button>
                            <p>Don't have account? <a href="signup.php">Signup</a></p>
        <?php
            if (isset($_GET["error"])){
                if($_GET["error"] == "stmtFailed") {
                    echo '<p class = "error">Something went wrong try again!</p>';
                } 
                else if($_GET["error"] == "emptyInput") {
                    echo '<p class = "error">Fill in all fields!</p>';
                }
                else if($_GET["error"] == "logicError") {
                    echo '<p class = "error">Something went wrong try again!</p>';
                }
                else if($_GET["error"] == "wrongLogin") {
                    echo '<p class = "error">Check your login credentials</p>';
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