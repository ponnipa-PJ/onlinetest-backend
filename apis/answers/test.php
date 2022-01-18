<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../class/parts.php';
include_once '../../class/questionsandanswers.php';
include_once '../../class/answers.php';
include_once '../../class/stu_answers.php';

$database = new Database();
$db = $database->getConnection();

$items = new Part($db);
$ques = new QuestionAndAnswer($db);
$answer = new Answer($db);
$stuanswers = new StuAnswer($db);

$items->subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();
$stmt = $items->getPartsBySubjectIDstu();
$itemCount = $stmt->rowCount();


if ($itemCount > 0) {

    $productArr = array();
    $productArr["body"] = array();
    $productArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $questionArr = array();
        $questionArr["body"] = array();
        $ques->part_id = $row['id'];
        $ques->subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();
        $stmtd = $ques->getAllAnswersandQuestions();
        $questionCount = $stmtd->rowCount();

        if ($questionCount > 0) {
            $answerArr = array();
            $answerArr["body"] = array();

            while ($question = $stmtd->fetch(PDO::FETCH_ASSOC)) {

                $answer->question_id = $question['question_id'];
                $stmtanswer = $answer->getAnswersByquestionID();
                $answerArrCount = $stmtanswer->rowCount();
                if ($answerArrCount > 0) {
                    while ($ans = $stmtanswer->fetch(PDO::FETCH_ASSOC)) {
                        $check = $stuanswers->answer_id = $ans['id'];
                        $check = $stuanswers->question_id = $ans['question_id'];
                        $check = $stuanswers->stu_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : die();;
                        $check = $stuanswers->getCheckanswerstu();

                        $a = array(
                            "answer_id" => $ans['id'],
                            "question_id" => $ans['question_id'],
                            "name" => $ans['name'],
                            "checked" => $check,
                        );
                        array_push($answerArr["body"], $a);
                    }
                }
                $q = array(
                    "question_id" => $question['question_id'],
                    "name" => $question['name'],
                    "details" => $answerArr["body"]
                );
                array_push($questionArr["body"], $q);
            }
        }
        extract($row);
        $e = array(
            "part_id" => $id,
            "name" => $name,
            "score" => $score,
            "questions" => $questionArr["body"]
        );
        array_push($productArr["body"], $e);
    }
    echo json_encode($productArr["body"]);
} else {
    // http_response_code(404);
    echo false;
}
