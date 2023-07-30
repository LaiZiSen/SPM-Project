<?php
session_start();

include "includes/functions.inc.php";

if ($admin = !isUserLoggedIn()) {
    header("Location: home.php");
    exit();
} 
if ($_SESSION['admin'] == "false"){
    header("Location: menu.php");
}
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">

        <link rel="stylesheet" href="styles/general.css">
        <link rel="stylesheet" href="styles/listing.css">
        <link rel="stylesheet" href="styles/header3.css">
        
        <link rel="stylesheet" href="styles/listing.css" media="print">

        <title>Information</title>
    </head>
    <body>
        <div class="header">
            <div class='left-section'>
            <p><?php echo $_SESSION['username']; ?></p>
            </div>
            <div class='middle-section'>    
                <a href="http://localhost/k-tech/">
                    <img class="logo" src="resources/k-tech-horizontal.png" alt="">
                </a>
            </div>
            <div class='right-section'>
                <a onclick="goBack()">Back</a>
                <script>
                    function goBack() {
                        window.location.href = "index.php";
                    }
                </script>
            </div>
        </div>
        <div class="content">
            <div class="tableContainer">
                <div class="tableHeader">
                    <p class="selectedItemName"></p>
                    <button class='print' onclick="printPage()">Print</button>
                    <button class="delete">Delete</button>
                </div>
            </div>
            <table id="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>User Password</th>
                </tr>
                </thead>
                <tbody>
                    <?php include "includes/userList.inc.php"; ?>
                </tbody>
            </table>
            <p class="error"></p>
        </div>
    </body>
</html>