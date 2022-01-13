<?php
    class QuestionsAndAnswers{

        // Connection
        private $conn;

        // Table
        private $db_table = "tbl_questions_answers";

        // Columns
        public $id;
        public $question_id;
        public $answer_id;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getQuestionsAndAnswers(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createQuestionsAndAnswers(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET                        
                        question_id = :question_id,
                        answer_id = :answer_id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->question_id=htmlspecialchars(strip_tags($this->question_id));
            $this->answer_id=htmlspecialchars(strip_tags($this->answer_id));
        
            // bind data
            $stmt->bindParam(":question_id", $this->question_id);
            $stmt->bindParam(":answer_id", $this->answer_id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getAnswersByquestionID(){
            $sqlQuery = "SELECT
                        id,
                        question_id,
                        answer_id
                      FROM
                        ". $this->db_table ."
                    WHERE 
                        question_id = $this->question_id";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->question_id);

            $stmt->execute();

            return $stmt;
        }
        public function getAllAnswersandQuestions(){
            $sqlQuery = "SELECT 
            tbl_questions_answers.id,
            tbl_questions.id as question_id, 
            max(tbl_questions.name) as name, 
            CONCAT('[', GROUP_CONCAT(CONCAT(tbl_answers.id)), ']') as answer 
            -- CONCAT('[', GROUP_CONCAT(CONCAT('\"', tbl_answers.id , '\"')), ']') as answer 
            FROM 
            tbl_questions INNER JOIN tbl_questions_answers 
            ON tbl_questions.id = tbl_questions_answers.question_id 
            INNER JOIN tbl_answers 
            ON tbl_questions_answers.answer_id = tbl_answers.id 
            GROUP BY tbl_questions.id";            

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->execute();

            return $stmt;
        }
        
        public function getCheckanswer(){
            $sqlQuery = "SELECT
                        id,
                        question_id,
                        answer_id
                      FROM
                        ". $this->db_table ."
                    WHERE 
                        answer_id = $this->answer_id
                        and question_id = $this->question_id
                        LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

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

        // UPDATE
        public function updateType(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        Name = :Name, 
                    WHERE 
                        TypeID = :TypeID";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->Name=htmlspecialchars(strip_tags($this->Name));
        
            // bind data
            $stmt->bindParam(":Name", $this->Name);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteType(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE TypeID = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->TypeID=htmlspecialchars(strip_tags($this->TypeID));
        
            $stmt->bindParam(1, $this->TypeID);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
