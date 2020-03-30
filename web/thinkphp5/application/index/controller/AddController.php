<?php
namespace app\index\controller;
use app\common\model\Userinfo; //Index模型
use think\Controller;// 用于与V层进行数据传递
use think\Request;   
class AddController extends Controller
{
	public function signin(){
		$htmls=$this->fetch();
		return $htmls;
	}
	public function login(){
		$htmls=$this->fetch();
		return $htmls;
	}
	public function insert()
	{
		date_default_timezone_set('PRC');
		$postData=Request::instance()->post();
		// 实例化对象
		$time=date('Y-m-d h:i:sa', time());
		$UserInfo = new Userinfo();
		$result=$UserInfo::execute("insert into t_userinfo(username,password,sign_time,email) values(?,?,?,?)",[$postData['username'],$postData['password1'],$time,$postData['Emailaddr']]);
		if($result!=false)
		{
			// 反馈结果
			echo "<script type='text/javascript'>alert(\"注册成功\");history.go(-2);</script>";
			// return '新增成功。新增ID为:' . $UserInfo->userID;
		}
		else
		{
			echo "<script type='text/javascript'>alert(\"注册失败，请重新注册\");</script>";
		}
		
	}
	public function check(){
		// 接收post信息
		$postData = Request::instance()->post();
		// 验证用户名是否存在
		$map = array('username' => $postData['username']);
		$userInfo = Userinfo::get($map);
			// $Teacher要么是一个对象，要么是null。
		if (!is_null($userInfo)) {
		// 验证密码是否正确
			if ($userInfo->getData('password')!== $postData['pass']) {
				// 用户名密码错误，跳转到登录界面。
				return $this->error('password incrrect', url('login'));
			} else {
				// 用户名密码正确，将teacherId存session。
				session('userID', $userInfo->getData('userID'));
				return $this->success('login success', url('Index/index'));
			}
		} else {
			// 用户名不存在，跳转到登录界面。
			return $this->error('username not exist', url('login'));
		}
	}
	public function logOut()
	{
		if (Userinfo::logOut()) {
			session('userID',null);
			return $this->success('logout success', url('login'));
		} else {
			return $this->error('logout error', url('login'));
		}
	}
	public function invoice()
	{
		$userID=session('userID');
		$userinfo=Userinfo::where('userID',$userID)->find();
		$this->assign('userinfo',$userinfo);
  		$htmls=$this->fetch();
  		return $htmls;
	}
	public function cancel()
	{
		session('userID',null);
		echo "<script>alert(\"确定注销账号?\");</script>";
		// $user->delete();
		return $this->success('注销账号成功',url('signin'));
	}
	public function edit(){
		// echo "<script>alert(\"确定修改账号?\");</script>";
		$userID=session('userID');
		$user=Userinfo::get($userID);
		// return $this->success($user);
		$user->username=Request::instance()->post('edituserName');
		$user->email=Request::instance()->post('edituserEmail');
		$user->validate(true)->save();
    	return $this->success('修改成功');
    }
}
?>