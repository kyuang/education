<?php require_once "../class/islogin_class.php";?>
<?php
$username=isset($_POST['username'])?$_POST['username']:'';
$password=isset($_POST['password'])?$_POST['password']:'';
$password1=isset($_POST['password1'])?$_POST['password1']:'';
if($username==''){
    header("refresh:1,./admin_add.php");
    die('用户名不能为空');
}
if($password==''){
    header("refresh:1,./admin_add.php");
    die('密码不能为空');
}
if($password!=$password1){
    header("refresh:1,./admin_add.php");
    die('两次输入的密码不一致，请重新输入');
}

require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao=DAOMySQLi::getSingleton($options);
$sql="set names utf8";
$dao->query($sql);
//查询重名
$sql="select * from admin where name = '{$username}'";
$row = $dao->fetchOne($sql);
if(count($row)>0){
    header("refresh:1,./admin_add.php");
    die("用户名已存在，请换名重试");
}

//把passwordMD5加密
$password=md5($password);
//添加到数据库


$sql = "insert into admin VALUES (null,'{$username}','{$password}')";
$result=$dao->query($sql);
if($result){
    echo '管理员添加成功';
    header('refresh:1,./admin.php');
}else{
    header('refresh:1,./admin_add.php');
    die('管理员添加失败，请重试');
}
