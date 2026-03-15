<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
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
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();        
    }

    // Set ID to update
    $quoteObj->id = $data->id;

    // Delete Quote
    if ($quoteObj->delete()) {
        echo json_encode(array("id" => $quoteObj->id));
    } else {
        echo json_encode(array('message' => "No Quotes Found"));
    }
