<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../../config/database.php';
    include_once '../../class/calendarevent.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Calendarevent($db);

    $stmt = $items->getCalendarevent();
    $itemCount = $stmt->rowCount();


    // echo json_encode($itemCount);

    if($itemCount > 0){
        
        $productArr = array();
        $productArr["body"] = array();
        $productArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "Event_ID" => $Event_ID,
                "CE_StartDate" => $CE_StartDate,
                "CE_EndDate" => $CE_EndDate,
                "CE_Title" => $CE_Title,
                "CE_Descript" => $CE_Descript,
                "RoomID" => $RoomID,
                "szState" => $szState,
            );

            array_push($productArr["body"], $e);
        }
        echo json_encode($productArr["body"]);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>