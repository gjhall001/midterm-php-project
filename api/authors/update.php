<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Author.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $authorObj = new Author($db);

    // Get raw author data
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id) || !isset($data->author)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();       
    }

    if (!$authorObj->authorExists($data->id)) {
        echo json_encode(array("message" => "author_id Not Found"));
        exit();        
    }

    $authorObj->id = $data->id;
    $authorObj->author = $data->author;    

    if ($authorObj->update){
        echo json_encode($authorObj);
    }

    // if (isset($data->id) && isset($data->author)) {
    //     $authorObj->id = $data->id;
    //     $authorObj->author = $data->author;

    //     if ($authorObj->update()) {
    //         echo json_encode($authorObj);
    //     } else {
    //         echo json_encode(array("message" => "author_id Not Found"));
    //         exit();
    //     }      
    // } elseif (isset($data->id) && !isset($data->author)) {
    //     $authorObj->id = $data->id;
    //     $isSet = $authorObj->update();
    //     if ($isSet) {
    //         echo json_encode(array("message" => "Missing Required Parameters"));
    //         exit();
    //     } else {
    //         echo json_encode(array("message" => "author_id Not Found"));
    //         exit();            
    //     }
    // } elseif (!isset($data->id) && isset($data->author)) {
    //     $authorObj->author = $data->author;
    //     echo json_encode(array("message" => "Missing Required Parameters"));
    //     exit();
    // } elseif (!isset($data->id) && !isset($data->author)) {
    //     echo json_encode(array("message" => "Missing Required Parameters"));
    //     exit();
    // }
