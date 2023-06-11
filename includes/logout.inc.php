
<?php

session_start();

include "functions.inc.php";
clearSession();

header('Location: ../home.php');