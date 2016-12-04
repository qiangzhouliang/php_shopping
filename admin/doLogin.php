<?php
require_once '../include.php';
$username = @$_POST['username'];
//转义，防止sql注入
$username = @mysql_escape_string($username);
$password = @md5($_POST['password']);
$verify = @$_POST['verify'];
$verify1 = @$_SESSION['verify'];
$autoFlag = @$_POST['autoFlag'];
//判断验证码是否正确
if ($verify == $verify1){
    $sql = "select * from imooc_admin where username='{$username}' and password='{$password}'";
    $row = checkAdmin($sql);
    if ($row){
        //如果选了一周内自动登录
        if ($autoFlag){
            setcookie("adminId",$row['id'],time()+7*24*3600);
            setcookie("adminName",$row['username'],time()+7*24*3600);
        }
        $_SESSION['adminName'] = $row['username'];
        $_SESSION['adminId']=$row['id'];
        //跳转到主页
        //header("location:index.php");
        alertMes("登录成功", 'index.php');
    }else {
        alertMes("登录失败，重新登录", 'login.php');
    }
}else {
    alertMes("验证码错误", "login.php");
}












