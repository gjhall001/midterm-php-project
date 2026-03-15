<?php
    header("Access-Content-Allow-Origin: *");
    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With");
    
    include_once "../../config/Database.php";
    include_once "../../model/Quote.php";

    // Instantiate Database & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote Object
    $quoteObj = new Quote($db);

    // Get id, author, and/or category
    $quoteObj->id = isset($_GET['id']) ? $_GET['id'] : null;
    $quoteObj->author = isset($_GET['author_id']) ? $_GET['author_id'] : null;
    $quoteObj->category = isset($_GET['category_id']) ? $_GET['category_id'] : null;
    try {
        if ($quoteObj->id) {
            if ($quoteObj->getQuoteById()) {
                $quoteObj_arr = array(
                    "id" => $quoteObj->id,
                    "quote" => $quoteObj->quote,
                    "author" => $quoteObj->author,
                    "category" => $quoteObj->category
                );
                echo json_encode($quoteObj_arr);
            } else {
                echo json_encode(array("message" => "No Quotes Found"));
            }
        } elseif ($quoteObj->author && $quoteObj->category) {
            //Query
            $result = $quoteObj->getQuotesByAuthorAndCategory();

            // Get Row Count
            $num = $result->rowCount();

            // Check if any quotes
            if ($num > 0) {
                $quotes_arr = array();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $quotes_item = array(
                        "id" => $id,
                        "quote" => $quote,
                        "author" => $author,
                        "category" => $category
                    );

                    // Push to array
                    array_push($quotes_arr, $quotes_item);
                }

                // Turn to JSON & Output
                echo json_encode($quotes_arr);
            } else {
                echo json_encode(array("message" => "No Quotes Found"));
                exit();
            }
        } elseif ($quoteObj->author) {
            //Query
            $result = $quoteObj->getQuotesByAuthor();

            // Get Row Count
            $num = $result->rowCount();

            // Check if any quotes
            if ($num > 0) {
                $quotes_arr = array();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $quotes_item = array(
                        "id" => $id,
                        "quote" => $quote,
                        "author" => $author,
                        "category" => $category
                    );

                    // Push to array
                    array_push($quotes_arr, $quotes_item);
                }

                // Turn to JSON & Output
                echo json_encode($quotes_arr);
            } else {
                echo json_encode(array("message" => "author_id Not Found"));
                exit();
            }
        } elseif ($quoteObj->category) {
            //Query
            $result = $quoteObj->getQuotesByCategory();

            // Get Row Count
            $num = $result->rowCount();

            // Check if any quotes
            if ($num > 0) {
                $quotes_arr = array();

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);

                    $quotes_item = array(
                        "id" => $id,
                        "quote" => $quote,
                        "author" => $author,
                        "category" => $category
                    );

                    // Push to array
                    array_push($quotes_arr, $quotes_item);
                }

                // Turn to JSON & Output
                echo json_encode($quotes_arr);
            } else {
                echo json_encode(array("message" => "category_id Not Found"));
                exit();
            }
        } else {
            echo json_encode(array("message" => "No Quotes Found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("message" => "No Quotes Found"));
    }