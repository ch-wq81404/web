<?php
namespace app\index\controller;
use app\common\model\Userinfo;
use app\common\model\Comment;
use app\common\model\Article;
use think\Controller;// 用于与V层进行数据传递
use think\Request;   
class ReleaseController extends Controller
{
	public function relea_comment()
	{

		$comment=Request::instance()->post('mycomment');
		$arID=Request::instance()->param('arID/d');
		$userID=session('userID');
		$time=date('Y-m-d h:i:sa', time());
		$coheart=0;
		$refercoID=0;
		// return $this->success($arID.$comment.$coheart.$time.$refercoID.$userID);
		$result=UserInfo::execute("insert into t_comment(arID,cotext,coheart,date_time,refercoID,userID) values(?,?,?,?,?,?)",[$arID,$comment,$coheart,$time,$refercoID,$userID]);
		if($result!=false)
		{
	    	$article=Article::where('arID',$arID)->find();
	    	$article->arcomment=$article->arcomment+1;
	    	$article->validate(true)->save();
			// 反馈结果
			echo "<script type='text/javascript'>history.go(-1);</script>";
		}
		else
		{
			echo "<script type='text/javascript'>alert(\"发送失败\");</script>";
		}

	}
	public function relea_article()
	{
		$arsource=Request::instance()->param('arsource');
		$title=Request::instance()->post('title');
		$artext=Request::instance()->post('artext');
		$userID=session('userID');
		$time=date('Y-m-d h:i:sa', time());
		$arheart=0;
		$arcomment=0;
		// return $this->success($arsource);
		$new=new Article();
		$new->title=$title;
		$new->artext=$artext;
		$new->date_time=$time;
		$new->autherID=$userID;
		$new->arheart=0;
		$new->arcomment=0;
		$new->arsource=$arsource;
		$result = $new->validate(true)->save();
		if($result!=false)
		{
	    	$user=Userinfo::get($userID);
	    	$user->articlenum=$user->articlenum+1;
	    	$user->validate(true)->save();
	    	$new_result=Article::where('title',$title)->find();
			// 反馈结果
			return $this->success('发表成功',url('index/talk_detail',['arID'=>$new_result->getData('arID')]));
			
		}
		else
		{
			echo "<script type='text/javascript'>alert(\"发送失败\");</script>";
		}

	}
	public function form_common()
    {
    	$arsource=Request::instance()->param('arsource');
    	$this->assign('arsource',$arsource);
    	// return $this->success($arsource);
    	// 取回打包后的数据
		$htmls = $this->fetch();
		// 将数据返回给用户
		return $htmls;
    }
}

?>