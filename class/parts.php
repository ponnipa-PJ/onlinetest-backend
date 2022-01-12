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
?>