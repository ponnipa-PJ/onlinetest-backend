<?php
class User
{

    // Connection
    private $conn;

    // Table
    private $db_table = "tbl_user";

    // Columns
    public $id;
    public $name;
    public $password;
    public $role;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getUser()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getUserid()
    {
        $sqlQuery = "SELECT
                        *
                      FROM
                      " . $this->db_table . "
                    WHERE 
                    id = $this->id";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        return $stmt;
    }

    public function getUserlogin()
    {
        $sqlQuery = "SELECT
                        *
                      FROM
                      " . $this->db_table . "
                    WHERE 
                    name = '$this->name'
                    AND password = '$this->pass'";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":pass", $this->pass);
        $stmt->execute();

        return $stmt;
    }

    public function getstu()
    {
        $sqlQuery = "SELECT
                        *
                      FROM
                      " . $this->db_table . "
                    WHERE 
                    role = 1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->execute();

        return $stmt;
    }

    // CREATE
    public function createPart()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET                        
                        name = :name,
                        score = :score,
                        date = :date,
                        time = :time,
                        status = :status,
                        subject_id = :subject_id";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->score = htmlspecialchars(strip_tags($this->score));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":score", $this->score);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":subject_id", $this->subject_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function getSingleType()
    {
        $sqlQuery = "SELECT
                        TypeID,                        
                        Name
                      FROM
                        " . $this->db_table . "
                    WHERE 
                    TypeID = ?
                    LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->TypeID);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $dataRow['name'];
    }

    public function getPartsBySubjectID()
    {
        $sqlQuery = "SELECT
                        *
                      FROM
                        " . $this->db_table . "
                    WHERE 
                        subject_id = $this->subject_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->subject_id);

        $stmt->execute();

        return $stmt;
    }

    public function getPartsBySubjectIDstu()
    {
        $sqlQuery = "SELECT
                        *
                      FROM
                        " . $this->db_table . "
                    WHERE 
                        subject_id = $this->subject_id                        
                        AND status = 1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->subject_id);

        $stmt->execute();

        return $stmt;
    }

    public function getPartsByID()
    {
        $sqlQuery = "SELECT
                        *
                      FROM
                        " . $this->db_table . "
                    WHERE 
                        subject_id = $this->subject_id
                        AND id = $this->part_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->subject_id);
        $stmt->bindParam(1, $this->part_id);

        $stmt->execute();

        return $stmt;
    }

    // UPDATE
    public function updatePart()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        name = :name, 
                        score = :score, 
                        date = :date, 
                        time = :time, 
                        subject_id = :subject_id
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->score = htmlspecialchars(strip_tags($this->score));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->time = htmlspecialchars(strip_tags($this->time));
        $this->subject_id = htmlspecialchars(strip_tags($this->subject_id));

        // bind data
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":score", $this->score);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":time", $this->time);
        $stmt->bindParam(":subject_id", $this->subject_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deletePart()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
