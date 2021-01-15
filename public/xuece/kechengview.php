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
    <!--每日一练课程开始-->
        <?php
            $sql="select * from kecheng_list where type=1 order by kecheng_od";
            $rows = $dao->fetchAll($sql);
            if(count($rows)>0){
        ?>
            <div class="row"style="padding-left:15px;height: 60px;line-height: 60px;font-size: 20px; background-color: #c6d4ff;">每日一练课程</div>
            <div class="row">
                <?php foreach ($rows as $v):?>
                    <a href="mryl.php?kechengid=<?php echo $v['id'] ?>&zhangjieid=-1&nian=<?php echo date('Y')?>&yue=<?php echo date('m')?>">
                        <div class="col-md-3 col-sm-6 text-center" style="height:70px;line-height:70px;overflow:hidden;background-color: #f2f1d6;border:3px solid white;">
                            <?php echo $v['kecheng_mingcheng'] ?>
                        </div>
                    </a>
                <?php endforeach;?>
            </div>
        <?php }?>


    <!--课外作业开始-->
    <?php
    $sql="select * from kecheng_list where type=2 order by kecheng_od";
    $rows = $dao->fetchAll($sql);
    if(count($rows)>0){
    ?>
        <div class="row"style="padding-left:15px;height: 60px;line-height: 60px;font-size: 20px; background-color: #c6d4ff;">课外作业</div>
        <div class="row">
            <?php foreach ($rows as $v):?>
                <a href="mryl.php?kechengid=<?php echo $v['id'] ?>&zhangjieid=-1&nian=<?php echo date('Y')?>&yue=<?php echo date('m')?>">
                    <div class="col-md-3 col-sm-6 text-center" style="height:70px;line-height:70px;overflow:hidden;background-color: #f2f1d6;border:3px solid white;">
                        <?php echo $v['kecheng_mingcheng'] ?>
                    </div>
                </a>
            <?php endforeach;?>
        </div>
    <?php }?>

    <!--标准课程开始-->

        <?php
            $sql="select * from kecheng_list where type=0 order by kecheng_od";
            $rows = $dao->fetchAll($sql);
            if(count($rows)>0){
        ?>
                <div class="row"style="padding-left:15px;height: 60px;line-height: 60px;font-size: 20px; background-color: #c6d4ff;">标准课程</div>
         <div class="row">
            <?php foreach ($rows as $v):?>
            <a href="zhangjie.php?kechengid=<?php echo $v['id'] ?>&zhangjieid=-1">
                <div class="col-md-3 col-sm-6 text-center" style="height:70px;line-height:70px;overflow:hidden;background-color: #f2f1d6;border:3px solid white;">
                     <?php echo $v['kecheng_mingcheng'] ?>
                </div>
            </a>
            <?php endforeach;?>
        </div>
        <?php }?>

</div>
<?php require_once './class/footer_class.php';?>
<div class="container">
    <p><a href="./admin/login.php">.</a></p>
</div>
</body>
</html>