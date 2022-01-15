<?php
    class Part{

        // Connection
        private $conn;

        // Table
        private $db_table = "tbl_parts";

        // Columns
        public $id;
        public $name;
        public $score;
        public $date;
        public $time;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getParts(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createPart(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET                        
                        name = :name,
                        score = :score,
                        date = :date,
                        time = :time";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->score=htmlspecialchars(strip_tags($this->score));
            $this->date=htmlspecialchars(strip_tags($this->date));
            $this->time=htmlspecialchars(strip_tags($this->time));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":score", $this->score);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":time", $this->time);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleType(){
            $sqlQuery = "SELECT
                        TypeID,                        
                        Name
                      FROM
                        ". $this->db_table ."
                    WHERE 
                    TypeID = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->TypeID);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
        }     

        public function getPartsBySubjectID(){
            $sqlQuery = "SELECT
                        *
                      FROM
                        ". $this->db_table ."
                    WHERE 
                        subject_id = $this->subject_id
                        AND status = 1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->subject_id);

            $stmt->execute();

            return $stmt;
        }
        
        // UPDATE
        public function updatePart(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        score = :score, 
                        date = :date, 
                        time = :time, 
                        subject_id = :subject_id
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->score=htmlspecialchars(strip_tags($this->score));
            $this->date=htmlspecialchars(strip_tags($this->date));
            $this->time=htmlspecialchars(strip_tags($this->time));
            $this->subject_id=htmlspecialchars(strip_tags($this->subject_id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":score", $this->score);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":time", $this->time);
            $stmt->bindParam(":subject_id", $this->subject_id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deletePart(){
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