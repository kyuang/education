<?php
session_start();
 //注销登录
unset($_SESSION['username']);
header("refresh:1,./login.php");
exit;
?>