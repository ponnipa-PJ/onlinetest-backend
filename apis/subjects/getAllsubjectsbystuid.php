<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../class/subjects.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Subject($db);

    $items->stu_id = isset($_GET['stu_id']) ? $_GET['stu_id'] : die();
    $stmt = $items->getAllsubjectsbystuid();
    $itemCount = $stmt->rowCount();


    if($itemCount > 0){ 

        $productArr = array();
        $productArr["body"] = array();
        $productArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "subject_id" => $subject_id,
                "subject_name" => $subject_name,
                "part_id" => $part_id,
                "part_name" => $part_name,
                "score" => $score,
                "date" => $date,
                "time" => $time
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
