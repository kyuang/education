<?php
require_once './class/common_class.php';
require_once './class/top.class.php';
?>

<?php
$kechengid=$_GET['kechengid'];
$zhangjieid=$_GET['zhangjieid'];
$nian=$_GET['nian'];
$yue=$_GET['yue'];
require_once "./class/option.php";
require_once "./class/DAOMySQLi.class.php";
$sql="set names utf8";
$dao=DAOMySQLi::getSingleton($options);
$dao->query($sql);
//列出章节
$sql = "select id,biaoti,riqi from kecheng_zhangjie where kechengid = {$kechengid} and year(riqi)={$nian} and month(riqi)={$yue} and riqi<=CURRENT_DATE order by riqi DESC ";
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
    </div>
    <div class="row" style="background-color: white;margin-top: 10px;height: 50px;padding: 10px;">
        <div class="col-md2">
            <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">

                <select name="nian" style="height: 35px;">
                    <?php
                        for($i=2018;$i<=date('Y');$i++){
                            if($i==$nian){
                                $sel='selected';
                            }else{
                                $sel='';
                            }
                            echo "<option value='{$i}' {$sel}>{$i}年</option>";
                        }
                    ?>
                </select>


                <select name="yue" style="height: 35px;">
                    <?php for($i=1;$i<13;$i++){
                        if($i==$yue){
                            $selected='selected';
                        }else{
                            $selected='';
                        }
                        echo "<option value={$i} {$selected}>{$i}月份</option>";
                    }?>
                </select>
                <input type="submit" value="查询" style="height: 35px; ">
                <input type="hidden" name="zhangjieid" value=-1>
                <input type="hidden" name="kechengid" value="<?php echo $kechengid;?>">
            </form>
        </div>
    </div>
        <div class="row" style="background-color: white; padding: 2px;margin-top: 10px;">
                <?php foreach ($rows as $v):?>
                    <a href="<?php echo $_SERVER['PHP_SELF'];?>?zhangjieid=<?php echo $v['id'];?>&kechengid=<?php echo $kechengid;?>&nian=<?php echo $nian;?>&yue=<?php echo $yue;?>">
                            <?php
                                if($zhangjieid==$v['id']){
                                    $color1 = 'color:red';
                                }else{
                                    $color1='';
                                }
                            ?>
                            <div class="col-md-1 col-sm-1 col-xs-2"  style="margin-bottom: 2px; <?php echo $color1; ?>">
                                <div class="hidden-xs">
                                    <?php echo date('d',strtotime($v['riqi']));?>日
                                </div>
                                <div class="hidden-lg hidden-md hidden-sm">
                                    <?php echo date('d',strtotime($v['riqi']));?>
                                </div>
                            </div>
                    </a>
                <?php endforeach; ?>

        </div>

    <!--插入课程内容 -->
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
                    <div class='col-md-12'> <a href="./jiexi.php?id=<?php echo $v['id']?>" target='_blank'>查看答案解析</a></div>
                </div>
            </div>

        <?php endforeach;
        ?>
    </div>



</div>
<?php require_once './class/footer_class.php';?>
</body>






