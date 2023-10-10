<?php

if (isset($_POST['usersignup'])) {
    //retrieve input
    $username = $_POST['username'];
    $password = $_POST['password'];

    //import function and establish connection
    require_once "dbh.inc.php";
    require_once "functions.inc.php";

    //error handling
    if ($output = emptyInputSignup($username, $password) !== false) {
        header("location: ../signup.php?error=emptyInput");
        exit();
    }
    if (uidExists($conn, $username) !== false) {
        header("location: ../signup.php?error=usernameTaken");
        exit();
    }
    if ($output = passwordLength($password) !== false) {
        header("location: ../signup.php?error=passwordLength");
        exit();
    }
    if ($password == $username) {
        header("location: ../signup.php?error=passwordSameAsUsername");
        exit();
    }

    //create and login user
    createUser($conn, $username, $password);
    loginUser($conn, $username, $password);

    //go to menu with signin successful message
    header("location: ../menu.php?message=Sign%20up%20Sucessful!");
} 
else {
    header("location: ../signup.php");
}