<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/questionsandanswers.php';
include_once '../../class/answers.php';

$database = new Database();
$db = $database->getConnection();

$items = new QuestionAndAnswer($db);
$answer = new Answer($db);

$items->subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();
$items->part_id = isset($_GET['part_id']) ? $_GET['part_id'] : die();
$stmt = $items->getAllAnswersandQuestions();
$itemCount = $stmt->rowCount();


if ($itemCount > 0) {

    $productArr = array();
    $productArr["body"] = array();
    $productArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $answer->question_id = $row['question_id'];
        $stmtanswer = $answer->getAnswersByquestionID();
        $answerArrCount = $stmtanswer->rowCount();

        if ($answerArrCount > 0) {
            $answerArr = array();
            $answerArr["body"] = array();
            while ($ans = $stmtanswer->fetch(PDO::FETCH_ASSOC)) {
                $check = $items->answer_id = $ans['id'];
                $check = $items->question_id = $ans['question_id'];
                $check = $items->getCheckanswer();

                $a = array(
                    "answer_id" => $ans['id'],
                    "question_id" => $ans['question_id'],
                    "name" => $ans['name'],
                    "checked" => $check,
                );
                array_push($answerArr["body"], $a);
            }
        }
        extract($row);
        $e = array(
            "question_id" => $question_id,
            "name" => $name,
            "details" => $answerArr["body"]
        );

        array_push($productArr["body"], $e);
    }
    echo json_encode($productArr["body"]);
} else {
    // http_response_code(404);
    echo false;
}
