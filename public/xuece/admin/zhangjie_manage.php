<?php require_once '../class/common_class.php';?>
<?php require_once "../class/islogin_class.php";?>
<?php
    $kechengid=$_GET['kechengid'];
    $nian=$_GET['nian'];
    $yue=$_GET['yue'];
    require_once '../class/option.php';
    require_once '../class/DAOMySQLi.class.php';
    $dao = DAOMySQLi::getSingleton($options);
    $dao1=DAOMySQLi::getSingleton($options);
    $sql="set names utf8";
    $dao->query($sql);
    $dao1->query($sql);
    $sql="select * from kecheng_list order BY kecheng_od";
    $result = $dao->fetchAll($sql);
    $sql="select type from kecheng_list where id={$kechengid}";
    $row=$dao->fetchOne($sql);
    if($row['type']==1||$row['type']==2){
        //如果是每日一练或者作业则加入日期限制
        $sql="select * from kecheng_zhangjie where kechengid = {$kechengid} and  year(riqi)={$nian} and month(riqi)={$yue}  order by biaoti,shunxu";
    }else{
        //如果不是每日一练或者作业则不加入日期限制
    $sql="select * from kecheng_zhangjie where kechengid = {$kechengid} order by biaoti,shunxu";
    }
    $result1=$dao->fetchAll($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="./Style/skin.css" />
</head>
    <body>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <!-- 头部开始 -->
            <tr>
                <td width="17" valign="top" background="./Images/mail_left_bg.gif">
                    <img src="./Images/left_top_right.gif" width="17" height="29" />
                </td>
                <td valign="top" background="./Images/content_bg.gif">
                    <table width="100%" height="31" border="0" cellpadding="0" cellspacing="0" background="././Images/content_bg.gif">
                        <tr><td height="31"><div class="title">添加课程列表</div></td></tr>
                    </table>
                </td>
                <td width="16" valign="top" background="./Images/mail_right_bg.gif"><img src="./Images/nav_right_bg.gif" width="16" height="29" /></td>
            </tr>
            <!-- 中间部分开始 -->
            <tr>
                <!--第一行左边框-->
                <td valign="middle" background="./Images/mail_left_bg.gif">&nbsp;</td>
                <!--第一行中间内容-->
                <td valign="top" bgcolor="#F7F8F9">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <!-- 空白行-->
                        <tr><td colspan="2" valign="top">&nbsp;</td><td>&nbsp;</td><td valign="top">&nbsp;</td></tr>
                        <tr>
                            <td colspan="4">
                                <table>
                                    <tr>
                                        <td width="100" align="center"><img src="./Images/mime.gif" /></td>
                                        <td valign="bottom"><h3 style="letter-spacing:1px;">在这里，您可以根据您的需求，填写网站参数！</h3></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- 一条线 -->
                        <tr>
                            <td height="40" colspan="4">
                                <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                                    <tr><td></td></tr>
                                </table>
                            </td>
                        </tr>


                        <!-- 添加栏目开始 -->
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="96%">
                                <table width="100%">
                                    <tr>
                                        <td colspan="2">

                                                <table width="100%"  class="cont tr_color" >
                                                    <!--添加课程选择列表-->
                                                    <tr>
                                                        <td colspan="3">
                                                        <form method="get" action="<?php echo $_SERVER['PHP_SELF']?>">
                                                            <p>请选择课程：</p>
                                                            <select name="kechengid" style="height: 40px;width: 250px;font-size: 20px;">
                                                                <option value="-1" selected>请选择课程...</option>
                                                                <?php foreach ($result as $v):?>
                                                                    <?php
                                                                        if($v['id']==$kechengid){
                                                                            $sel="selected";
                                                                        }else{
                                                                            $sel='';
                                                                        }
                                                                    ?>
                                                                    <option <?php echo $sel;?> value="<?php echo $v['id'];?>"><?php echo $v['kecheng_mingcheng'];?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                            <select name="nian"  style="height: 40px;width: 100px;font-size: 20px;">
                                                                <?php
                                                                    for($i=2018;$i <= date('Y');$i++){
                                                                        if($_GET['nian']==$i){
                                                                            $sel='selected';
                                                                        }else{
                                                                            $sel='';
                                                                        }
                                                                ?>

                                                                        <option value="<?php echo $i; ?>" <?php echo $sel; ?>><?php echo $i;?>年</option>
                                                                <?php }?>
                                                            </select>
                                                            <select name="yue"  style="height: 40px;width: 100px;font-size: 20px;">
                                                                <?php
                                                                for($i=1;$i <= 12;$i++){
                                                                    if($_GET['yue']==$i){
                                                                        $sel='selected';
                                                                    }else{
                                                                        $sel='';
                                                                    }
                                                                    ?>

                                                                    <option value="<?php echo $i; ?>" <?php echo $sel; ?>><?php echo $i;?>月</option>
                                                                <?php }?>
                                                            </select>

                                                            <input type="submit" value="确定" style="height: 40px;font-size: 20px;width: 120px;">
                                                        </form>
                                                        </td>
                                                        <td colspan="4">
                                                            <form method="get" action="zhangjie_add.php">
                                                                <p>&nbsp;</p>
                                                                <input type="submit" value="添加章节" style="height: 40px;font-size: 20px;width: 120px;">
                                                                <input type="hidden" name="kechengid" value="<?php echo $kechengid; ?>">
                                                                <input type="hidden" name="nian" value="<?php echo date('Y');?>">
                                                                <input type="hidden" name="yue" value="<?php echo date('m');?>">
                                                                <input type="hidden" name="ri" value="<?php echo date('d');?>">
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="2%"></td>
                                                        <th width="30%" style="text-align: left">课程章节</th>
                                                        <th width="10%" style="text-align: center">题目数量</th>
                                                        <th width="10%" style="text-align: center">章节顺序</th>

                                                        <th width="10%" style="text-align: center" colspan="3">操作</th>
                                                        <th width="38%"></th>
                                                    </tr>

                                                    <?php foreach ($result1 as $v1):?>
                                                    <tr align="center" class="d">
                                                        <td></td>
                                                        <td style="text-align: left; width: 20%;"><?php echo $v1['biaoti']?></td>
                                                        <?php
                                                            $sql="select count(*) as shuliang from kecheng_neirong where zhangjieid = {$v1['id']}";
                                                            $result2=$dao->fetchOne($sql);
                                                            //var_dump($result2);
                                                        ?>
                                                        <td style="text-align: center; width: 5%;"><?php echo $result2['shuliang'];?></td>
                                                        <td style="text-align: center; width: 5%;"><?php echo $v1['shunxu']?></td>

                                                        <td style="text-align: center; width: 5%;"><a href="./kecheng_view.php?kechengid=<?php echo $kechengid;?>&zhangjieid=<?php echo $v1['id']?>&nian=<?php echo $nian;?>&yue=<?php echo $yue;?>">查看课程</a></td>
                                                        <td style="text-align: center; width: 5%;"><a href="./zhangjie_manage1.php?kechengid=<?php echo $kechengid;?>&zhangjieid=<?php echo $v1['id']?>&nian=<?php echo $nian;?>&yue=<?php echo $yue;?>">编辑</a></td>
                                                        <?php if($result2['shuliang']==0){ ?>
                                                            <td style="text-align: center; width: 5%;"><a href="./zhangjie_manage2.php?kechengid=<?php echo $kechengid;?>&zhangjieid=<?php echo $v1['id'];?>&nian=<?php echo $nian;?>&yue=<?php echo $yue;?>">删除</a></td>
                                                        <?php }else{ ?>
                                                            <td></td>
                                                        <?php }?>
                                                        <td></td>
                                                    </tr>
                                                    <?php endforeach;?>
                                                </table>

                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="2%">&nbsp;</td>
                        </tr>
                        <!-- 添加栏目结束 -->
                        <tr>
                            <td height="40" colspan="4">
                                <table width="100%" height="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                                    <tr><td></td></tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="51%" class="left_txt">
                                <img src="./Images/icon_phone.gif" width="17" height="14"> 官方网站：<a href="http://www.itbull.cn">http://www.itbull.cn</a>
                            </td>
                            <td>&nbsp;</td><td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td background="./Images/mail_right_bg.gif">&nbsp;</td>
            </tr>
            <!-- 底部部分 -->
            <tr>
                <td valign="bottom" background="./Images/mail_left_bg.gif">
                    <img src="./Images/buttom_left.gif" width="17" height="17" />
                </td>
                <td background="./Images/buttom_bgs.gif">
                    <img src="./Images/buttom_bgs.gif" width="17" height="17">
                </td>
                <td valign="bottom" background="./Images/mail_right_bg.gif">
                    <img src="./Images/buttom_right.gif" width="16" height="17" />
                </td>           
            </tr>
        </table>
    </body>
</html>