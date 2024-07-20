<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Headers, Authorization, X-Request-With, Access-Control-Allow-Method");

include "../../config/initialize.php";

$room = new Room($db);
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST':
        $data = (empty($input)) ? $room->insertRoom($_POST) : $user->insertRoom($input);
        echo $data;
        break;
    default:
        $data = [
            "code" => 0,
            "status" => 405,
            "msg" => "{$method} Method Not Allowed."
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
        break;
}
