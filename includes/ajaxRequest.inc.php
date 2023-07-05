<?php

require_once "dbh.inc.php";
require_once "functions.inc.php";

// console.log("ajax php");

if (isset($_GET['method'])) {
    $method = $_GET['method'];

    switch ($method) {
        case "deleteElement":
            if (isset($_GET['tableName']) && isset($_GET['id'])) {
                deleteElement($conn, $_GET['tableName'], $_GET['id']);
                echo "User Deleted Successfully!";
            } else {
                echo "Invalid Request!";
            }
            break;
            
        default:
            echo "Invalid method!";
            break;
    }
} else {
    echo "No Method Specified!";
}