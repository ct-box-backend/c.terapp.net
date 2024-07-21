<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Headers, Authorization, X-Request-With, Access-Control-Allow-Method");

include "../../config/initialize.php";

$room = new Room($db);
$result = $room->readAllRoom();
$num = $result->rowCount();


if ($num > 0) {
    $rooms = [
        "code" => 1,
        "status" => 200,
        "msg" => "Successfully!"
    ];

    $rooms['data'] = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $data = [
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "category_id" => $category_id,
            "price" => $price,
            "status" => $status,
            "scale" => $scale,
            "images" => $images,
            "created_at" => $created_at,
        ];
        array_push($rooms["data"], $data);
    }
    header("http/1.0 200 Success");
    echo json_encode($rooms, JSON_PRETTY_PRINT);
} else {
    $rooms = [
        "code" => 1,
        "status" => 200,
        "msg" => "Unsuccessfully!",
        "data" => null
    ];
    header("http/1.0 200 Unsuccessfully");
    echo json_encode($rooms, JSON_PRETTY_PRINT);
}
