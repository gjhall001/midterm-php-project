<?php
    // Headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");

    include_once "../../config/Database.php";
    include_once "../../model/Author.php";

    // Instantiate Database and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $authorObj = new Author($db);

    try {
        // Get ID
        $authorObj->id = isset($_GET['id']) ? $_GET['id'] : die();

        // Get Author
        if ($authorObj->read_single()) {
            // Create array
            $authorObj_arr = array(
                'id' => $authorObj->id,
                'author' => $authorObj->author
            );
            print_r(json_encode($authorObj_arr));
        } else {
            echo json_encode(array("message" => "author_id Not Found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("message" => "Missing Required Parameters"));
    }