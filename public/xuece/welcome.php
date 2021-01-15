<?php require_once './class/common_class.php';?>
<?php require_once './class/top.class.php';?>
<?php
require_once './class/option.php';
require_once './class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql="set names utf8";
$dao->query($sql);
$sql="select * from kecheng_list order by kecheng_od";
$rows = $dao->fetchAll($sql);
?>
<body>
    <?php require_once "./class/kong_class.php"; ?>
    <div class="container">
        <?php require_once "./class/nav.class.php";?>
        欢迎小朋友们来到学测课堂，好好学习有礼物哦！
    </div>
</body>
</html>