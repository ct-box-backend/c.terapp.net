<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: POST");

include "../../config/initialize.php";

$room = new Room($db);

if (isset($_POST["id"])) {
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
        $room->readById();
        $data = [
            "code" => 1,
            "status" => 200,
            "msg" => "Successfully",
            "data" => [
                "id" => $room->id,
                "title" => $room->title,
                "description" => $room->description,
                "category_id" => $room->category_id,
                "price" => $room->price,
                "status" => $room->status,
                "scale" => $room->scale,
                "images" => $room->images,
                "created_at" => $room->created_at,
            ]
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
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
