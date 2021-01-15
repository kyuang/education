<?php require_once "../class/islogin_class.php";?>
<?php
    require_once '../class/option.php';
    require_once '../class/DAOMySQLi.class.php';
    $dao = DAOMySQLi::getSingleton($options);
    $sql="set names utf8";
    $dao->query($sql);
    $sql="select * from kecheng_list order by kecheng_od";
    $result = $dao->fetchAll($sql);
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
                        <tr><td height="31"><div class="title">添加栏目</div></td></tr>
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
                                                    <tr>
                                                        <th width="10%">排序</th>
                                                        <th width="10%" style="text-align: left">课程类型</th>
                                                        <th width="40%" style="text-align: left">名称</th>
                                                        <th width="20%" style="text-align: left" >操作</th>
                                                        <th width="20%"></th>
                                                    </tr>
                                                    <?php foreach ($result as $v):; ?>
                                                    <tr align="center" class="d">
                                                        <td><?php echo $v['kecheng_od']?></td>
                                                        <?php if($v['type']==1) {
                                                            echo "<td style='text-align: left'>每日一练</td>";
                                                        }elseif($v['type']==2){
                                                            echo "<td style='text-align: left'>课外作业</td>";
                                                        }else{
                                                            echo "<td style='text-align: left'>普通课程</td>";
                                                        }
                                                        ?>
                                                        <td style="text-align: left"><?php echo $v['kecheng_mingcheng']?></td>
                                                        <td style="text-align: left">
                                                            <a href="./nav_manage1.php?id=<?php echo $v['id']?>">编辑</a>
                                                            <?php
                                                            //判断有数据则不能删除
                                                            $sql="select count(*) as shuliang from kecheng_zhangjie where kechengid = {$v['id']}";
                                                            $result = $dao->fetchOne($sql);
                                                            if($result['shuliang']==0){
                                                            ?>
                                                                <a href="./nav_manage2.php?id=<?php echo $v['id']?>">删除</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="30%"></td>
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