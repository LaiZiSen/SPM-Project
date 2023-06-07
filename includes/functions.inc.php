<?php

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
        SELECT username
        FROM senarai_pengguna
        WHERE username = ?
        UNION ALL
        SELECT username
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

    if (mysqli_fetch_assoc($resultData)) {
        $result = true;
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