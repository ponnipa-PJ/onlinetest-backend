<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods, GET');

include_once '../../config/database.php';
include_once '../../class/answers.php';
include_once '../../class/questionsandanswers.php';

$database = new Database();
$db = $database->getConnection();

$ques = new QuestionsAndAnswers($db);
$items = new Answers($db);

$stmt = $ques->getAllAnswersandQuestions();
$itemCount = $stmt->rowCount();
$ans = [];
$type = false;
// echo $itemCount;

if ($itemCount > 0) {

    $productArr = array();
    $detailArr = array();
    $productArr["body"] = array();
    $productArr["itemCount"] = $itemCount;
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // print_r($row['id']);
        $items->question_id = $row['id'];
        $stmtd = $items->getAnswersByquestionID();
        $detailCount = $stmtd->rowCount();
        $ans = $row['answer'];
        
        // echo $detailCount;
        if ($detailCount > 0) {
            $detailArr["body"] = array();
            while ($detail = $stmtd->fetch(PDO::FETCH_ASSOC)) {
                // if ( in_array($detail['id'],$ans) ){
                //     $type = true;
                // }
                $d = array(
                    "id" => $detail['id'],
                    "question_id" => $detail['question_id'],
                    "name" => $detail['name'],
                    "checked" => $type,
                );
                array_push($detailArr["body"], $d);
            }
        }
        extract($row);
        $e = array(
            "id" => $id,
            "question_id" => $question_id,
            "name" => $name,
            "answer" => $answer,
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
