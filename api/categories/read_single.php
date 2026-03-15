<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Category.php";

    // Instantiate Database and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $categoryObj = new Category($db);

    try {
        // Get ID
        $categoryObj->id = isset($_GET['id']) ? $_GET['id'] : die();

        // Get Category
        if ($categoryObj->read_single()) {
            // Create array
            $categoryObj_arr = array(
                'id' => $categoryObj->id,
                'category' => $categoryObj->category
            );
            print_r(json_encode($categoryObj_arr));
        } else {
            echo json_encode(array("message" => "category_id Not Found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("message" => "Missing Required Parameters"));
    }
