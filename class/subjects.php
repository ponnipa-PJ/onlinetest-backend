<?php
class Subject
{

    // Connection
    private $conn;

    // Table
    private $db_table = "tbl_subjects";

    // Columns
    public $id;
    public $code;
    public $name;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getSubjects()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function createSubject()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET                        
                        name = :name,
                        code = :code";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->name = htmlspecialchars(strip_tags($this->name));

        // bind data
        $stmt->bindParam(":code", $this->code);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // READ single
    // READ single
    public function getsubjectbyid()
    {
        $sqlQuery = "SELECT
                        id,
                        name,
                        code
                      FROM
                      " . $this->db_table . "
                    WHERE 
                    id = $this->subject_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->subject_id);

        $stmt->execute();

        return $stmt;
    }

    public function getAllsubjectsbystuid()
    {
        $sqlQuery = "SELECT
                        tbl_subjects.id as subject_id,
                        tbl_subjects.name as subject_name,
                        tbl_parts.id as part_id,
                        tbl_parts.name as part_name,
                        tbl_parts.score,
                        tbl_parts.date,
                        tbl_parts.time
                      FROM
                        tbl_register
                        INNER JOIN tbl_subjects on tbl_register.subject_id =tbl_subjects.id
                        INNER JOIN tbl_parts on tbl_subjects.id =tbl_parts.subject_id
                    WHERE 
                    tbl_register.stu_id = $this->stu_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->stu_id);

        $stmt->execute();

        return $stmt;
    }

    public function getsubjectbystuid()
    {
        $sqlQuery = "SELECT
                        tbl_subjects.id as subject_id, 
                        tbl_subjects.name as subject_name
                      FROM
                        tbl_register
                        INNER JOIN tbl_subjects on tbl_register.subject_id =tbl_subjects.id
                    WHERE 
                    tbl_register.stu_id = $this->stu_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->stu_id);

        $stmt->execute();

        return $stmt;
    }

    public function getAllAnswersandQuestion()
    {
        $sqlQuery = "SELECT
                        tbl_questions.name,tbl_questions.id,tbl_answers.answer,tbl_answers.question_id
                      FROM
                        tbl_questions
                    INNER JOIN tbl_answers ON tbl_questions.id = tbl_answers.question_id
                    WHERE 
                        tbl_questions.id = tbl_answers.question_id
                        ORDER BY tbl_questions.id asc";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->execute();

        return $stmt;
    }

    // UPDATE
    public function updateAnswer()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        question_id = :question_id,
                        name = :name
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $this->name = htmlspecialchars(strip_tags($this->name));

        // bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":question_id", $this->question_id);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteType()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE TypeID = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->TypeID = htmlspecialchars(strip_tags($this->TypeID));

        $stmt->bindParam(1, $this->TypeID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
