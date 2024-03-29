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
        SELECT * , 'user' AS table_source
        FROM user
        WHERE username = ?
        UNION ALL
        SELECT * , 'admin' AS table_source
        FROM admin
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
    if (strlen($password) < 8 or strlen($password) > 20) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function createUser($conn, $username, $password){
    $sql = "INSERT INTO user (username, password) VALUES (?, ?);";
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

    if ($sourceTable=="admin") {
        return true;
    }
    else if($sourceTable == "user") {
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
    }
}

//tools
function clearSession(){
    session_unset();
    session_destroy();
}

function isUserLoggedIn(){
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

//Table functions
function getTable($conn, $tableName){
    $result;
    $sql = "SELECT * FROM " . $tableName;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $result = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return json_encode($result);
}

function getElement($conn, $tableName, $id) {
    $result;
    $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $result = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return json_encode($result);
}


function deleteElement($conn, $tableName, $id){
    $sql = "DELETE FROM " . $tableName . " WHERE id = " . $id;

    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}

function editElement($conn, $tableName, $data) {
    $sql = "UPDATE $tableName SET ";
    $setValues = [];

    foreach ($data as $column => $value) {
        // Escape the values to prevent SQL injection
        $escapedValue = addslashes($value);
        $setValues[] = "$column = '$escapedValue'";
    }

    $sql .= implode(', ', $setValues);
    $sql .= " WHERE id = {$data['id']};";

    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}

function addElement($conn, $tableName, $data) {
    $sql = "INSERT INTO $tableName SET ";
    $setValues = [];

    foreach ($data as $column => $value) {
        // Escape the values to prevent SQL injection
        $escapedValue = addslashes($value);
        $setValues[] = "$column = '$escapedValue'";
    }

    $sql .= implode(', ', $setValues);

    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}

function getFavourites($conn, $user_id){
    $result;
    $sql = "SELECT phone_id FROM favourites WHERE user_id = " . $user_id;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    $result = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);

    return json_encode($result);
}

function addFavourite($conn, $user_id, $phone_id) {
    $sql = "INSERT INTO favourites (phone_id, user_id)
            VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $phone_id, $user_id);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}

function removeFavourite($conn, $user_id, $phone_id) {
    $sql = "DELETE FROM favourites
            WHERE phone_id = ? AND user_id = ?;
    ";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 'ii', $phone_id, $user_id);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
}

function getBrand($conn, $tableName, $brandName){
    $result;
    $sql = "SELECT * FROM " . $tableName . " WHERE brand = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $brandName);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $result = mysqli_fetch_all($resultData, MYSQLI_ASSOC);

        mysqli_stmt_close($stmt);
    }

    return json_encode($result);
}
