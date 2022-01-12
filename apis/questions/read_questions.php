<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../class/questions.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Questions($db);

    $stmt = $items->getQuestions();
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
                "name" => $name,
                "description" => $description,
                "parts" => $parts,
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