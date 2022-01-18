<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Methods: Content-Type');
    header('Content-Type: application/json; charset=UTF8');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

    include_once '../../config/database.php';
    include_once '../../class/subjects.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Subject($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->name=$data->name;
    $item->code=$data->code;
    
    $stmt = $item->createSubject();

    echo $stmt;
?>