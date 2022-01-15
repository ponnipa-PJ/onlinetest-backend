<?php
    class Question{

        // Connection
        private $conn;

        // Table
        private $db_table = "tbl_questions";

        // Columns
        public $id;
        public $name;
        public $description;
        public $part_id;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getQuestions(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createQuestion(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET                        
                        name = :name,
                        description = :description,
                        subject_id = :subject_id,
                        part_id = :part_id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->part_id=htmlspecialchars(strip_tags($this->part_id));
            $this->subject_id=htmlspecialchars(strip_tags($this->subject_id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":part_id", $this->part_id);
            $stmt->bindParam(":subject_id", $this->subject_id);
        
            if($stmt->execute()){
                return $this->conn->lastInsertId();
            }
            return false;
        }

        // READ single
        public function getSingleID(){
            $sqlQuery = "SELECT
                        name,                        
                        description,
                        part_id
                      FROM
                        ". $this->db_table ."
                    WHERE 
                    id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->description = $dataRow['description'];
            $this->part_id = $dataRow['part_id'];
        }        

        // UPDATE
        public function updateQuestion(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                    name = :name,
                    description = :description,
                    part_id = :part_id
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->part_id=htmlspecialchars(strip_tags($this->part_id));
        
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":part_id", $this->part_id);

            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteType(){
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
?>