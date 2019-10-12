<?php
/*
 * 登录
 */
include 'common.php';
header("content-Type: text/html; charset=utf-8");
// 开启session
session_start();
// 获取用户名密码
$username = isset($_GET['username']) ? $_GET['username'] : '';
$password = isset($_GET['password']) ? $_GET['password'] : '';

$commonObj = new common();
if (empty($username)) {
    $commonObj->response(1, '', 'Accounts cant be empty!');
}
if (empty($password)) {
    $commonObj->response(1, '', 'Password cannot be empty!');
}
// 从json文件中读取数据
$file = '../database/users.json';
if (file_exists($file)) {
    $user_json = file_get_contents($file);
    if (!$user_json) {
        $commonObj->response(1, '', 'No users yet! Please register first!');
    }
    $user_json = json_decode($user_json, true);
    // 循环判断登录
    foreach ($user_json as $index => $item) {
        if ($username == $item['username'] && $password == $item['password']) {
            // 登录成功将用户信息存入session
            $_SESSION['user_info'] = $item;
            echo "<script>alert('Login successfully');</script>";
            $url = 'goods_list.php';
            echo "<script>window.location.href='$url';</script>";die;
        }
    }
    echo "<script>alert('Login failed');</script>";
    $url = '../client/login.html';
    echo "<script>window.location.href='$url';</script>";die;
}
