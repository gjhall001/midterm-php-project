<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Author.php";

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate New Author Object
    $authorObj = new Author($db);
    
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->author)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
    } else {
        //$authorObj->id = $data->id;
        $authorObj->author = $data->author;

        // Create Author
        if($authorObj->create()) {
            echo json_encode($authorObj);
        } else {
            echo json_encode(array('message' => "author_id Not Found"));
        }
    }
