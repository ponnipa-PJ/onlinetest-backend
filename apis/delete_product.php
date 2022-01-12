<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Access-Control-Allow-Credentials', true);
    header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
    
    include_once '../config/database.php';
    include_once '../class/product.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Product($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->ProductID = isset($_GET['ProductID']) ? $_GET['ProductID'] : die();

    // $item->id = $data->id;
    
    if($item->deleteProduct()){
        echo 0;
    } else{
        echo json_encode("Product could not be deleted");
    }
?>