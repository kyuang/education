<?php require_once "../class/islogin_class.php";?>
<?php
    //$kechengid=isset($_POST['kechengid'])?$_POST['kechengid']:'';
    $zhangjieid=$_GET['zhangjieid'];
    require_once '../class/option.php';
    require_once '../class/DAOMySQLi.class.php';
    $dao = DAOMySQLi::getSingleton($options);
    $dao1=DAOMySQLi::getSingleton($options);
    $sql="set names utf8";
    $dao->query($sql);
    $dao1->query($sql);
    $sql="select * from kecheng_list order BY kecheng_od";
    $result = $dao->fetchAll($sql);
    //写课程id，按id查询
    $sql="select * from kecheng_neirong where suoshukecheng = {$zhangjieid} order by riqi DESC ";
    $result1=$dao1->fetchAll($sql);
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
                                            <form action="" method="">
                                                <table width="100%"  class="cont tr_color">
                                                    <!--添加课程选择列表-->
                                                    <!--添加课程选择列表-->
                                                    <!--添加课程选择列表-->
                                                    <!--添加课程选择列表-->
                                                    <!--添加课程选择列表-->
                                                    <tr>
                                                        <form method="get" action="<?php echo $_SERVER['PHP_SELF']?>">
                                                            <select name="kechengid">
                                                                <?php foreach ($result as $v):?>
                                                                    <?php
                                                                        if($v['id']==$zhangjieid){
                                                                            $sel="selected";
                                                                        }else{
                                                                            $sel='';
                                                                        }
                                                                    ?>
                                                                    <option <?php echo $sel;?> value="<?php echo $v['id'];?>"><?php echo $v['kecheng_mingcheng'];?></option>
                                                                <?php endforeach;?>
                                                            </select>
                                                            <input type="submit">
                                                        </form>
                                                    </tr>

                                                    <tr>
                                                        <th width="10%" style="width: 80px">id</th>
                                                        <th width="10%" style="width: 350px;text-align: left">日期</th>
                                                        <th width="30%" style="width: 200px;text-align: left">课程标题</th>
                                                        <th width="30%" style="width: 200px;text-align: left">课程内容</th>
                                                        <th width="10%" style="width: 500px;text-align: left">相关图像</th>
                                                        <th width="20%" style="width: 180px" colspan="3">操作</th>
                                                    </tr>

                                                    <?php foreach ($result1 as $v1):?>
                                                    <tr align="center" class="d">
                                                        <td style="text-align: center"><?php echo $v1['id']?></td>
                                                        <td style="text-align: left"><?php echo $v1['riqi']?></td>
                                                        <td style="text-align: left"><?php echo $v1['biaoti']?></td>
                                                        <td style="text-align: left"><?php echo $v1['neirong']?></td>
                                                        <td style="text-align: left"><?php echo $v1['img']?></td>
                                                        <td style="text-align: center">
                                                            <a href="./kecheng_manage1.php?kechengid=<?php echo $v1['id']?>&zhangjieid=<?php echo $zhangjieid?>">编辑</a>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <a href="./kecheng_manage2.php?id=<?php echo $v1['id']?>&zhangjieid=<?php echo $zhangjieid?>">删除</a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach;?>

                                                </table>
                                            </form>
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