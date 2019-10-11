<?php
/*
 * 商品购物车
 */
session_start();
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
$user_id = $_SESSION['user_info']['id'];
if (empty($user_id)) {
    $commonObj->response(1, '', '用户ID不能为空');
}
// 读取数据文件
$file = '../database/shop_cart.json';

if (!file_exists($file)) {
    $commonObj->response(1, '', '数据文件不存在');
}

$shop_cart_json = file_get_contents($file);
// // 如果购物车数据为空
// if (empty($shop_cart_json)) {
//     $shop_cart_json = [];
//     $cart_data = [
//         'id' => $user_id,
//         'goods_list' => []
//     ];
//     array_push($shop_cart_json, $cart_data);
//     // 将购物车信息写入文件
//     $result = file_put_contents($file,json_encode($shop_cart_json));
//     if($result){
//         $commonObj->response(0, $cart_data, '获取购物车信息成功！');
//     }
// }

// 读取商品列表数据
$goods_file = '../database/goods_list.json';
if (file_exists($goods_file)) {
    $goods_data = json_decode(file_get_contents($goods_file), true);
}
// 循环重组数据
$goods_list = [];
foreach ($goods_data as $index => $item) {
    $goods_list[$item['id']] = $item;
}
// 如果购物车数据不为空
$shop_cart_json = json_decode($shop_cart_json, true);

//var_dump($shop_cart_json);die;
if ($shop_cart_json == [] || $shop_cart_json == []) {
    echo "<script>alert('购物车信息为空！请先添加');</script>";
    echo "<script>window.location.href='goods_list.php';</script>";
    die;
}
// 获取当前用户的购物车
foreach ($shop_cart_json as $index => $item) {
    // 如果用户购物车数据存在
    if ($item['id'] == $user_id) {
        // 循环遍历商品列表
        $goods_total_num = 0;
        $goods_total_price = 0;
        foreach ($item['goods_list'] as $key => $value) {
            $shop_cart_json[$index]['goods_list'][$key]['goods_info'] = $goods_list[$value['goods_id']];
            $goods_total_price = $goods_total_price + $goods_list[$value['goods_id']]['price'] * $value['number'];
            $goods_total_num = $goods_total_num + $value['number'];
        }
        $shop_mall_json = $shop_cart_json[$index];
    }
}

// 读取数据文件
$file = '../database/goods_list.json';

if (!file_exists($file)) {
    $commonObj->response(1, '', '数据文件不存在！');
}
$goods_json = file_get_contents($file);
if (!empty($goods_json)) {
    $goods_json = json_decode($goods_json, true);
}
// // 如果购物车中没有找见用户购物车 新增数据
// $cart_data = [
//     'id' => $user_id,
//     'goods_list' => []
// ];
// array_push($shop_cart_json, $cart_data);
// $result = file_put_contents($file, json_encode($shop_cart_json));
// if ($result) {
//     $commonObj->response(1, $cart_data, '购物车信息获取成功！');
// }
include '../client/my_mall.html';
