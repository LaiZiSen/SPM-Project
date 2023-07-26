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
        <link rel="stylesheet" href="styles/info.css">
        <link rel="stylesheet" href="styles/header3.css">

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
            <h1>Choose your phone</h1>
            <div class="info-block">
                <div class="info">
                    <p>Which mobile phone suits you depends on what you are going to use your smartphone for. Think about what you find important about your new smartphone:</p>
                    <ul>
                        <li>What size do you want?</li>
                        <li>What do you find important about the camera?</li>
                        <li>Which operating system do you want?</li>
                        <li>How long should your battery last?</li>
                        <li>Do you need a fast and powerful device?</li>
                        <li>Do you want to receive regular updates?</li>
                    </ul>
                </div>
                <div class="filler"></div>
                <img src="https://image.coolblue.nl/624x351/content/8d983051389b18b4b5c41041776895f6" alt="">
            </div>
            
            <h2>Size</h2>
            <div class="info-block">
                <div class="info">
                    <p>The size is very important when choosing a smartphone. A somewhat smaller mobile phone fits in your pocket and is easy to operate with one hand. These smaller phones aren't suitable for gaming or for comfortably watching movies and series. Smartphones with a somewhat larger screen are a better choice for this. These are harder to operate with 1 hand. Nowadays, there aren't many small smartphone, because they don't have much space for a good battery.</p>
                </div>
                <div class="filler"></div>
                <img src="https://image.coolblue.nl/624x351/content/fee76d63bc378261928e339a2525e88a" alt="">
            </div>

            <h2>Camera</h2>
            <div class="info-block">
                <div class="info">
                    <p>If you often want to take good pictures with your smartphone, there are a lot of complicated specifications to consider. To help you choose a phone, we've assessed all mobile phones based on the aperture's opening, the number of megapixels, and image stabilization. That way, you can see if the camera meets your requirements at a single glance. Also note the type of lens in the camera. With a wide-angle lens, you can take photos of vast landscapes, while a telephoto lens lets you zoom in from afar.</p>
                </div>
                <div class="filler"></div>
                <img src="https://image.coolblue.nl/624x351/content/e98552a9d244f39a67ec06e4176c05b3" alt="">
            </div>  

            <h2>Battery</h2>
            <div class="info-block">
                <div class="info">
                    <p>Do you find it important that you can make it to the end of the day without charging your smartphone? It's important your device has a good battery. The battery life of a mobile phone depends strongly on your use and settings. An average user can lasts the whole day with a 5000mAh battery. Are you about to choose a phone with a smaller battery? Check if it has a fast charge function. This way, you can charge your smartphone very fast.</p>
                </div>
                <div class="filler"></div>
                <img src="https://image.coolblue.nl/624x351/content/8517c9d475d319c00ae3aefa56a90414" alt="">
            </div>  

            <h2>Operating System</h2>
            <div class="info-block">
                <div class="info">
                    <p>The most common operating systems are iOS and Android. The iOS operating system can be found on Apple smartphones, and it's known for its security. However, it does have limited options if you want to exchange files with a non-Apple device. Android is the operating system of all the other brands including Samsung, OnePlus, and Xiaomi. These brands add their own shell of non-removable apps and extra functions to the operating system. Android One is a stripped Android version that comes with monthly security updates.</p>
                </div>
                <div class="filler"></div>
                <img src="https://image.coolblue.nl/624x351/content/fb5744bc24a05e12e358bcf973d89126" alt="">
            </div>  
        </div>
    </body>
</html>