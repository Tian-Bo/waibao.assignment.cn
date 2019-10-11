<?php
/*
 * 商品列表
 */
session_start();
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
// 读取数据文件
$file = '../database/goods_list.json';

if (!file_exists($file)) {
    $commonObj->response(1, '', 'Data file does not exist!');
}
$goods_json = file_get_contents($file);
if (!empty($goods_json)) {
    $goods_json = json_decode($goods_json, true);
}
include '../client/shop_list.html';