<?php
session_start();

include "includes/functions.inc.php";

if (!isUserLoggedIn()) {
    header("Location: home.php");
    exit();
}
if ($_SESSION['admin'] == "true"){
    header("Location: admin.php");
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
        <link rel="stylesheet" href="styles/header3.css">
        <link rel="stylesheet" href="styles/compare.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <title>Compare</title>
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
            <div class="left-div compare-div">
                <img class="item-img" src="https://technave.com/data/files/article/202209090148323176.jpg" alt="">
                <p class="detail-text">Height: 147.5 mm</p>
                <p class="detail-text">Width: 71.5 mm</p>
                <p class="detail-text">Size: 6.1"</p>
                <p class="detail-text">OS: iOS</p>
                <p class="detail-text">Battery: 4323 mAh</p>
                <a href="https://www.apple.com/my/iphone-14-pro/specs/">Phone Url</a>
                <button class='change'>Change</button>
            </div>
            <div class="right-div compare-div">
                <div class='item-list'>
                    <div class="compare-item">Huawai 1</div>
                    <div class="compare-item">Iphone 13 pro</div>
                    <div class="compare-item">Dummy Phone 10k</div>
                </div>
                <?php include "includes/compare.inc.php"; ?>
            </div>
        </div>
    </body>
</html>