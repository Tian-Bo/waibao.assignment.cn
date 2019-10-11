<?php
session_start();
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
$user_id = $_SESSION['user_info']['id'];
$goods_id = isset($_GET['goods_id'])?$_GET['goods_id']:'';
$result = $commonObj->removeCartGoods($user_id,$goods_id);