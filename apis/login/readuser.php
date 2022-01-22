<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Methods: Content-Type');
header('Content-Type: application/json; charset=UTF8');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

include_once '../../config/database.php';
include_once '../../class/users.php';

$database = new Database();
$db = $database->getConnection();

$items = new User($db);
$data = json_decode(file_get_contents("php://input"));
if ($data) {
    $items->name = $data->name;
    $items->pass = $data->pass;
    $stmt = $items->getUserlogin();
    $itemCount = $stmt->rowCount();


    if ($itemCount > 0) {

        $productArr = array();
        $productArr["body"] = array();
        $productArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "role" => $role,
            );

            array_push($productArr["body"], $e);
        }
        echo json_encode($productArr["body"]);
    } else {
        http_response_code(404);
        echo json_encode("User not found.");
    }
}
