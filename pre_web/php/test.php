<?php
// error_reporting(0);
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"web");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$query="select top 3 autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment from article order by arheart desc;
	select top 4 autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment from article order by date_time desc;";
$params = array(1, "some data");
$result=sqlsrv_query($conn,$query,$params);
if(!empty($result))
{
	while($row=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC))
	{
		$fileType = mb_detect_encoding($row['title'], array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'UTF-8')
		{
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
      		echo JSON_encode($row,JSON_UNESCAPED_UNICODE);	
		}
		// var_dump($row);
	}
}
while($next_result=sqlsrv_next_result($result))
{
	while($row=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC))
	{
		$fileType = mb_detect_encoding($row['title'], array('UTF-8','GBK','LATIN1','BIG5')) ;
		if( $fileType != 'UTF-8')
		{
			$row = mb_convert_encoding($row,'UTF-8' , $fileType);
      		echo JSON_encode($row,JSON_UNESCAPED_UNICODE);
		}
	}
}
// die(print_r(sqlsrv_errors(), true));
?>