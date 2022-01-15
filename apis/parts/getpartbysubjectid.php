<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../class/parts.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Part($db);

    $items->subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();
    $stmt = $items->getPartsBySubjectID();
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
                "score" => $score,
                "date" => $date,
                "time" => $time,
                "subject_id" => $subject_id
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
