<?php
namespace app\common\model;
use think\Model;
/*
*Article 帖子表
*/
class Userinfo extends Model
{
	
	static public function logOut()
	{
		// 销毁session中数据
		session('teacherId', null);
		return true;
	}
}

?>
