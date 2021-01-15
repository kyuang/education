<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="./Js/prototype.lite.js" type="text/javascript"></script>
    <script src="./Js/moo.fx.js" type="text/javascript"></script>
    <script src="./Js/moo.fx.pack.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="./Style/skin.css" />
	<style type="text/css">

	</style>
    <script type="text/javascript">
        window.onload = function () {
            var contents = document.getElementsByClassName('content');
            var toggles = document.getElementsByClassName('type');

            var myAccordion = new fx.Accordion(
            toggles, contents, {opacity: true, duration: 400}
            );
            myAccordion.showThisHideOpen(contents[0]);
            for(var i=0; i<document .getElementsByTagName("a").length; i++){
                var dl_a = document.getElementsByTagName("a")[i];
                    dl_a.onfocus=function(){
                        this.blur();
                    }
            }
        }
    </script>
</head>

<body>
    <table width="100%" height="280" border="0" cellpadding="0" cellspacing="0" bgcolor="#EEF2FB">
        <tr>
            <td width="182" valign="top">
                <div id="container">
                    <!--课程设置开始-->
                    <h1 class="type"><a href="javascript:void(0)" style="font-size:14px;">课程设置</a></h1>
                    <div class="content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><img src="./Images/menu_top_line.gif" width="182" height="5" /></td>
                            </tr>
                        </table>
                        <ul class="RM">
                            <li><a href="./nav_add.php" target="main" style="font-size:10px;">添加课程</a></li>
                            <li><a href="./nav_manage.php" target="main" style="font-size:10px;">课程管理</a></li>
                        </ul>
                    </div>
                    <!--课程设置结束-->

                    <!--课程章节开始-->
                    <h1 class="type"><a href="javascript:void(0)" style="font-size:14px;">课程章节管理</a></h1>
                    <div class="content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><img src="./Images/menu_top_line.gif" width="182" height="5" /></td>
                            </tr>
                        </table>
                        <ul class="RM">
                            <li><a href="./zhangjie_manage.php?kechengid=-1&nian=<?php echo date('Y');?>&yue=<?php echo date('m');?>" target="main" style="font-size:10px;">章节内容管理</a></li>
                        </ul>
                    </div>
                    <!--课程章节结束-->


                    <!--管理员管理开始-->
                    <h1 class="type"><a href="javascript:void(0)" style="font-size:14px;">管理员管理</a></h1>
                    <div class="content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td><img src="./Images/menu_top_line.gif" width="182" height="5" /></td>
                            </tr>
                        </table>
                        <ul class="RM">
                            <li><a href="./admin_add.php" target="main"  style="font-size:10px;">添加管理员</a></li>
							<li><a href="./admin.php" target="main"  style="font-size:10px;">管理员列表</a></li>
                        </ul>
                    </div>
                    <!--管理员管理结束-->
                    <!-- *********** -->
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
