<?php

class Msg
{
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

    public function error500($msg)
    {
        $data = [
            "code" => 0,
            "status" => 500,
            "msg" => $msg,
            "data" => null
        ];
        header("HTTP/1.0 500 $msg");
        return json_encode($data, JSON_PRETTY_PRINT);
    }
    public function error405($msg)
    {
        $data = [
            "code" => 0,
            "status" => 405,
            "msg" => $msg,
            "data" => null
        ];
        header("HTTP/1.0 405 $msg");
        return json_encode($data, JSON_PRETTY_PRINT);
    }

    public function success($msg, $response)
    {
        $data = [
            "code" => 1,
            "status" => 200,
            "msg" => $msg,
            "data" => $response,
        ];
        header("HTTP/1.0 200 $msg");
        return json_encode($data, JSON_PRETTY_PRINT);
    }
}
