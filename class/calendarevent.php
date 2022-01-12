<?php
class Calendarevent
{

    // Connection
    public $conn;

    // Table
    private $db_table = "tblcalendarevent";

    // Columns
    public $Event_ID;
    public $CE_StartDate;
    public $CE_EndDate;
    public $CE_Title;
    public $CE_Descript;
    public $RoomID;
    public $szState;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function getCalendarevent()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function getBookcalendarevent()
    {
        $sqlQuery = "SELECT
                                                tblrooms.RoomID,
                                                tblrooms.RoomName,
                                                tblrooms.RoomType
                                                FROM
                                                tblrooms
                                                WHERE tblrooms.roomID NOT IN (SELECT tblrooms.RoomID FROM tblrooms
                                                INNER JOIN tblcalendarevent ON tblrooms.RoomID =tblcalendarevent.RoomID
                                                WHERE NOT('$this->CE_EndDate' <  CE_StartDate OR '$this->CE_StartDate' > CE_EndDate))";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->CE_StartDate);

        $stmt->execute();

        return $stmt;
    }

    // CREATE
    public function createCalendarevent()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET                        
                        CE_StartDate = :CE_StartDate,
                        CE_EndDate = :CE_EndDate,
                        CE_Title = :CE_Title,
                        CE_Descript = :CE_Descript,
                        RoomID = :RoomID,
                        szState = :szState";

        $stmt = $this->conn->prepare($sqlQuery);

        // sanitize
        $this->CE_StartDate = htmlspecialchars(strip_tags($this->CE_StartDate));
        $this->CE_EndDate = htmlspecialchars(strip_tags($this->CE_EndDate));
        $this->CE_Title = htmlspecialchars(strip_tags($this->CE_Title));
        $this->CE_Descript = htmlspecialchars(strip_tags($this->CE_Descript));
        $this->RoomID = htmlspecialchars(strip_tags($this->RoomID));
        $this->szState = htmlspecialchars(strip_tags($this->szState));

        // bind data
        $stmt->bindParam(":CE_StartDate", $this->CE_StartDate);
        $stmt->bindParam(":CE_EndDate", $this->CE_EndDate);
        $stmt->bindParam(":CE_Title", $this->CE_Title);
        $stmt->bindParam(":CE_Descript", $this->CE_Descript);
        $stmt->bindParam(":RoomID", $this->RoomID);
        $stmt->bindParam(":szState", $this->szState);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ single
    public function getSingleCalendarevent()
    {
        $sqlQuery = "SELECT
                        Event_ID,
                        CE_StartDate,
                        CE_EndDate,
                        CE_Title,
                        CE_Descript,
                        RoomID,
                        szState
                      FROM
                        " . $this->db_table . "
                    WHERE 
                        DictID = ?
                    LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->Event_ID = $dataRow['Event_ID'];
        $this->CE_StartDate = $dataRow['CE_StartDate'];
        $this->CE_EndDate = $dataRow['CE_EndDate'];
        $this->CE_Title = $dataRow['CE_Title'];
        $this->CE_Descript = $dataRow['CE_Descript'];
        $this->RoomID = $dataRow['RoomID'];
        $this->szState = $dataRow['szState'];
    }

    // UPDATE
    public function updateCalendarevent()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        RoomID = :RoomID,
                    WHERE 
                        Event_ID = :Event_ID";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->RoomID = htmlspecialchars(strip_tags($this->RoomID));

        // bind data
        $stmt->bindParam(":RoomID", $this->RoomID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteCalendarevent()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE Event_ID = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->Event_ID));

        $stmt->bindParam(1, $this->Event_ID);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
