<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../class/tutorial.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Tutorial($db);

    $stmt = $items->getTutorial();
    $itemCount = $stmt->rowCount();


    // echo json_encode($itemCount);

    if($itemCount > 0){
        
        $productArr = array();
        $productArr["body"] = array();
        $productArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "title" => $title,
                "description" => $description,
                "published" => $published,
                "createdAt" => $createdAt,
                "updatedAt" => $updatedAt,
            );

            array_push($productArr["body"], $e);
        }
        echo json_encode($productArr["body"]);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>