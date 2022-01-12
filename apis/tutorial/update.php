<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../../config/database.php';
    include_once '../../class/tutorial.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Tutorial($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // product values
    $item->title=$data->title;
    $item->description=$data->description;
    $item->published=$data->published;
    $item->updatedAt=$data->updatedAt;

    
    if($item->updateTutorial()){
        echo json_encode("Product data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>