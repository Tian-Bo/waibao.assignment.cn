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
        $url = 'shop_cart.php';
        if (file_exists($file)) {
            $goods_json = file_get_contents($file);
            // 当前数据文件中数据为空
            if (empty($goods_json)) {
                $goods_json = [];
                $user_goods_json = [
                    'id' => $user_id,
                    'goods_list' => [[
                        'goods_id' => $goods_id,
                        'number' => 1,
                    ]],
                ];
                array_push($goods_json, $user_goods_json);
                $result = file_put_contents($file, json_encode($goods_json));
                if ($result) {
                    echo "<script>alert('添加成功1');</script>";
                    echo "<script>window.location.href='$url';</script>";
                    die;
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
                                    echo "<script>alert('添加成功2');</script>";
                                    echo "<script>window.location.href='$url';</script>";
                                    die;
                                }
                            }
                        }
                        // 不存在该商品, 追加该商品进入我的购物车
                        $user_goods_json = [
                            'goods_id' => $goods_id,
                            'number' => 1,
                        ];
                        // 将商品写入用户商品列表
                        array_push($goods_json[$index]['goods_list'], $user_goods_json);
                        // 修改后将数据写入文件
                        $result = file_put_contents($file, json_encode($goods_json));
                        if ($result) {
                            echo "<script>alert('添加成功3');</script>";
                            echo "<script>window.location.href='$url';</script>";
                            die;
                        }
                    }
                }
                // 生成我的购物车 并且插入一件商品
               $user_goods_json = [
                   'id' => $user_id,
                   'goods_list' => [[
                       'goods_id' => $goods_id,
                       'number' => 1,
                   ]],
               ];
               array_push($goods_json, $user_goods_json);
               $result = file_put_contents($file, json_encode($goods_json));
               if ($result) {
                   echo "<script>alert('添加成功4');</script>";
                   echo "<script>window.location.href='$url';</script>";
                   die;
               }


                // // 如果当前商品不存在 创建商品信息
                // $goods_json = [
                //     'goods_id' => $goods_id,
                //     'number' => 1,
                // ];
                // // 将商品写入用户商品列表
                // var_dump($goods_json[$key]);die;
                // array_push(json_decode($goods_json[$key]['goods_list'],true), $goods_json);
                // var_dump($goods_json);die;
                // // 修改后将数据写入文件
                // $result = file_put_contents($file, json_encode($goods_json));
                // if ($result) {
                //     echo "<script>alert('添加成功');</script>";
                //     $url = 'shop_cart.php';
                //     echo "<script>window.location.href='$url';</script>";die;
                // }
            }
        }
    }

    /*
     * 移除购物车商品
     * @param $user_id
     * @param $goods_id
     */
    public function removeCartGoods($user_id, $goods_id)
    {
        // 购物车路径
        $file = '../database/shop_cart.json';
        $url = 'shop_cart.php';

        // 判断文件是否存在
        if (!file_exists($file)) {
            echo "<script>alert('数据文件不存在！');</script>";
            echo "<script>window.location.href='$url';</script>";
            die;
        }
        $cart_json = json_decode(file_get_contents($file), true);
        // 循环遍历用户购物车信息
        foreach ($cart_json as $index => $item) {
            if ($item['id'] == $user_id) {
                // 找到当前用户 遍历商品数据
                foreach ($item['goods_list'] as $key => $value) {
                    if ($value['goods_id'] == $goods_id) {
                        unset($item['goods_list'][$key]);
                        $item['goods_list'] = array_values($item['goods_list']);
                        $cart_json[$index]['goods_list'] = $item['goods_list'];
                        $result = file_put_contents($file, json_encode($cart_json));
                        if ($result) {
                            echo "<script>alert('移除成功');</script>";
                            echo "<script>window.location.href='$url';</script>";
                            die;
                        }
                        echo "<script>alert('移除失败');</script>";
                        echo "<script>window.location.href='$url';</script>";
                        die;

                    }
                }
            }
        }
    }

    // 减去购物车数量
    public function minusGoodsNumber($user_id, $goods_id)
    {
        // 购物车路径
        $file = '../database/shop_cart.json';
        $url = 'shop_cart.php';
        if (file_exists($file)) {
            $goods_json = file_get_contents($file);
            // 当前数据文件中数据为空
            if (empty($goods_json)) {
                $goods_json = [];
                $user_goods_json = [
                    'id' => $user_id,
                    'goods_list' => [[
                        'goods_id' => $goods_id,
                        'number' => 1,
                    ]],
                ];
                array_push($goods_json, $user_goods_json);
                $result = file_put_contents($file, json_encode($goods_json));
                if ($result) {
                    echo "<script>alert('添加成功1');</script>";
                    echo "<script>window.location.href='$url';</script>";
                    die;
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
                                $user_goods_list[$key]['number'] = $value['number'] - 1;
                                $goods_json[$key]['goods_list'] = $user_goods_list;
                                // 修改后将数据写入文件
                                $result = file_put_contents($file, json_encode($goods_json));
                                if ($result) {
                                    echo "<script>alert('success');</script>";
                                    echo "<script>window.location.href='$url';</script>";
                                    die;
                                }
                                echo "<script>alert('fail');</script>";
                                echo "<script>window.location.href='$url';</script>";
                                die;
                            }
                        }
                    }
                }
            }
        }
    }

    /*
     * 生成订单
     * @param $user_id
     * @param $goods_id
     */
    public function createPay($user_id)
    {
        $file = '../database/order.json';
        $cart_file = '../database/shop_cart.json';
        $url = 'shop_cart.php';
        // 根据用户id 获取用户的购物车信息
        if (!file_exists($file)) {
            echo "<script>alert('订单数据文件不存在！');</script>";
            echo "<script>window.location.href='$url';</script>";
            die;
        }

        if (!file_exists($cart_file)) {
            echo "<script>alert('购物车数据文件不存在！');</script>";
            echo "<script>window.location.href='$url';</script>";
            die;
        }

        // 获取购物车信息
        $cart_json = json_decode(file_get_contents($cart_file), true);
        foreach ($cart_json as $index => $item) {
            // 找到当前用户
            if ($item['id'] == $user_id) {
                // 如果当前订单中无数据
                $order_json = file_get_contents($file);
                if (empty($order_json)) {
                    $order_data = [];
                    array_push($order_data, $item);
                    // 向订单数据中写入数据
                    $result = file_put_contents($file, json_encode($order_data));
                    if ($result) {
                        // 成功之后 移除用户购物车信息
                        unset($cart_json[$index]['goods_list']);
                        $cart_json[$index]['goods_list'] = [];
                        $cart_json[$index]['card'] = [];
                        $cart_json = array_values($cart_json);
                        file_put_contents($cart_file, json_encode($cart_json));
                        echo "<script>alert('订单创建成功！');</script>";
                        echo "<script>window.location.href='$url';</script>";
                        die;
                    }
                    echo "<script>alert('订单创建失败！');</script>";
                    echo "<script>window.location.href='$url';</script>";
                    die;
                } else {
                    $order_json = json_decode($order_json, true);
                    array_push($order_json, $item);
                    // 向订单数据中写入数据
                    $result = file_put_contents($file, json_encode($order_json));
                    if ($result) {
                        // 成功之后 移除用户购物车信息
                        unset($cart_json[$index]['goods_list']);
                        $cart_json[$index]['goods_list'] = [];
                        $cart_json[$index]['card'] = [];
                        file_put_contents($cart_file, json_encode($cart_json));
                        echo "<script>alert('订单创建成功！');</script>";
                        echo "<script>window.location.href='$url';</script>";
                        die;
                    }
                    echo "<script>alert('订单创建失败！');</script>";
                    echo "<script>window.location.href='$url';</script>";
                    die;
                }
            }
        }
    }
}