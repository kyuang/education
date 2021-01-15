<?php require_once "../class/islogin_class.php";?>
<?php
$kechengid = isset($_POST['kechengid'])?$_POST['kechengid']:'';
$zhangjieid = isset($_POST['zhangjieid'])?$_POST['zhangjieid']:'';
$neirongid = isset($_POST['neirongid'])?$_POST['neirongid']:'';

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

$sql="update kecheng_neirong set neirong='{$kecheng_neirong }',daan='{$daan}' where id={$neirongid}";
//die($sql);
$dao->query($sql);

if($dao){
    echo "修改成功!";
    header("Refresh:1;./kecheng_manage1.php?neirongid={$neirongid}&zhangjieid={$zhangjieid}&kechengid={$kechengid}&nian={$nian}&yue={$yue}");
}else{
    echo "修改失败，请重试!";
    header("Refresh:1;./kecheng_manage1.php?neirongid={$neirongid}&zhangjieid={$zhangjieid}&kechengid={$kechengid}&nian={$nian}&yue={$yue}");
}







