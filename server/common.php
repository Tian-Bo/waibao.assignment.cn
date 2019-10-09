<?php

class common
{
    /*
     * 全局返回函数
     */
    public function response($status = 0, $data = [], $message = '')
    {
        $response = [
            'status'=>$status,
            'data' => $data,
            'message' => $message
        ];
        echo json_encode($response,JSON_UNESCAPED_UNICODE);die;
    }
}