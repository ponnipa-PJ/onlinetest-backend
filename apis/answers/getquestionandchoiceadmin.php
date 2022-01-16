<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods, GET');

include_once '../../config/database.php';
include_once '../../class/answers.php';
include_once '../../class/questionsandanswers.php';

$database = new Database();
$db = $database->getConnection();

$ques = new QuestionAndAnswer($db);
$items = new Answer($db);

$ques->subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();
$ques->part_id = isset($_GET['part_id']) ? $_GET['part_id'] : die();

$stmt = $ques->getAllAnswersandQuestions();

$itemCount = $stmt->rowCount();
$ans = [];
// echo $itemCount;

if ($itemCount > 0) {

    $productArr = array();
    $detailArr = array();
    $productArr["body"] = array();
    $productArr["itemCount"] = $itemCount;
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // print_r($row['question_id']);
        $items->question_id = $row['question_id'];
        $stmtd = $items->getAnswersByquestionID();
        $detailCount = $stmtd->rowCount();
        $ans = $row['answer'];
        
        if ($detailCount > 0) {
            $detailArr["body"] = array();
            while ($detail = $stmtd->fetch(PDO::FETCH_ASSOC)) {
                // print_r($detail);
                $check=$ques->answer_id = $detail['id'];
                $check=$ques->question_id = $detail['question_id'];
                $check=$ques->getCheckanswer();
                
                $d = array(
                    "answer_id" => $detail['id'],
                    "question_id" => $detail['question_id'],
                    "name" => $detail['name'],
                    "checked" => $check,
                );
                array_push($detailArr["body"], $d);
            }
        }
        extract($row);
        $e = array(
            "questions_answers_id" => $questions_answers_id,
            "question_id" => $question_id,
            "name" => $name,
            "answer" => $answer,
            "details" => $detailArr["body"]
        );
        array_push($productArr["body"], $e);
    }
    echo json_encode($productArr["body"]);
} else {
    // http_response_code(404);
    // echo json_encode(
    //     array("message" => "No record found.")
    // );
    echo false;
}
