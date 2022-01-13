<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);

    include_once '../../config/database.php';
    include_once '../../class/parts.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Parts($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->name=$data->name;
    $item->score=$data->score;
    $item->date=$data->date;
    $item->time=$data->time;
    
    if($item->createPart()){
        echo 0;
    } else{
        echo 'Part could not be created.';
    }
?>