<?php

class Room
{
    private $connection;
    private $table = "room";

    public function __construct($db)
    {
        $this->connection = $db;
    }
    public function error422($msg)
    {
        $data = [
            "code" => 0,
            "status" => 422,
            "msg" => $msg,
            "data" => null
        ];
        header("HTTP/1.0 422 $msg");
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function insertRoom($data)
    {
        $title = htmlspecialchars($data["title"]);
        $description = htmlspecialchars($data["description"]);
        $category_id = htmlspecialchars($data["category_id"]);
        $price = htmlspecialchars($data["price"]);
        $status = htmlspecialchars($data["status"]);
        $scale = htmlspecialchars($data["scale"]);
        $images = htmlspecialchars($data["images"]);

        if (empty(trim($title)) || empty(trim($description)) || empty(trim($category_id)) || empty(trim($price)) || empty(trim($scale)) || empty(trim($images))) {
            return $this->error422("Please input all fields required.");
        } else {
            try {
                $query = "INSERT INTO {$this->table} (title,description,category_id,price,status,scale,images) VALUES (?,?,?,?,?,?,?)";
                $stmt = $this->connection->prepare($query);
                $stmt->execute([$title, $description, $category_id, $price, $status, $scale, $images]);
                $createdAt = date('Y-m-d H:i:s');
                $data = [
                    "code" => 1,
                    "status" => 201,
                    "msg" => "Room Added Successfully",
                    "data" => [
                        "id" => $this->connection->lastInsertId(),
                        "title" => $title,
                        "description" => $description,
                        "category_id" => $category_id,
                        "price" => $price,
                        "status" => $status,
                        "scale" => $scale,
                        "images" => $images,
                        "created_at" => $createdAt
                    ]
                ];

                header("HTTP/1.0 201 Suuess");
                echo json_encode($data, JSON_PRETTY_PRINT);
            } catch (PDOException $e) {
                $data = [
                    "code" => 0,
                    "status" => 500,
                    "msg" => "Internal Server Error: {$e->getMessage()}",
                    "data" => null
                ];

                header("HTTP/1.0 500 Suuess");
                echo json_encode($data, JSON_PRETTY_PRINT);
            }
        }
    }

    public function readAllRoom()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
