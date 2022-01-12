<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);

    include_once '../../config/database.php';
    include_once '../../class/tutorial.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Tutorial($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->title=$data->title;
    $item->description=$data->description;
    $item->published=$data->published;
    $item->createdAt=$data->createdAt;
    $item->updatedAt=$data->updatedAt;
    
    if($item->createTutorial()){
        echo 0;
    } else{
        echo 'Product could not be created.';
    }
?>