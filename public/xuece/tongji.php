<?php
$file = dirname(__FILE__).'\tongji.db';
//$data = unserialize(file_get_contents($file));
$fp=fopen($file,'r+');
$content='';

if (flock($fp,LOCK_EX)) {
    while (($buffer = fgets($fp, 1024)) != false) {
        $content = $content . $buffer;
    }
    $data = unserialize($content);

//设置记录键值
    $total = 'total';
    $month = date('Ym');
    $today = date('Ymd');
    $yesterday = date('Ymd', strtotime("-1 day"));
    $tongji = array();
// 总访问增加
    $tongji[$total] = $data[$total] + 1;
// 本月访问量增加
    $tongji[$month] = $data[$month] + 1;
// 今日访问增加
    $tongji[$today] = $data[$today] + 1;
//保持昨天访问
    $tongji[$yesterday] = $data[$yesterday];

//保存统计数据
    ftruncate($fp, 0); // 将文件截断到给定的长度
    rewind($fp); // 倒回文件指针的位置
    fwrite($fp, serialize($tongji));
    flock($fp, LOCK_UN);
    fclose($fp);

//输出数据
    $total = $tongji[$total];
    $month = $tongji[$month];
    $today = $tongji[$today];
    $yesterday = $tongji[$yesterday] ? $tongji[$yesterday] : 0;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="font-size: 14px;color: #d8d8d8">总访问:<?php echo $total?>,本月:<?php echo $month?>,昨日:<?php echo $yesterday?>,今日:<?php echo $today?></div>
    </div>
</div>

