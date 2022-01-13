<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/questionsandanswers.php';

$database = new Database();
$db = $database->getConnection();

$item = new QuestionsAndAnswers($db);

$item->answer_id = isset($_GET['answer_id']) ? $_GET['answer_id'] : die();
$item->question_id = isset($_GET['question_id']) ? $_GET['question_id'] : die();
$item->getCheckanswer();

if ($item->id != null) {
    // create array
    echo true;
} else {
    echo false;
}
