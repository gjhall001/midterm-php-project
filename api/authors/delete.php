<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Author.php";
    
    // Instantiate Database and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $authorObj = new Author($db);

    // Get raw author data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->id)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();        
    }

    // Set ID to update
    $authorObj->id = $data->id;

    // Delete Author
    if($authorObj->delete()) {
        echo json_encode(array("id" => $authorObj->id));
    } else {
        echo json_encode(array('message' => "author_id Not Found"));
    }
