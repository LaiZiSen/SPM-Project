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
                    <a href="home.html">
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
                            <button type='submit' name="signup">Signup</button>
                            <p>Have an account?<a href="login.php">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>