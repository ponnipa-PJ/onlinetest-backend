<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../class/users.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new User($db);

    $items->id = isset($_GET['id']) ? $_GET['id'] : die();
    $stmt = $items->getUserid();
    $itemCount = $stmt->rowCount();


    if($itemCount > 0){ 

        $productArr = array();
        $productArr["body"] = array();
        $productArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "role" => $role,
            );

            array_push($productArr["body"], $e);
        }
        echo json_encode($productArr["body"]);
    }
    else{
        // http_response_code(404);
        echo false;
    }
