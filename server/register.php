<?php
/*
 * 注册
 */
include 'common.php';
header("content-Type: text/html; charset=utf-8");
// 测试暂时使用get请求
// 获取用户名密码
$username = isset($_GET['username'])?$_GET['username']:'';
$password = isset($_GET['password'])?$_GET['password']:'';

$commonObj = new common();
if (empty($username)) {
    $commonObj->response(1,'','Accounts cant be empty!');
}
if (empty($password)) {
    $commonObj->response(1,'','Password cannot be empty!');
}
if (strlen($password) < 6) {
    $commonObj->response(1,'','Password length should not be less than 6 bits!');
}
$file = '../database/users.json';
// 读取数据文件
if (!file_exists($file)) {
    $commonObj->response(1,'','Data file does not exist!');
}
$user_json = file_get_contents($file);
// 无用户时
if(!$user_json){
    $user_json = [
        [
            'id'=>1,
            'username'=>$username,
            'password'=>$password
        ]
    ];
} else{
    $user_json = json_decode(file_get_contents($file),true);
    // 取出来最后一个数据
    $last_user = end($user_json);
    $user_info = [
        'id' => $last_user['id'] + 1,
        'username' => $username,
        'password' => $password
    ];
    array_push($user_json, $user_info);
}
// 写入文件
$result = file_put_contents('../database/users.json',json_encode($user_json));
if ($result) {
    echo "<script>alert('login was successful');</script>";
    $url = '../client/login.html';
    echo "<script>window.location.href='$url';</script>";die;
}
echo "<script>alert('login has failed');</script>";
$url = '../client/register.html';
echo "<script>window.location.href='$url';</script>";die;