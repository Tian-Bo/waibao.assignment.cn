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
    $commonObj->response(1,'','账号不能为空！');
}
if (empty($password)) {
    $commonObj->response(1,'','密码不能为空！');
}
if (strlen($password) < 6) {
    $commonObj->response(1,'','密码长度不能小于6位！');
}
$file = '../database/users.json';
// 读取数据文件
if (!file_exists($file)) {
    $commonObj->response(1,'','数据文件不存在！');
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
    echo "<script>alert('注册成功');</script>";
    // 两秒后跳转页面
    sleep(2);
    header('location:../client/login.html');die;
}
echo "<script>alert('注册失败');</script>";
sleep(2);
header('location:../client/register.html');die;