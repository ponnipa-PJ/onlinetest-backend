<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../class/answers.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Answer($db);

    $stmt = $items->getAllAnswersandQuestion();
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
                "question_id" => $question_id,
                "answer" => $answer,
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
    // if($item->id != null){
    //     // create array
    //     $emp_arr = array(
    //         "id" => $item->id,
    //         "question_id" => $item->question_id,
    //         "answer" => $item->answer,
    //     );
      
    //     http_response_code(200);
    //     echo json_encode($emp_arr);
    // }
      
    // else{
    //     http_response_code(404);
    //     echo json_encode("Product not found.");
    // }
