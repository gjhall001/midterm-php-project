<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Category.php";
    
    // Instantiate Database and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $categoryObj = new Category($db);

    // Get raw category data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->id)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();        
    }

    // Set ID to update
    $categoryObj->id = $data->id;

    // Delete Category
    if($categoryObj->delete()) {
        echo json_encode(array("id" => $categoryObj->id));
    } else {
        echo json_encode(array('message' => "No Quotes Found"));
    }
