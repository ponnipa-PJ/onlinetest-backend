<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/answers.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Answer($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // product values
    $item->name=$data->name;
    
    if($item->updateAnswer()){
        echo json_encode("Answer data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>