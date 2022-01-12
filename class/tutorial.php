<?php
    class Tutorial{

        // Connection
        private $conn;

        // Table
        private $db_table = "tutorials";

        // Columns
        public $id;
        public $title;
        public $description;
        public $published;
        public $createdAt;
        public $updatedAt;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getTutorial(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createTutorial(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        title = :title, 
                        description = :description, 
                        published = :published, 
                        createdAt = :createdAt,
                        updatedAt = :updatedAt";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->published=htmlspecialchars(strip_tags($this->published));
            $this->createdAt=htmlspecialchars(strip_tags($this->createdAt));
            $this->updatedAt=htmlspecialchars(strip_tags($this->updatedAt));
        
            // bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":published", $this->published);
            $stmt->bindParam(":createdAt", $this->createdAt);
            $stmt->bindParam(":updatedAt", $this->updatedAt);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function gettitleTutorial(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE title LIKE '%$this->title%'";
            echo $sqlQuery;
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->title);
            $stmt->execute();
            return $stmt;
        }  

         // READ single
         public function getidTutorial(){
            $sqlQuery = "SELECT
                        id,
                        title,
                        description,
                        published,
                        createdAt,
                        updatedAt
                      FROM
                        ". $this->db_table ."
                    WHERE 
                        id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id=$dataRow['id'];
            $this->title=$dataRow['title'];
            $this->description=$dataRow['description'];
            $this->published=$dataRow['published'];
            $this->createdAt=$dataRow['createdAt'];
            $this->updatedAt=$dataRow['updatedAt'];
        } 
        
        // UPDATE
        public function updateTutorial(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        title = :title, 
                        description = :description, 
                        published = :published, 
                        updatedAt = :updatedAt
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->published=htmlspecialchars(strip_tags($this->published));
            $this->updatedAt=htmlspecialchars(strip_tags($this->updatedAt));
            $this->id=htmlspecialchars(strip_tags($this->id));

            // bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":published", $this->published);
            $stmt->bindParam(":updatedAt", $this->updatedAt);
            $stmt->bindParam(":id", $this->id);

        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteTutorial(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        // DELETE ALL
        function deleteallTutorial(){
            $sqlQuery = "DELETE FROM " . $this->db_table;
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