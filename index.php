<?php

session_start();
include "includes/functions.inc.php";


if (isUserLoggedIn()) {
    header("Location: menu.php");
}
else {
    header("Location: home.php");
}
exit();