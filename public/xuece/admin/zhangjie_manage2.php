<?php require_once "../class/islogin_class.php";?>
<?php
$kechengid=isset($_GET['kechengid'])?$_GET['kechengid']:'';
$zhangjieid=isset($_GET['zhangjieid'])?$_GET['zhangjieid']:'';
$nian=isset($_GET['nian'])?$_GET['nian']:'';
$yue=isset($_GET['yue'])?$_GET['yue']:'';
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao =DAOMySQLi::getSingleton($options);
$sql='set names utf8';
$dao->query($sql);
$sql="delete from kecheng_zhangjie where id = {$zhangjieid}";
$dao->query($sql);
header("refresh:0,zhangjie_manage.php?kechengid={$kechengid}&nian={$nian}&yue={$yue}");

