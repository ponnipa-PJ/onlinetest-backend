<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods, GET');

include_once '../../config/database.php';
include_once '../../class/answers.php';
include_once '../../class/questionsandanswers.php';
include_once '../../class/stu_answers.php';

$database = new Database();
$db = $database->getConnection();

$ques = new QuestionAndAnswer($db);
$items = new Answer($db);
$answers = new StuAnswer($db);

$ques->subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();

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
                $check=$answers->answer_id = $detail['id'];
                $check=$answers->question_id = $detail['question_id'];
                $check=$answers->getCheckanswerstu();

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
            "question_id" => $question_id,
            "name" => $name,
            "details" => $detailArr["body"]
        );
        array_push($productArr["body"], $e);
    }
    echo json_encode($productArr["body"]);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
