<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/product.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Product($db);

    $item->Url = isset($_GET['Url']) ? $_GET['Url'] : die();
    $item->getUrlProduct();

    if($item->Name != null){
        // create array
        $emp_arr = array(
                "ProductID" => $item->ProductID,
                "Url" => $item->Url,
                "TypeID" => $item->TypeID,
                "Name" => $item->Name,
                "Category" => $item->Category,
                "Information" => $item->Information,
                "Detail" => $item->Detail,
                "Fda" => $item->Fda,
                "StatusID" => $item->StatusID
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Url not found.");
    }
?>