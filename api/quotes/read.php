<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    
    include_once "../../config/Database.php";
    include_once "../../model/Quote.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quoteObj = new Quote($db);

    // Quote query
    $result = $quoteObj->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if ($num > 0) {
        $quotes_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                "id" => $id,
                "quote" => $quote,
                "author" => $author,
                "category" => $category
            );

            // Push to array
            array_push($quotes_arr, $quote_item);
        }

        // Turn to JSON & Output
        echo json_encode($quotes_arr);
    } else {
        // No Quotes
        echo json_encode(array("message" => "quote_id Not Found"));
    }