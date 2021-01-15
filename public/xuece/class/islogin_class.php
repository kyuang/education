<?php
session_start();
if(empty($_SESSION['username'])){
    header("refresh:1,./login.php");
    die('请重新登录');
}
?>