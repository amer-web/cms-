<?php


namespace App\Helper;

trait ResponseMessages
{
    public function msgError($msg, $errNum)
    {
        return response()->json([
            'status' => false,
            "errNum" => $errNum,
            'msg' => $msg
        ]);
    }
    public function msgSuccess($msg)
    {
        return response()->json([
            'status' => true,
            "successNum" => 200,
            'msg' => $msg
        ]);
    }
    public function returnDate($key, $data, $msg)
    {
            return response()->json([
                'status' => true,
                "successNum" => 200,
                'msg' => $msg ,
                $key => $data,
            ]);
    }
}
