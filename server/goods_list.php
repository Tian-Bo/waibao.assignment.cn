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
    $commonObj->response(0, $goods_json, '商品信息获取成功！');
}
$commonObj->response(1, [], '暂无商品信息！');