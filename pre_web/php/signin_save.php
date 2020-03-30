<?php
// error_reporting(0);
date_default_timezone_set('PRC');

$serverName = "127.0.0.1";//数据库服务器地址
$uid = "sa";//数据库用户名
$pwd = "123456";//数据库密码
$username=$_POST["username"];
$connectionInfo = array("UID"=>$uid, "PWD"=>$pwd, "Database"=>"web");
$conn = sqlsrv_connect($serverName, $connectionInfo);
echo "<script type='text/javascript'>console.log(\"$username\");</script>";
$query="select userID from t_userInfo where username='$username'";
$result=sqlsrv_query($conn,$query,array());
if(sqlsrv_has_rows($result))
{
	echo "<script type='text/javascript'>alert('用户名已存在');location='javascript:history.back()';</script>";
}
else
{
	$time=date('Y-m-d h:i:s', time());
	$password=$_POST["password1"];
	$Email=$_POST["Emailaddr"];
	$query="insert into t_userInfo(username,password,sign_time,email) values('$username','$password','$time','$Email')";
	$result=sqlsrv_query($conn,$query);
	if(sqlsrv_rows_affected($result)==1)
	{
		echo "<script type='text/javascript'>alert(\"注册成功\");history.go(-2);</script>";
	}
	elseif(sqlsrv_rows_affected($result)==false)
		echo "查询错误";
	else
		echo "查询行数为其他值"; 
}
?>