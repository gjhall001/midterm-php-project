<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    
    include_once "../../config/Database.php";
    include_once "../../model/Quote.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quoteObj = new Quote($db);

    // Get raw quote data
    $data = json_decode(file_get_contents("php://input"));


    if (!isset($data->id)) {
        echo json_encode(array("message" => "No Quotes Found"));
        exit();
    }

    if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();
    }

    if (!$quoteObj->authorExists($data->author_id)) {
        echo json_encode(array("message" => "author_id Not Found"));
        exit();
    }

    if (!$quoteObj->categoryExists($data->category_id)) {
        echo json_encode(array("message" => "category_id Not Found"));
        exit();
    }

    $quoteObj->id = $data->id;
    $quoteObj->quote = $data->quote;
    $quoteObj->author = $data->author_id;
    $quoteObj->category = $data->category_id; 
    
    if ($quoteObj->update()) {
        $quote_arr = array(
            "id" => $quoteObj->id,
            "quote" => $quoteObj->quote,
            "author_id" => $quoteObj->author,
            "category_id" => $quoteObj->category
        );

        echo json_encode($quote_arr);
    } else {
        echo json_encode(array("message" => "No Quotes Found"));
        exit();
    }