<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/answers.php';
include_once '../../class/questions.php';
include_once '../../class/questionsandanswers.php';

$database = new Database();
$db = $database->getConnection();

$items = new Question($db);
$answeradmin = new Answer($db);
$questionsandanswer = new QuestionAndAnswer($db);

$items->question_id = isset($_GET['question_id']) ? $_GET['question_id'] : die();
$stmt = $items->getQuestionsAndAnswersbyquestionid();
$itemCount = $stmt->rowCount();


if ($itemCount > 0) {

    $productArr = array();
    $productArr["body"] = array();
    $productArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $answeradmin->question_id = $row['id'];
        $stmtanswer = $answeradmin->getAnswersByquestionID();
        $answerArrCount = $stmtanswer->rowCount();

        if ($answerArrCount > 0) {
            $answerArr = array();
            $answerArr["body"] = array();
            while ($ans = $stmtanswer->fetch(PDO::FETCH_ASSOC)) {
                $check = $questionsandanswer->answer_id = $ans['id'];
                $check = $questionsandanswer->question_id = $ans['question_id'];
                $check = $questionsandanswer->getCheckanswer();

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
            "question_id" => $id,
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
