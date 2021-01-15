<?php require_once "../class/islogin_class.php";?>
<?php
$kecheng_mingcheng = isset($_POST['kecheng_mingcheng'])?$_POST['kecheng_mingcheng']:'';
$kecheng_od=isset($_POST['kecheng_od'])?$_POST['kecheng_od']:'';
$type=isset($_POST['type'])?$_POST['type']:'';
if($kecheng_od==''){
    $kecheng_od=1;
}
if($kecheng_mingcheng==''){
    header('Refresh:1,./nav_add.php');
    die('课程名称不能为空！');
}
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql='set names utf8';
$dao->query($sql);
$sql="insert into kecheng_list VALUES (null,'{$kecheng_mingcheng}',{$kecheng_od},{$type})";
//die($sql);
$dao->query($sql);
if($dao){
    echo '添加课程成功';
    header('Refresh:1;./nav_add.php');
}else{
    header('Refresh:1;./nav_add.php');
    die('添加导航失败，请重试');
}




