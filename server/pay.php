<?php
/*
 * 付款
 */
session_start();
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
$user_id = $_SESSION['user_info']['id'];
// 读取数据文件
$file = '../database/shop_cart.json';

if (!file_exists($file)) {
    $commonObj->response(1, '', 'Data file does not exist!');
}
$goods_json = file_get_contents($file);
if (!empty($goods_json)) {
    $goods_json = json_decode($goods_json, true);
}

$cart_json = [];
foreach ($goods_json as $index => $item) {
    // 找到当前用户所有订单
    if ($item['id'] == $user_id) {
        $cart_json = $item;
    }
}

$cart_text = isset($_GET['cart_text']) ? $_GET['cart_text'] : '';

include '../client/pay.html';