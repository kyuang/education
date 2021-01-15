<?php require_once "../class/islogin_class.php";?>
<?php
$kechengid=$_GET['kechengid'];
$nian=$_GET['nian'];
$yue=$_GET['yue'];
$ri=$_GET['ri'];
if($kechengid==-1){
    header("refresh:1,./zhangjie_manage.php?kechengid={$kechengid}&nian={$nian}&yue={$yue}$ri={$ri}");
    die("请先选择课程，然后再添加章节");
}
require_once '../class/common_class.php';
require_once '../class/option.php';
require_once '../class/DAOMySQLi.class.php';
$dao = DAOMySQLi::getSingleton($options);
$sql = "set names utf8";
$dao->query($sql);
$sql="select type from kecheng_list where id = {$kechengid}";
$row = $dao->fetchOne($sql);
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
                        <tr><td height="31"><div class="title">添加课程</div></td></tr>
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
                        <!-- 添加课程内容开始 -->
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td width="96%">
                                <table width="100%">
                                    <tr>
                                        <td colspan="2">
                                            <form action="zhangjie_add1.php" method="post" enctype="multipart/form-data">
                                                <table width="100%" class="cont">
                                                    <?php if($row['type']==1||$row['type']==2){?>
                                                        <tr>
                                                            <td width="2%">&nbsp;</td>
                                                            <td>显示日期：</td>
                                                            <td width="20%"">
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
                                                                <?php for($i=1;$i<13;$i++){
                                                                    if($i==$yue){
                                                                        $selected='selected';
                                                                    }else{
                                                                        $selected='';
                                                                    }
                                                                    echo "<option value='{$i}' {$selected}>{$i}月</option>";
                                                                }?>
                                                            </select>
                                                            <select name="ri"  style="height: 40px;width: 100px;font-size: 20px;">
                                                                <?php for($i=1;$i<32;$i++){
                                                                    if($i==$ri){
                                                                        $selected='selected';
                                                                    }else{
                                                                        $selected='';
                                                                    }
                                                                    echo "<option value={$i} {$selected}>{$i}日</option>";
                                                                }?>
                                                            </select>
                                                            <input type="hidden" name="zhangjie_biaoti"></input>
                                                            </td>
                                                            <td>设置每日一练显示日期</td>
                                                            <td width="32%">&nbsp;</td>

                                                        </tr>
                                                    <?php }else{ ?>
                                                        <tr>
                                                            <td width="2%">&nbsp;</td>
                                                            <td>章节标题：</td>
                                                            <td width="50%">
                                                            <input type="text" name="zhangjie_biaoti" style="height: 40px;width: 400px;font-size: 25px;"></input>
                                                            </td>
                                                            <td>设置章节标题</td>
                                                            <td width="2%">&nbsp;</td>
                                                        </tr>
                                                    <?php }?>

                                                    <tr>
                                                        <td width="2%">&nbsp;</td>
                                                        <td>章节顺序：</td>
                                                        <td width="50%"">
                                                        <input type="text" name="zhangjie_shunxu"  style="height: 40px;width: 50px;font-size: 25px;"></input>
                                                        </td>
                                                        <td>设置章节顺序</td>
                                                        <td width="2%">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="3"><input class="btn" type="submit" value="提交"  style="height: 40px;width: 100px;font-size: 20px;"/></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <input type="hidden" name="kechengid" value="<?php echo $kechengid;?>"></input>
                                                    </tr>
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
                                <img src="./Images/icon_phone.gif" width="17" height="14"> 官方网站：<a href="http://www.shuhua.cc">http://www.xuece.cc</a>
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