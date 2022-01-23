<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");

    include_once '../../config/database.php';
    include_once '../../class/questionsandanswers.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new QuestionAndAnswer($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->question_id=$data->question_id;
    $item->answer_id=$data->answer_id;
    
    if($item->createQuestionsAndAnswers()){
        echo true;
    } else{
        echo 'Question and Answer could not be created.';
    }
?>