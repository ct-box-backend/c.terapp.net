<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Headers, Authorization, X-Request-With, Access-Control-Allow-Method");

include "../../config/initialize.php";

$room = new Room($db);
$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    $data = $room->updateRoom($_POST);
    echo $data;
} else {
    $data = [
        "code" => 0,
        "status" => 405,
        "msg" => "{$method} Method Not Allowd",
        "data" => null,
    ];
    echo json_encode($data, JSON_PRETTY_PRINT);
}




?>