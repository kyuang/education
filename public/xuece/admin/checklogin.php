<?php 
//验证登陆页面
//1.接收表单传递过来的用户名和密码
$userNmae = isset($_POST['username']) ? $_POST['username'] : '';
$passWord = isset($_POST['password']) ? $_POST['password'] : '';
//2.去除字符串前后的空白字符
$userNmae = trim($userNmae);
$passWord = trim($passWord);
//3.判断是否为空
if(empty($userNmae) || empty($passWord)){
	header("Refresh:1;url=./login.php");
	die('用户名或密码不能为空');
} 
//4.通过用户名获取当条数据
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao=DAOMySQLi::getSingleton($options);
$sql="set names utf8";
$dao->query($sql);
$sql="select * from admin where name = '{$userNmae}'";
$row = $dao->fetchOne($sql);
//有数据说明有此用户
if($row){
    if($row['password']==md5($passWord)){
        //登录成功
        session_start();
        $_SESSION['username']=$userNmae;
        header("refresh:0,./index.php");
    }else{
        header("refresh:1,./login.php");
        die('密码无效，请重试');
    }
}else{
	header("Refresh:1;url=./login.php");
	die('用户名错误!');
}
 ?>