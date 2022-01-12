<?php
    class Product{

        // Connection
        private $conn;

        // Table
        private $db_table = "tbl_product";

        // Columns
        public $ProductID;
        public $Url;
        public $TypeID;
        public $Name;
        public $Category;
        public $Information;
        public $Detail;
        public $Fda;
        public $StatusID;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getProduct(){
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createProduct(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        Url = :Url, 
                        TypeID = :TypeID, 
                        Name = :Name, 
                        Category = :Category, 
                        Information = :Information,
                        Detail = :Detail,
                        Fda = :Fda,
                        StatusID = :StatusID";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->Url=htmlspecialchars(strip_tags($this->Url));
            $this->TypeID=htmlspecialchars(strip_tags($this->TypeID));
            $this->Name=htmlspecialchars(strip_tags($this->Name));
            $this->Category=htmlspecialchars(strip_tags($this->Category));
            $this->Information=htmlspecialchars(strip_tags($this->Information));
            $this->Detail=htmlspecialchars(strip_tags($this->Detail));
            $this->Fda=htmlspecialchars(strip_tags($this->Fda));
            $this->StatusID=htmlspecialchars(strip_tags($this->StatusID));
        
            // bind data
            $stmt->bindParam(":Url", $this->Url);
            $stmt->bindParam(":TypeID", $this->TypeID);
            $stmt->bindParam(":Name", $this->Name);
            $stmt->bindParam(":Category", $this->Category);
            $stmt->bindParam(":Information", $this->Information);
            $stmt->bindParam(":Detail", $this->Detail);
            $stmt->bindParam(":Fda", $this->Fda);
            $stmt->bindParam(":StatusID", $this->StatusID);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleProduct(){
            $sqlQuery = "SELECT
                        ProductID,
                        Url, 
                        TypeID, 
                        Name, 
                        Category, 
                        Information, 
                        Detail, 
                        Fda, 
                        StatusID
                      FROM
                        ". $this->db_table ."
                    WHERE 
                        ProductID = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->ProductID);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->Url = $dataRow['Url'];
            $this->TypeID = $dataRow['TypeID'];
            $this->Name = $dataRow['Name'];
            $this->Category = $dataRow['Category'];
            $this->Information = $dataRow['Information'];
            $this->Detail = $dataRow['Detail'];
            $this->Fda = $dataRow['Fda'];
            $this->StatusID = $dataRow['StatusID'];
        }  
        
        // READ Url
        public function getUrlProduct(){
            $sqlQuery = "SELECT
                        ProductID,
                        Url, 
                        TypeID, 
                        Name, 
                        Category, 
                        Information, 
                        Detail, 
                        Fda, 
                        StatusID
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       Url = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->Url);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->ProductID = $dataRow['ProductID'];
            $this->TypeID = $dataRow['TypeID'];
            $this->Name = $dataRow['Name'];
            $this->Category = $dataRow['Category'];
            $this->Information = $dataRow['Information'];
            $this->Detail = $dataRow['Detail'];
            $this->Fda = $dataRow['Fda'];
            $this->StatusID = $dataRow['StatusID'];
        }  

        // UPDATE
        public function updateProduct(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        Url = :Url, 
                        TypeID = :TypeID, 
                        Name = :Name, 
                        Category = :Category, 
                        Information = :Information,
                        Detail = :Detail,
                        Fda = :Fda,
                        StatusID = :StatusID
                    WHERE 
                        ProductID = :ProductID";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->Url=htmlspecialchars(strip_tags($this->Url));
            $this->TypeID=htmlspecialchars(strip_tags($this->TypeID));
            $this->Name=htmlspecialchars(strip_tags($this->Name));
            $this->Category=htmlspecialchars(strip_tags($this->Category));
            $this->Information=htmlspecialchars(strip_tags($this->Information));
            $this->Detail=htmlspecialchars(strip_tags($this->Detail));
            $this->Fda=htmlspecialchars(strip_tags($this->Fda));
            $this->StatusID=htmlspecialchars(strip_tags($this->StatusID));
        
            // bind data
            $stmt->bindParam(":Url", $this->Url);
            $stmt->bindParam(":TypeID", $this->TypeID);
            $stmt->bindParam(":Name", $this->Name);
            $stmt->bindParam(":Category", $this->Category);
            $stmt->bindParam(":Information", $this->Information);
            $stmt->bindParam(":Detail", $this->Detail);
            $stmt->bindParam(":Fda", $this->Fda);
            $stmt->bindParam(":StatusID", $this->StatusID);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteProduct(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE ProductID = ?";
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