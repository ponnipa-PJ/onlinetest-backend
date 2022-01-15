<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    // header('Access-Control-Allow-Credentials', true);

    include_once '../../config/database.php';
    include_once '../../class/answers.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Answer($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->question_id=$data->question_id;
    $item->name=$data->name;

    $stmt = $item->createAnswers();

    echo $stmt;
    // if($item->createAnswers()){
    //     echo $item->insert_id;
    //     echo 0;
    // } else{
    //     echo 'Answer could not be created.';
    // }
?>