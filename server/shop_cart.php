<?php
/*
 * 商品购物车
 */
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
// 获取用户id
// $user_id = isset($_GET['id']) ? $_GET['id'] : '';
$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
// 添加到购物车
// $user_info = $_SESSION['user_info'];
// $user_id = $user_info['id'];
$goods_id = 1;
$user_id = 11;
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
// 如果购物车数据不为空
$shop_cart_json = json_decode($shop_cart_json, true);
// 获取当前用户的购物车
foreach ($shop_cart_json as $index => $item) {
    // 如果用户购物车数据存在
    if ($item['id'] == $user_id) {
        // $commonObj->response(1, $item, '购物车信息获取成功！');
        $shop_cart_json = [];
        array_push($shop_cart_json, $item);
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
