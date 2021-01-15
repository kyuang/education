<?php require_once "../class/islogin_class.php";?>
<?php
$kechengid = isset($_POST['kechengid'])?$_POST['kechengid']:'';
$zhangjieid = isset($_POST['zhangjieid'])?$_POST['zhangjieid']:'';
$nian=$_POST['nian'];
$yue=$_POST['yue'];
$kecheng_neirong = isset($_POST['kecheng_neirong'])?$_POST['kecheng_neirong']:'';
$kecheng_neirong=str_replace('#','<br>',$kecheng_neirong);
$daan = isset($_POST['daan'])?$_POST['daan']:'';
$daan=str_replace('#','<br>',$daan);
if(!get_magic_quotes_gpc()){
    $kecheng_neirong=addslashes($kecheng_neirong);
    $daan=addslashes($daan);
}

require_once '../class/Upload.class.php';
$upload = new Upload();
$filename = $upload->doUpload($_FILES['kecheng_img']);

require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql='set names utf8';
$dao->query($sql);
$sql="insert into kecheng_neirong VALUES (null,{$zhangjieid},'{$kecheng_neirong}','{$filename}','{$daan}')";
$dao->query($sql);
if($dao){
    echo '添加课程成功';
    header("Refresh:0;./kecheng_view.php?zhangjieid={$zhangjieid}&kechengid={$kechengid}&nian={$nian}&yue={$yue}");
}else{
    header("Refresh:1;./kecheng_add.php?zhangjieid={$zhangjieid}&kechengid={$kechengid}&nian={$nian}&yue={$yue}");
    die('添加课程失败，请重试');
}






