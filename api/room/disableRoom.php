<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Headers, Authorization, X-Request-With, Access-Control-Allow-Method");

include "../../config/initialize.php";

$room = new Room($db);
$method = $_SERVER['REQUEST_METHOD'];
if (isset($_POST["id"]) && isset($_POST['status'])) {
    if (empty($_POST['id'])) {
        $error = [
            "code" => 0,
            "status" => 204,
            "msg" => "Please Provide a specifid Room ID",
            "data" => null,
        ];
        echo json_encode($error, JSON_PRETTY_PRINT);
    } else {
        $room->id = $_POST["id"];
        $data = $room->updatedStatus((int) $_POST['status']);
        echo $data;
    }
} else {
    $error = [
        "code" => 0,
        "status" => 204,
        "msg" => "Please provide a specific ID",
        "data" => null,
    ];
    echo json_encode($error, JSON_PRETTY_PRINT);
}

?>