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
        
        case "editElement":
            $data = [];
            foreach ($_GET as $key => $value) {
                if ($key !== 'method' && $key !== 'tableName') {
                    // Process the key-value pair here
                    echo "Key: $key, Value: $value <br>"; //collect data
                    $data[$key] = $value;
                }
            }
            echo json_encode($data);
            echo "<br><br><br>";
            echo editElement($conn, $_GET['tableName'], $data);
            break;

            case "addElement":
                $data = [];
                foreach ($_GET as $key => $value) {
                    if ($key !== 'method' && $key !== 'tableName') {
                        // Process the key-value pair here
                        $data[$key] = $value;
                    }
                }
                $result = addElement($conn, $_GET['tableName'], $data);
                $response = [
                    'data' => $data,
                    'result' => $result
                ];
                echo json_encode($response);
                break;

        default:
            echo "Invalid method. Method: " . $method;
            break;
    }
} else {
    echo "No Method Specified!";
}


//localhost/k-tech/includes/ajaxRequest.inc.php?method=addElement&tableName=phone&phone_name=as&height=1%20mm&width=2%20mm&size=2%22&os=asd&brand=12&battery=2%20mAh&image_url=aasda&phone_url=2323