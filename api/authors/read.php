<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    
    include_once "../../config/Database.php";
    include_once "../../model/Author.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Author Object
    $authorObj = new Author($db);

    // Author query
    $result = $authorObj->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any authors
    if ($num > 0) {
        $authors_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push to "data"
            array_push($authors_arr, $author_item);
        }

        // Turn to JSON & Outpot
        echo json_encode($authors_arr);
    } else {
        // No Authors
        echo json_encode(array('message' => "author_id Not Found."));
    }