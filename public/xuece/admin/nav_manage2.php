<?php require_once "../class/islogin_class.php";?>
<?php
$id=isset($_GET['id'])?$_GET['id']:'';
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql = 'set names utf8';
$dao->query($sql);
$sql="delete from kecheng_list where id = " . $id;
$dao->query($sql);
if($dao){
    //删除成功
    echo "删除成功";
    header("Refresh:1,./nav_manage.php");
}else{
    //删除失败
    header("Refresh:1,./nav_manage.php");
    die("删除失败，请重试！");
}


