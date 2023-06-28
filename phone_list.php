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

        <title>Phone Table</title>
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
                    if (window.history.length > 1) {
                        window.history.back();
                    }
                    }
                </script>
            </div>
        </div>
        <div class="content">
            <div class="tableContainer">
                <div class="tableHeader">
                    <p class="selectedItemName"></p>
                    <button>Delete</button>
                    <button>Add</button>
                    <button>Edit</button>
                    <button>Upload</button>
                </div>
            </div>
            <table id="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Phone Name</th>
                    <th>Height</th>
                    <th>Width</th>
                    <th>Size</th>
                    <th>OS</th>
                    <th>Brand</th>
                    <th>Battery</th>
                    <th>Image URL</th>
                    <th>Phone URL</th>  
                </tr>
                </thead>
                <tbody>
                    <?php include "includes/phoneList.inc.php"; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>