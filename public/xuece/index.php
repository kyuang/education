<?php require_once './class/common_class.php';?>
<?php require_once './class/top.class.php';?>
<?php
require_once './class/option.php';
require_once './class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql="set names utf8";
$dao->query($sql);
?>
<body>
<?php require_once "./class/kong_class.php"; ?>
<?php require_once "./class/nav.class.php";?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <span>同学们，大家好！</span><br>
			<span style="color:red">近期疫情形势严峻，请大家勤洗手，多开窗通风</span><br>
			<span style="color:red">不聚集，出门戴口罩</span><br>
            <span>请点击“<a href="kechengview.php">选择课程</a>”选课吧...</span>
        </div>
        <div class="col-md-12">
            <img src="./img/2019ny1.jpg" class="img-responsive">
        </div>
    </div>
</div>
<?php require_once './class/footer_class.php';?>
<?php require_once './tongji.php';?>
<?php require_once './tongji1.php';?>
<div class="container hidden-xs hidden-sm" >
    <p><a href="./admin/login.php" style="color:white">.</a></p>
</div>
</body>
</html>