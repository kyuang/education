<?php
require_once "./class/common_class.php";
require_once "./class/top.class.php";
$id=isset($_GET['id'])?$_GET['id']:'';
require_once './class/option.php';
require_once './class/DAOMySQLi.class.php';
$sql='set names utf8';
$dao=DAOMySQLi::getSingleton($options);
$dao->query($sql);
$sql="select daan from kecheng_neirong where id = {$id}";
$row=$dao->fetchOne($sql);
?>
<body>
<div class="container">

        <hr>

    <div class="row" style="padding-left: 10px;" >
        <p>题目ID是“<?php echo $id ?>”的答案是:</p>
        <p><?php echo $row['daan']; ?></p>
    </div>
    <hr>
    <div class="row">
        <p>更详细解析请加微信联系</p>
        <img src="./img/wexin0001.jpg" class="img-responsive">
    </div>
    <div class="row" style="padding-left: 10px;"><span>保存此二维码，用微信识别加微信</span></div>
</div>
<?php require_once './class/footer_class.php';?>
</body>
