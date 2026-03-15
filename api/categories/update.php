<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Category.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $categoryObj = new Category($db);

    // Get raw category data
    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->id) || !isset($data->category)) {
        echo json_encode(array("message" => "Missing Required Parameters"));
        exit();       
    }

    if (!$categoryObj->categoryExists($data->id)) {
        echo json_encode(array("message" => "category_id Not Found"));
        exit();        
    }

    $categoryObj->id = $data->id;
    $categoryObj->category = $data->category;    

    if ($categoryObj->update){
        echo json_encode($categoryObj);
    }    
    
    // if (isset($data->id) && isset($data->category)) {
    //     $categoryObj->id = $data->id;
    //     $categoryObj->category = $data->category;

    //     if ($categoryObj->update()) {
    //         echo json_encode($categoryObj);
    //     } else {
    //         echo json_encode(array("message" => "category_id Not Found"));
    //         exit();
    //     }      
    // } elseif (isset($data->id) && !isset($data->category)) {
    //     $categoryObj->id = $data->id;
    //     $isSet = $categoryObj->update();
    //     if ($isSet) {
    //         echo json_encode(array("message" => "Missing Required Parameters"));
    //         exit();
    //     } else {
    //         echo json_encode(array("message" => "category_id Not Found"));
    //         exit();            
    //     }
    // } elseif (!isset($data->id) && isset($data->category)) {
    //     echo json_encode(array("message" => "Missing Required Parameters"));
    //     exit();
    // } elseif (!isset($data->id) && !isset($data->category)) {
    //     echo json_encode(array("message" => "Missing Required Parameters"));
    //     exit();
    // }
