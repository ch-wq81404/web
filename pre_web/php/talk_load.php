<?php
error_reporting(0);
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"web");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$title=$_GET["title"];

// $title="巅峰赛云中君已炸裂carry了，还不削么";
$fileType = mb_detect_encoding($title, array('UTF-8','GBK','LATIN1','BIG5')) ;
if( $fileType != 'GBK')
{
	$title = mb_convert_encoding($title,'GBK' , $fileType);
}
$query="select title,artext,autherID,convert(char,date_time,120) date_time,arheart,arcomment from t_article where title='$title'";
$result=sqlsrv_query($conn,$query, array());
if(sqlsrv_has_rows($result))
{
	$row=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	$fileType = mb_detect_encoding($row['artext'], array('UTF-8','GBK','LATIN1','BIG5')) ;//找原来数据的编码方式
	if( $fileType != 'UTF-8')//json只能识别utf-8编码，不是的话要换
	{
		$row = mb_convert_encoding($row,'UTF-8' , $fileType);//换成utf-8
      	echo JSON_encode($row,JSON_UNESCAPED_UNICODE);
	}
}//
else { 
    header("location:http://localhost/html/error403.html");
}
?>