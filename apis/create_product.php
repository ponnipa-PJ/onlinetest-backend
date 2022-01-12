<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);

    include_once '../config/database.php';
    include_once '../class/product.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Product($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->Url = $data->Url;
    $item->TypeD = $data->TypeD;
    $item->Name = $data->Name;
    $item->Category = $data->Category;
    $item->Information = $data->Information;
    $item->Detail = $data->Detail;
    $item->Fda = $data->Fda;
    $item->StatusID = $data->StatusID;
    
    if($item->createProduct()){
        echo 0;
    } else{
        echo 'Product could not be created.';
    }
?>