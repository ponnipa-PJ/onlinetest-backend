<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);

    include_once '../../config/database.php';
    include_once '../../class/calendarevent.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Calendarevent($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->CE_StartDate=$data->CE_StartDate;
    $item->CE_EndDate=$data->CE_EndDate;
    $item->CE_Title=$data->CE_Title;
    $item->CE_Descript=$data->CE_Descript;
    $item->RoomID=$data->RoomID;
    $item->szState=$data->szState;
    
    if($item->createCalendarevent()){
        echo 0;
    } else{
        echo 'Product could not be created.';
    }
?>