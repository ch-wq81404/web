<?php
error_reporting(0);
header("content-type:text/html;charset=utf-8");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"web");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$title=$_GET["title"];
$fileType = mb_detect_encoding($title, array('UTF-8','GBK','LATIN1','BIG5')) ;
if( $fileType != 'GBK')
	$title = mb_convert_encoding($title,'GBK' , $fileType);
$query="select arID from t_article where title='$title'";
$result=sqlsrv_query($conn,$query, array());
if(sqlsrv_has_rows($result))
{
	$row=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	//获取html路径，可自定义
	$extend=".html";
	$path="D:\\Program Files\\XAMPP\\XMAPP\\htdocs\\html\\".$row['arID'].$extend;
	/**---开始替换---**/
	//打开html模板
	$handle=fopen("D:\\Program Files\\XAMPP\\XMAPP\\htdocs\\html\\talk_detail.html","rb");
	//读取模板内容
	$str=fread($handle,filesize("D:\\Program Files\\XAMPP\\XMAPP\\htdocs\\html\\talk_detail.html"));
	//替换
	$title="\"".$title."\"";
	$title = mb_convert_encoding($title,'UTF-8' , 'GBK');
	$add="<script>window.onload=page_onload($title);</script>";
	$str=$str.$add;
	fclose($handle);
	// 把替换的内容写进生成的html文件
	$handle=fopen($path,"wb");
	fwrite($handle,$str);
	fclose($handle);
	header('location:http://localhost/html/'.$row['arID'].$extend);
}
else
{
	header("location:http://localhost/html/error403.html");
}
die(print_r(sqlsrv_errors(), true));
?>