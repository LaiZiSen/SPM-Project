<?php

if (isset($_POST['userlogin'])) {
    //retrieve input
    $username = $_POST['username'];
    $password = $_POST['password'];

    //import function and establish connection
    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    //error handling
    if ($output = emptyInputLogin($username, $password) !== false) {
        header("location: ../login.php?error=emptyInput");
        exit();
    }

    //login
    loginUser($conn, $username, $password);

    //go to menu page
    header("location: ../menu.php?message=Login%20Sucessful!");
}
else {
    header("location: ../login.php");
    exit();
}