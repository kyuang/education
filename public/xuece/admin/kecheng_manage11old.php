<?php require_once "../class/islogin_class.php";?>
<?php
//接收数据
$id=isset($_POST['id'])?$_POST['id']:'';
$mingcheng = isset($_POST['kecheng_mingcheng'])?$_POST['kecheng_mingcheng']:'';
$jieshao = isset($_POST['kecheng_jieshao'])?$_POST['kecheng_jieshao']:'';
$duixiang = isset($_POST['kecheng_duixiang'])?$_POST['kecheng_duixiang']:'';
$jiage = isset($_POST['kecheng_jiage'])?$_POST['kecheng_jiage']:'';

if(empty($mingcheng)||empty($jieshao)||empty($duixiang)||empty($jiage)){
    header('Refresh:1,./kecheng_add.php');
    die('所有栏目不能为空！');
}
if(!is_numeric($jiage)){
    header('Refresh:1,./kecheng_add.php');
    die('价格必须为数字！');
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
$sql="update kecheng_list set kecheng_mingcheng='{$mingcheng}',kecheng_jieshao='{$jieshao}',kecheng_duixiang='{$duixiang}',kecheng_jiage={$jiage} where id={$id}";
//die($sql);
$dao->query($sql);

if($dao){
    echo "修改成功!";
    header("Refresh:1;./kecheng_manage.php");
}else{
    echo "修改失败，请重试!";
    header("Refresh:1;./kecheng_manage1.php");
}




