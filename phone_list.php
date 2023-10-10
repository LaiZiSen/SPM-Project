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
if (isset($_GET['popup'])){
    $message = $_GET['popup'];

    echo "
    <script>
        alert('$message');
    </script>
    ";
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
                    <button class="add">Add</button>
                    <button class="edit">Edit</button>
                    <input type="file" class="upload" accept=".csv" />
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
            <div class="filter-container">
                <p class="filter-description">Filter by Brand:</p>
                <input type="text" class="brand-filter" placeholder="Enter brand name">
                <button class="filter-button">Filter</button>
                <button class='cancel-filter-button'>Cancel Filter</button>
                <button id="changeFontSize">Change Font Size</button>
            </div>
            <script src= 'includes/tableFontSizer.inc.js'></script>
            <p class="error">
                <?php
                    $error = isset($_GET["error"]) ? $_GET["error"] : '';

                    if (!empty($error)) {
                        switch ($error) {
                            case "Empty":
                                echo "Check if all inputs are not empty!";
                                break;
                            case "Variable Format Error":
                                echo "Check if the variable format is valid!";
                                break;
                            case "TableName Doesn't Exist!":
                                echo "Logic Error: Tablename is not properly passed to table.inc.js, contact the developer!";
                                break;
                            case "Name Repeated":
                                echo "Do not repeat the names";
                                break;
                            case "Fetch Error":
                                echo "Something wrong in the fetch process";
                                break;
                            case "Data Format Error":
                                echo "Data Format Error";
                                break;
                            case "CsvError":
                                echo $_GET["message"];
                                break;
                            default:
                                echo "Unknown Error: " . $error;
                                break;
                        }
                    } else {
                        echo "";
                    }
                ?>
            </p>
        </div>
        <div class="overlay"> <!-- testing -->
            <div class="overlay-content">
                <h2 class='formHeading'></h2>

                <label>Phone Name:</label>
                <input type="text" id="phone_name">

                <label>Height:</label>
                <input type="text" id="height">

                <label>Width:</label>
                <input type="text" id="width">

                <label>Size:</label>
                <input type="text" id="size">

                <label>OS:</label>
                <input type="text" id="os">

                <label>Brand:</label>
                <input type="text" id="brand">

                <label>Battery:</label>
                <input type="text" id="battery">

                <label>Image URL:</label>
                <input type="text" id="image_url">

                <label>Phone URL:</label>
                <input type="text" id="phone_url">
                
                <button class="submit">Submit</button>
                <button class="cancel">Cancel</button>
            </div>
        </div>

    </body>
</html>