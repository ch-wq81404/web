<?php
// error_reporting(0);
header("Access-Control-Allow-Origin:*");
$index=$_GET['index']*10;
$source=$_GET['source'];
$source = mb_convert_encoding($source,'GBK' , 'UTF-8');
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"web");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$query="select * from (select top 10 * from (select top $index autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment from t_article where arsource=$source  order by arheart desc) as A order by arheart asc) as B order by arheart desc";
$result=sqlsrv_query($conn,$query,array(), array( "Scrollable" => SQLSRV_CURSOR_KEYSET ));
if(sqlsrv_num_rows($result)>=1)
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
else {
	echo "暂时无讨论，请耐心等待~~";
    die(print_r(sqlsrv_errors()));
}
?>