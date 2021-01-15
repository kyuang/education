<?php
//统计流量（人数，访问次数，用户IP）
//假设用户访问，得到IP地址
$remote = $_SERVER['REMOTE_ADDR'];
//拼凑要写入到文件的数据：ip|2018-5-20 10:24:15
$write = $remote . '|' . date('Y-m-d H:i:s');
//输出信息：挡墙网页已经被第几次访问，当前用户是第几次来访问
$str = file_get_contents('record.txt');
//定义一个变量保存当前用户的点击次数
$clickcount = 1;
//判断当前有没有记录访问信息
if($str){
//有数据
//以行区分当前文件有多少行
$rows = explode("\r\n",$str);
//获取已经访问过的用户的数量
$count = count($rows) + 1;
//判断当前用户是第几次访问该网页
foreach($rows as $value){
//value代表一个访问记录

    $ip = explode("|",$value);

//判读是不是当前用户查看的

if($ip[0] == $remote){

//以前访问的记录与当前用户的ip相同

    $clickcount++;

}

}

 //修改write

$write = "\r\n" . $write;

}else{
//当前用户是第一个来访问该网页
    $count = 1;
}

//写入数据

file_put_contents('record.txt',$write,FILE_APPEND);

//输出信息
//echo "当前网页已经是第{$count}次被访问<br/>";
//echo "您是第{$clickcount}次来访问该网页<br/>";
?>