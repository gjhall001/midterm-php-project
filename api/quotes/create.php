<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    
    include_once "../../config/Database.php";
    include_once "../../model/Quote.php";

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // /Instantiate New Quote Object
    $quoteObj = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

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
    
    $quoteObj->quote = $data->quote;
    $quoteObj->author = $data->author_id;
    $quoteObj->category = $data->category_id;    

    if ($quoteObj->create()) {
        echo json_encode($quoteObj);
    }