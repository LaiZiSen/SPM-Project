<?php

session_start();
include "includes/functions.inc.php";


if (!isUserLoggedIn()) {
    header("Location: home.php");
    exit();
} 
if ($_SESSION["admin"] == "false"){
    header("Location: menu.php");
    exit();
} 
if ($_SESSION["admin"] == "true"){
    header("Location: admin.php");
    exit();
}
exit();