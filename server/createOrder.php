<?php
session_start();
include 'common.php';
header('Content-type:text/html;charset=utf-8');
$commonObj = new common();
$user_id = $_SESSION['user_info']['id'];
// $card = isset($_GET['card']) ? $_GET['card'] : '';
$result = $commonObj->createPay($user_id, $card);