<?php require_once "../class/islogin_class.php";?>
<?php
//接收数据
$id=isset($_POST['id'])?$_POST['id']:'';
$kecheng_mingcheng=isset($_POST['kecheng_mingcheng'])?$_POST['kecheng_mingcheng']:'';
$kecheng_od=isset($_POST['kecheng_od'])?$_POST['kecheng_od']:'';
if($id=='' or $kecheng_mingcheng==''or $kecheng_od==''){
    header("Refresh:1,./nav_manage1.php");
    die('修改栏目失败，请重试!');
}
//修改数据库数据
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql="set names utf8";
$dao->query($sql);
//
$sql = "select * from kecheng_list where id=" . $id;
$row = $dao->fetchOne($sql);
//修改数据库里栏目内容
$sql="update kecheng_list set kecheng_mingcheng='{$kecheng_mingcheng}',kecheng_od={$kecheng_od} where id={$id}";
//die($sql);
$dao->query($sql);
if($dao){
    echo "修改成功!";
    header("Refresh:1;./nav_manage.php");
}else{
    echo "修改失败，请重试!";
    header("Refresh:1;./nav_manage1.php");
}



