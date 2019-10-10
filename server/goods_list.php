<?php
/*
 * 商品列表
 */
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
// 读取数据文件
$file = '../database/goods_list.json';

if (!file_exists($file)) {
    $commonObj->response(1, '', '数据文件不存在！');
}
$goods_json = file_get_contents($file);
if (!empty($goods_json)) {
    $goods_json = json_decode($goods_json, true);
}
$user_info = $_SESSION['user_info'];
$user_id = $user_info['id'];
echo $user_id;die;
include '../client/shop_list.html';