<?php
require_once './class/common_class.php';
require_once './class/top.class.php';
?>

<?php
$kechengid=$_GET['kechengid'];
$zhangjieid=$_GET['zhangjieid'];
require_once "./class/option.php";
require_once "./class/DAOMySQLi.class.php";
$sql="set names utf8";
$dao=DAOMySQLi::getSingleton($options);
$dao->query($sql);
//列出章节
$sql = "select id,biaoti from kecheng_zhangjie where kechengid = {$kechengid} and riqi <= CURRENT_DATE";
$rows = $dao->fetchAll($sql);
//var_dump($rows);
$sql = "select kecheng_mingcheng from kecheng_list where id = {$kechengid}";
$kemu=$dao->fetchOne($sql);
?>
<body style="background-color: #f8f8f8;">
<?php require_once "./class/nav.class.php";?>
<div class="container">
    <div class="row" style="text-align: center;background-color: white;">
        <div class="col-md-12" style ="height:60px;line-height: 60px;font-size: 26px;">
            <?php  echo $kemu['kecheng_mingcheng'];?>
        </div>
        <hr>
    </div>
        <div class="row" style="background-color: white; padding: 15px;margin-top: 10px;"">
                <?php foreach ($rows as $v):?>
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?zhangjieid=<?php echo $v['id'];?>&kechengid=<?php echo $kechengid;?>">
                            <?php
                                if($zhangjieid==$v['id']){
                                    $color1 = 'color:red';
                                }else{
                                    $color1='';
                                }
                            ?>
                            <div class="col-md-3 col-sm-4 col-xs-12"  style="margin-bottom: 5px; <?php echo $color1; ?>">
                                <?php echo $v['biaoti'];?>
                            </div>
                    </a>
                <?php endforeach; ?>

        </div>


        <div class="row">
                <?php
                $sql="select * from kecheng_neirong where zhangjieid = {$zhangjieid} order by id";
                $rows1 = $dao->fetchAll($sql);
                foreach ($rows1 as $v):
                ?>

                <div class="col-md-12 col-sm-12" style="border: 1px solid #7c7c7c;margin-top: 20px;background-color: white;">
                    <div class='row' style="height: 50px;line-height: 50px;background-color:#a7a7a7;">
                        <div class='col-md-12'  >题目ID:<?php echo $v['id']?></div>
                    </div>
                    <div class='row' style="margin-top: 10px;">
                        <div class='col-md-12' style="word-wrap: break-word;"><?php echo $v['neirong']?></div>
                    </div>
                    <!--判断有没有图片信息，如果有则显示图片，如果没有则不显示-->
                    <?php if($v['img']!=''){ ?>
                        <div class='row' style='margin-top: 10px;'>
                        <div class='col-md-12'> <a href="./admin/Images/mryl/<?php echo $v['img'];?>" target='_blank'><img src="./admin/Images/mryl/<?php echo $v['img'];?>" class='img-responsive' /></a></div>
                        </div>
                    <?php }?>
                    <div class='row' align='right' style='margin-top: 30px; margin-bottom: 10px;'>
                        <div class='col-md-12'> <a href="./jiexi.php?id=<?php echo $v['id']?>" target='_blank'>查看解析</a></div>
                    </div>
                </div>

            <?php endforeach;
            ?>
        </div>

</div>
</body>






