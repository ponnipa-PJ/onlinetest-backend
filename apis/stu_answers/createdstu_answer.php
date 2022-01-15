<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);

    include_once '../../config/database.php';
    include_once '../../class/stu_answers.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new StuAnswer($db);

    $data = json_decode(file_get_contents("php://input"));
    
    $item->stu_id=$data->stu_id;
    $item->question_id=$data->question_id;
    $item->answer_id=$data->answer_id;
    
    if($item->createStuAnswers()){
        echo 0;
    } else{
        echo 'Question and Answer could not be created.';
    }
?>