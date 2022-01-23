<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);
    header('Access-Control-Allow-Methods, DELETE');
    
    include_once '../../config/database.php';
    include_once '../../class/questionsandanswers.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new QuestionAndAnswer($db);
    
    $data = json_decode(file_get_contents("php://input"));

    $item->question_id = isset($_GET['question_id']) ? $_GET['question_id'] : die();

    // $item->id = $data->id;
    
    if($item->deleteQuestionsandAnswers()){
        echo 0;
    }else{
        http_response_code(404);
    }
?>