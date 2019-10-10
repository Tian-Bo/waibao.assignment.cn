<?php
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();

// 获取商品id
$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] : '';
// 添加到购物车
$user_info = $_SESSION['user_info'];
$user_id = $user_info['id'];
// $goods_id = 1;
// $user_id = 11;
echo $user_id;die;
// $result = $commonObj->addCart($user_id, $goods_id);
// echo $result;
// die;
