<?php require_once "../class/islogin_class.php";?>
<?php
$kechengid=isset($_GET['kechengid'])?$_GET['kechengid']:'';
$zhangjieid=isset($_GET['zhangjieid'])?$_GET['zhangjieid']:'';
$neirongid=isset($_GET['neirongid'])?$_GET['neirongid']:'';
$nian=$_GET['nian'];
$yue=$_GET['yue'];
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql = 'set names utf8';
$dao->query($sql);
//如果保存有图像则删除图像
$sql="select img from kecheng_neirong where id = " . $neirongid;
$row = $dao->fetchOne($sql);
if($row['img']!=''){
    unlink("./Images/mryl/".$row['img']);
}
//删除数据库数据
$sql="delete from kecheng_neirong where id = " . $neirongid;
$dao->query($sql);
if($dao){
    //删除成功
    echo "删除成功";
    header("Refresh:0,./kecheng_view.php?kechengid={$kechengid}&zhangjieid={$zhangjieid}&nian={$nian}&yue={$yue}");
}else{
    //删除失败
    header("Refresh:1,./kecheng_view.php?kechengid={$kechengid}&zhangjieid={$zhangjieid}&nian={$nian}&yue={$yue}");
    die("删除失败");
}


