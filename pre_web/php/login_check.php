<?php
$username=$_POST["username"];
$pass=$_POST["pass"];
echo $username;
header("Access-Control-Allow-Origin:*");
$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"web");
$conn = sqlsrv_connect($serverName, $connectionInfo);
$query="select password from t_userInfo where username='$username'";
$result=sqlsrv_query($conn,$query,array());
if(sqlsrv_has_rows($result)){
	$row=sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC);
	$fileType = mb_detect_encoding($row['password'], array('UTF-8','GBK','LATIN1','BIG5')) ;
	if( $fileType != 'UTF-8')
		$row = mb_convert_encoding($row,'UTF-8' , $fileType);
	if($row['password']==$pass){
		echo "<script>window.location.href='http://localhost:8080/index.html?username=$username';</script>";
	}
	else 
		{echo "<script>alert(\"用户名或密码或权限错误\");history.back(-1);</script>";}
}
else{
	echo "<script>alert(\"用户名不存在\");</script>";
}
// history.back(-1);
?>