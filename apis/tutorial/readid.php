<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../class/tutorial.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Tutorial($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
    $item->getidTutorial();

    if($item->id != null){
        // create array
        $emp_arr = array(
            "id" => $item->id,
            "title" => $item->title,
            "description" => $item->description,
            "published" => $item->published,
            "createdAt" => $item->createdAt,
            "updatedAt" => $item->updatedAt
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Product not found.");
    }
?>