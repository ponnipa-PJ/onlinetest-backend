<?php
    class Type{

        // Connection
        private $conn;

        // Table
        private $db_table = "tbl_type";

        // Columns
        public $TypeID;
        public $Name;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getType(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createType(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET                        
                        Name = :Name";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->Name=htmlspecialchars(strip_tags($this->name));
        
            // bind data
            $stmt->bindParam(":Name", $this->Name);
        
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