<?php require_once "../class/islogin_class.php";?>
<?php
$id=isset($_GET['id'])?$_GET['id']:'';
require_once "../class/option.php";
require_once "../class/DAOMySQLi.class.php";
$dao=DAOMySQLi::getSingleton($options);
$sql='set names utf8';
$dao->query($sql);
$sql="delete from admin where id = {$id}";
$result = $dao->query($sql);
if($result){
    echo "删除成功";
}else{
    echo '删除失败';
}
header("refresh:1,./admin.php");

