<?php
header("content-type:text/html;charset=utf-8");
//引用连接数据库文件
require_once("connect.php");

//获取表单数据
$title=$_POST["news_title"];
$content=$_POST["news_contents"];

//建一个txt,值自增，用作命名
$countFile="count.txt";

//文件不存在则创建
if (!file_exists($countFile)) {
    fopen($countFile,"wb");
}

$handle=fopen($countFile,"rb");
$num=fgets($handle,20);

//每次增加1
$num=$num+1;
fclose($handle);

//更新$num
$handle=fopen($countFile,"wb");
fwrite($handle,$num);
fclose($handle);

//获取html路径，可自定义
$extend=".html";
$path="news".$num.$extend;

//插入数据
$sql="INSERT news(news_title,news_contents,news_path) VALUES('".$title."','".$content."','".$path."');";
$conn->query($sql);

/**---开始替换---**/
//打开html模板
$handle=fopen("model.html","rb");

//读取模板内容
$str=fread($handle,filesize("model.html"));

//替换 str_replace("被替换的"，"替换成"，"在哪替换")
//为什么在$str里替换?因为上面我们才读取的模板内容，肯定在模板里换撒
$str=str_replace("{news_title}", $title, $str);
$str=str_replace("{news_contents}",$content,$str);
fclose($handle);

//把替换的内容写进生成的html文件
$handle=fopen($path,"wb");
fwrite($handle,$str);
fclose($handle);