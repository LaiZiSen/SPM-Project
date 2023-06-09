<?php

if (isset($_POST['usersignup'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once "dbh.inc.php";
    require_once "functions.inc.php";

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

    createUser($conn, $username, $password);
    loginUser($conn, $username, $password);

} 
else {
    header("location: ../signup.php");
}