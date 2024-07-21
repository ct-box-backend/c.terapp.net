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

                header("HTTP/1.0 201 Created");
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

    public function readById()
    {

        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row["title"];
        $this->description = $row["description"];
        $this->category_id = $row["category_id"];
        $this->price = $row["price"];
        $this->status = $row["status"];
        $this->scale = $row["scale"];
        $this->images = $row["images"];
        $this->created_at = $row["created_at"];
    }
    public function error($msg, $status)
    {
        $data = [
            "code" => 0,
            "status" => $status,
            "msg" => $msg,
            "data" => null
        ];
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function updateRoom($input)
    {
        $room_id = htmlspecialchars($input["id"]);
        $title = htmlspecialchars($input["title"]);
        $description = htmlspecialchars($input["description"]);
        $category_id = htmlspecialchars($input["category_id"]);
        $price = htmlspecialchars($input["price"]);
        $status = htmlspecialchars($input['status']);
        $scale = htmlspecialchars($input["scale"]);
        $images = htmlspecialchars($input["images"]);
        $updated_at = date('Y-m-d H:i:s');

        # validation

        if (empty(trim($title)) || empty(trim($category_id)) || empty($price) || empty($status) || empty(trim($scale) || empty(trim($images)))) {
            $data = [
                "code" => 0,
                "status" => 403,
                "msg" => "Please fill all required fields.",
                "data" => null,
            ];
            return json_encode($data, JSON_PRETTY_PRINT);
        } else {

            try {
                $query = "UPDATE room SET title=?,description=?,category_id=?,price=?,status=?,scale=?,images=?,updated_at=? WHERE id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->execute([$title, $description, $category_id, $price, $status, $scale, $images, $updated_at, $room_id]);

                $data = [
                    "code" => 1,
                    "status" => 200,
                    "msg" => "Updated Successfully!",
                    "data" => [
                        "id" => $room_id,
                        "title" => $title,
                        "description" => $description,
                        "category_id" => $category_id,
                        "price" => $price,
                        "status" => $status,
                        "scale" => $scale,
                        "images" => $images
                    ]
                ];
                return json_encode($data, JSON_PRETTY_PRINT);
            } catch (Exception $e) {
                $data = [
                    "code" => 0,
                    "status" => 500,
                    "msg" => "Internal Server Error: {$e->getMessage()}",
                    "data" => null,
                ];
                return json_encode($data, JSON_PRETTY_PRINT);
            }
        }

    }
    public function updatedStatus($status)
    {


        $updated_at = date('Y-m-d H:i:s');

        # validation
        if ($status !== 0 && $status !== 1) {
            $data = [
                "code" => 0,
                "status" => 405,
                "msg" => "Please provide a specific status!",
                "data" => null,
            ];
            return json_encode($data, JSON_PRETTY_PRINT);
        } else {
            try {
                // Update only the status and updated_at fields
                $query = "UPDATE {$this->table} SET status=?, updated_at=? WHERE id=?";
                $stmt = $this->connection->prepare($query);
                $stmt->execute([$status, $updated_at, $this->id]);

                // Fetch the updated row to include in the response
                $query = "SELECT * FROM {$this->table} WHERE id = ?";
                $stmt = $this->connection->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $data = [
                    "code" => 1,
                    "status" => 200,
                    "msg" => "Updated Successfully!",
                    "data" => $row,
                ];

                return json_encode($data, JSON_PRETTY_PRINT);
            } catch (PDOException $e) {
                $data = [
                    "code" => 0,
                    "status" => 500,
                    "msg" => "Internal Server Error: {$e->getMessage()}",
                    "data" => null,
                ];
                return json_encode($data, JSON_PRETTY_PRINT);
            }
        }
    }
}
