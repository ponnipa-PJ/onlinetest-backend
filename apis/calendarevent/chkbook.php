<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header('Access-Control-Allow-Methods, GET');

    include_once '../../config/database.php';
    include_once '../../class/calendarevent.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Calendarevent($db);

    // $items->CE_StartDate = isset($_GET['start']) ? $_GET['start'] : die();
    // $items->CE_EndDate = isset($_GET['end']) ? $_GET['end'] : die();

    $startdate = isset($_GET['start']) ? $_GET['start'] : die();
    $enddate = isset($_GET['end']) ? $_GET['end'] : die();
    $enddate1 = isset($_GET['start']) ? $_GET['start'] : die();
    date_default_timezone_set('UTC');	
    
    $productArr = array();
    $productArr["body"] = array();
    $e = array();
    $i = 1;
	while (strtotime($startdate) <= strtotime($enddate))
	{
        $items->CE_StartDate = $startdate;
        $items->CE_EndDate = $enddate1;
        $stmt = $items->getBookcalendarevent();
        $itemCount = $stmt->rowCount();
        
        if($itemCount > 0){ 
    
            $productArr["itemCount"] = $itemCount;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    // "Event_ID" => $Event_ID,
                    // "CE_StartDate" => $CE_StartDate,
                    // "CE_EndDate" => $CE_EndDate,
                    // "CE_Title" => $CE_Title,
                    // "CE_Descript" => $CE_Descript,
                    // "RoomID" => $RoomID,
                    // "szState" => $szState,
                    "RoomID" => $RoomID,
                    "RoomName" => $RoomName,
                    "RoomType" => $RoomType,
                );
                // echo var_dump($e);
                // $result = array_intersect($e, $productArr["body"]);
                // echo $result;
                array_push($productArr["body"], $e);
            }
            
        }
		$startdate = date ("Y-m-d", strtotime("+1 day", strtotime($startdate)));
        $enddate1 = date("Y-m-d", strtotime("+1 day", strtotime($enddate)));
		
	}
    if ($productArr != []) {
        $result = json_encode($productArr["body"]);
        echo $result;
        // array_push($productArr["body"], $result);
        // echo json_encode($productArr["body"]);
    }else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
    // echo json_encode($itemCount);

    
?>