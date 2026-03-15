<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    
    include_once "../../config/Database.php";
    include_once "../../model/Category.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Category Object
    $categoryObj = new Category($db);

    // Category query
    $result = $categoryObj->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any categories
    if ($num > 0) {
        $categories_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push to array
            array_push($categories_arr, $category_item);
        }

        // Turn to JSON & Output
        echo json_encode($categories_arr);
    } else {
        // No Categories
        echo json_encode(array('message' => "category_id Not Found."));
    }