<?php


//signup.inc.php
function emptyInputSignup($username, $password) {
    $result;

    if (empty($username) || empty($password)){
        $result = true;
    }else {$result = false;}

    return $result;
}

function uidExists($conn, $username) {
    $result;
    $sql = "
        SELECT * , 'senarai_pengguna' AS table_source
        FROM senarai_pengguna
        WHERE username = ?
        UNION ALL
        SELECT * , 'senarai_admin' AS table_source
        FROM senarai_admin
        WHERE username = ?
    ";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'ss', $username, $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
    }

    return $result;
    mysqli_stmt_close();
}

function passwordLength($password) {
    $result;
    if (strlen($password) < 8) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($conn, $username, $password){
    $sql = "INSERT INTO senarai_pengguna (username, password) VALUES (?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtFailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
}


//login.inc.php
function emptyInputLogin($username, $password) {
    $result;

    if (empty($username) || empty($password)){
        $result = true;
    }else {$result = false;}

    return $result;
}

function isAdmin($data){
    $sourceTable = $data['table_source'];

    if ($sourceTable=="senarai_admin") {
        return true;
    }
    else if($sourceTable == "senarai_pengguna") {
        return false;
    } 
    else {
        // header("location: ../login.php?error=logicError?source_table=" . $sourceTable);
        echo "" . $sourceTable;
        exit();
    }
}

function loginUser($conn, $username, $password) {
    $uidExists = uidExists($conn, $username);

    if ($uidExists == false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    }

    $storedPassword = $uidExists['password'];
    $checkedPassword = ($password == $storedPassword);

    if ($checkedPassword == false) {
        header("location: ../login.php?error=wrongLogin");
        exit();
    } 
    else if ($checkedPassword == true) {
        session_start();

        $_SESSION["uid"] = $uidExists['id'];
        $_SESSION["username"] = $uidExists['username'];

        if (isAdmin($uidExists)){
            $_SESSION["admin"] = "true";
        }
        else {
            $_SESSION["admin"] = "false";
        }

        // header("location: ../home.php?your_name=" . $uidExists['username'] . "&admin=" . $_SESSION['admin']);
        //change to the main page in the fture
        header("location: ../menu.php");
        exit();
    }
}

//tools
function clearSession(){
    session_unset();
    session_destroy();
}

function isUserLoggedIn(){

    session_start();

    if (
        !isset($_SESSION['username']) || 
        empty($_SESSION['username']) ||
        !isset($_SESSION['uid']) || 
        empty($_SESSION['uid']) ||
        !isset($_SESSION['admin']) || 
        empty($_SESSION['admin'])   
    ) {
        return false;
    } 
    else {
        return true;
    }
}