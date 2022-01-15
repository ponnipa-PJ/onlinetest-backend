<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);

    include_once '../../config/database.php';
    include_once '../../class/questions.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Question($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->name=$data->name;
    $item->description=$data->description;
    $item->part_id=$data->part_id;
    $item->subject_id=$data->subject_id;
    
    $stmt = $item->createQuestion();

    echo $stmt;
?>