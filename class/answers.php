<?php
    class Answer{

        // Connection
        private $conn;

        // Table
        private $db_table = "tbl_answers";

        // Columns
        public $id;
        public $question_id;
        public $name;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getAnswers(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createAnswers(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET                        
                        question_id = :question_id,
                        name = :name";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->question_id=htmlspecialchars(strip_tags($this->question_id));
            $this->name=htmlspecialchars(strip_tags($this->name));
        
            // bind data
            $stmt->bindParam(":question_id", $this->question_id);
            $stmt->bindParam(":name", $this->name);
        
            if($stmt->execute()){
               return $this->conn->lastInsertId();
            }
            return false;
        }

        // READ single
        public function getAnswersByquestionID(){
            $sqlQuery = "SELECT
                        id,
                        question_id,
                        name
                      FROM
                        ". $this->db_table ."
                    WHERE 
                        question_id = $this->question_id";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->question_id);

            $stmt->execute();

            return $stmt;
        }

        public function getAllAnswersandQuestion(){
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
        public function updateAnswer(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
             // sanitize
             $this->id=htmlspecialchars(strip_tags($this->id));
             $this->name=htmlspecialchars(strip_tags($this->name));
         
             // bind data
             $stmt->bindParam(":id", $this->id);
             $stmt->bindParam(":name", $this->name);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteAnswer(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
