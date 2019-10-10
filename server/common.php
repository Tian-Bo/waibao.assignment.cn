<?php

class common
{
    /*
     * 全局返回函数
     */
    public function response($status = 0, $data = [], $message = '')
    {
        $response = [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die;
    }

    /*
     * 添加到购物车
     * @param $user_id
     * @param $goods_id
     */
    public function addCart($user_id, $goods_id)
    {
        $file = '../database/shop_cart.json';
        if (file_exists($file)) {
            $goods_json = file_get_contents($file);
            if (empty($goods_json)) {
                // 当前数据文件中数据为空
                $goods_json = [];
                $user_goods_json = [
                    'id' => $user_id,
                    'goods_list' => [[
                        'goods_id' => $goods_id,
                        'number' => 1,
                    ]],
                ];
                array_push($goods_json, $user_goods_json);
                $cart_file = '../database/shop_cart.json';
                $result = file_put_contents($cart_file, json_encode($goods_json, JSON_UNESCAPED_UNICODE));
                if ($result) {
                    $this->response(0, '', '成功添加到购物车！');
                }
            } else {
                // 当前数据文件不为空
                $goods_json = json_decode($goods_json, true);
                // 循环查找当前用户的购物车
                foreach ($goods_json as $index => $item) {
                    // 找到用户购物车的数据
                    if ($item['id'] == $user_id) {
                        $user_goods_list = $item['goods_list'];
                        // 根据goods_id 判断当前商品是否存在 存在数量加一
                        foreach ($user_goods_list as $key => $value) {
                            if ($value['goods_id'] == $goods_id) {
                                // 数量加一
                                $user_goods_list[$key]['number'] = $value['number'] + 1;
                                $goods_json[$key]['goods_list'] = $user_goods_list;
                                // 修改后将数据写入文件
                                $result = file_put_contents($file, json_encode($goods_json));
                                if ($result) {
                                    return true;
                                }
                                return false;
                            }
                            // 如果当前商品不存在 创建商品信息
                            $goods_json = [
                                'goods_id' => $goods_id,
                                'number' => 1,
                            ];
                            // 将商品写入用户商品列表
                            var_dump($goods_json[$key]);die;
                            array_push(json_decode($goods_json[$key]['goods_list'],true), $goods_json);
                            var_dump($goods_json);die;
                            // 修改后将数据写入文件
                            $result = file_put_contents($file, json_encode($goods_json));
                            if ($result) {
                                return true;
                            }
                            return false;
                        }
                    }
                    // else {
                    //     echo "用户不存在";die;
                    // }
                }
                echo "用户不存在...";die;
            }
        }
    }
}