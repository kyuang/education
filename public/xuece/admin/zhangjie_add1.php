<?php require_once "../class/islogin_class.php";?>
<?php
$kechengid = isset($_POST['kechengid'])?$_POST['kechengid']:'';
$zhangjie_biaoti = isset($_POST['zhangjie_biaoti'])?$_POST['zhangjie_biaoti']:'';
$zhangjie_shunxu=isset($_POST['zhangjie_shunxu'])?$_POST['zhangjie_shunxu']:'';;
$nian=isset($_POST['nian'])?$_POST['nian']:'';
$yue=isset($_POST['yue'])?$_POST['yue']:'';
$ri=isset($_POST['ri'])?$_POST['ri']:'';
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql='set names utf8';
$dao->query($sql);

if(empty($zhangjie_shunxu)){
    $zhangjie_shunxu=100;
}

$sql='select type from kecheng_list where id = ' . $kechengid;
$row=$dao->fetchOne($sql);
$riqi=date('Y-m-d',strtotime($nian .'-'.$yue.'-'.$ri));
//type==0是普通课程，1是每日一练，2是作业
if($row['type']==0){
    if(empty($zhangjie_biaoti)){
        header('Refresh:1,./kecheng_add.php');
        die('章节名称不能为空！');
    }
}else{
    $zhangjie_biaoti=$riqi;
}
$sql="insert into kecheng_zhangjie VALUES (null,{$kechengid},'{$zhangjie_biaoti}',{$zhangjie_shunxu},'{$riqi}')";
$dao->query($sql);
if($dao){
    echo '添加章节成功';
    header("Refresh:0;./zhangjie_manage.php?kechengid={$kechengid}&nian={$nian}&yue={$yue}");
}else{
    header("Refresh:1;./zhangjie_add.php?kechengid={$kechengid}&nian={$nian}&yue={$yue}");
    die('添加章节失败，请重试');
}






