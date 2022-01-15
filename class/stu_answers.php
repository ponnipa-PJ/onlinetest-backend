<?php
class StuAnswer
{

    // Connection
    private $conn;

    // Table
    private $db_table = "tbl_stu_answers";

    // Columns
    public $id;
    public $stu_id;
    public $question_id;
    public $answer_id;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getStuAnswers()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getCheckanswerstu(){
        $sqlQuery = "SELECT
                    id,
                    question_id,
                    answer_id
                  FROM
                    ". $this->db_table ."
                WHERE 
                    answer_id = $this->answer_id
                    and question_id = $this->question_id
                    and stu_id = $this->stu_id
                    LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        
        $stmt->bindParam(1, $this->stu_id);
        $stmt->bindParam(1, $this->answer_id);
        $stmt->bindParam(1, $this->question_id);

        $stmt->execute();            

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($dataRow){
            return true;
        }else{
            return false;
        }
        
    }

    // CREATE
    public function createStuAnswers()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET 
                        stu_id = :stu_id,                       
                        question_id = :question_id,
                        answer_id = :answer_id";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->stu_id = htmlspecialchars(strip_tags($this->stu_id));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $this->answer_id = htmlspecialchars(strip_tags($this->answer_id));

        // bind data
        $stmt->bindParam(":stu_id", $this->stu_id);
        $stmt->bindParam(":question_id", $this->question_id);
        $stmt->bindParam(":answer_id", $this->answer_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteStuAnswer()
    {
        $sqlQuery = "DELETE tbl_stu_answers FROM tbl_stu_answers
            WHERE tbl_stu_answers.question_id = $this->question_id
            AND tbl_stu_answers.stu_id = $this->stu_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->stu_id = htmlspecialchars(strip_tags($this->stu_id));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
