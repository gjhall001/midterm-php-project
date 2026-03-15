<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Category.php";

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate New Category Object
    $categoryObj = new Category($db);
    
    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->category)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
    } else {
        //$categoryObj->id = $data->id;
        $categoryObj->category = $data->category;

        // Create Category
        if($categoryObj->create()) {
            echo json_encode($categoryObj);
        } else {
            echo json_encode(array('message' => "category_id Not Found"));
        }
    }
