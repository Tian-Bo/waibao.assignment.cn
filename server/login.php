<?php
/*
 * 登录
 */
include 'common.php';
header("content-Type: text/html; charset=utf-8");
// 获取用户名密码
$username = isset($_GET['username'])?$_GET['username']:'';
$password = isset($_GET['password'])?$_GET['password']:'';

$commonObj = new common();
if (empty($username)) {
    $commonObj->response(1,'','账号不能为空！');
}
if (empty($password)) {
    $commonObj->response(1,'','密码不能为空！');
}
// 从json文件中读取数据
$file = '../database/users.json';
if (file_exists($file)) {
    $user_json = file_get_contents($file);
    if (!$user_json) {
        $commonObj->response(1,'','暂无用户！请先注册！');
    }
    $user_json = json_decode($user_json, true);
    // 循环判断登录
    foreach ($user_json as $index => $item) {
        if ($username == $item['username'] && $password == $item['password']) {
            $commonObj->response(0,'','登录成功！');
        }
    }
    $commonObj->response(1,'','登录失败！');
}
