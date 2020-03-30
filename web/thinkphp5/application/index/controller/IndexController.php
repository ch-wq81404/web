<?php
namespace app\index\controller;
use app\common\model\Index; //Index模型
use think\Controller;// 用于与V层进行数据传递
use app\common\model\Userinfo;
use app\common\model\Article;
use app\common\model\Comment;
use think\Request;
/**
* 首页管理，继承think\Controller后，就可以利用V层对数据进行打包了。
*/
class IndexController extends Controller
{
    public function index()
    {
		$Index=new Index();
		$newests=$Index::name('article')->order('date_time desc')->limit(3)->field('arID,autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment')->select();
		$hotests=$Index::name('article')->order('arheart desc')->limit(3)->field('arID,autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment')->select();
		if($newests!=false){
			// 向V层传数据
			$userID=session('userID');
			$this->assign('newests',$newests);
			$this->assign('hotests',$hotests);
			$this->assign('userID',$userID);
			// 取回打包后的数据
			$htmls=$this->fetch();
			// 将数据返回给用户
			return $htmls;
			// return $newests[0];
		}
		else
		{
			return "查询错误";
		}
		
    }
    public function kpl()
    { 
		try {
			$pageSize = 10; // 每页显示10条数据
			// 实例化Teacher
			$Article = new Article;
			// 调用分页
			$articles = Article::name('article')->field('arID,autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment')->order('arheart desc')->where('arsource',"王者荣耀")->paginate(10,100);
			// 向V层传数据
			$this->assign('arsource',"王者荣耀");
			$this->assign('articles', $articles);
			// 取回打包后的数据
			$htmls = $this->fetch();
			// 将数据返回给用户
			return $htmls;

			// 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
			} catch (\think\Exception\HttpResponseException $e) {
				throw $e;
			// 获取到正常的异常时，输出异常
			} catch (\Exception $e) {
				return $e->getMessage();
			}
    }
    public function pubg()
    {
    	try {
			// 每页显示10条数据
			// 实例化Teacher
			$Article = new Article;
			// 调用分页
			$articles = Article::name('article')->field('arID,autherID,title,convert(char,date_time,120) date_time,arsource,arheart,arcomment')->order('arheart desc')->where('arsource',"绝地求生")->paginate(10,100);
			// 向V层传数据
			$this->assign('arsource',"绝地求生");
			$this->assign('articles', $articles);
			// 取回打包后的数据
			$htmls = $this->fetch();
			// 将数据返回给用户
			return $htmls;
			// 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
			} catch (\think\Exception\HttpResponseException $e) {
				throw $e;
			// 获取到正常的异常时，输出异常
			} catch (\Exception $e) {
				return $e->getMessage();
			}
    }
    public function talk_detail()
    {
    	$userID=session('userID');
    	$arID = Request::instance()->param('arID/d');
    	$articledetail=Article::name('article')->field('arID,autherID,title,convert(char,date_time,100) date_time,arsource,artext,arheart,arcomment')->where('arID',$arID)->find();
    	$commentdetails=Comment::field('cotext,coheart,refercoID,convert(char,date_time,100) date_time,coID,userID')->where('arID',$arID)->paginate(10,100);
  		$this->assign('articledetail',$articledetail);
  		$this->assign('commentdetails',$commentdetails);
  		$htmls=$this->fetch();
  		return $htmls;
    }
    public function like_article()
    {
    	$arID=Request::instance()->param('arID/d');
    	$article=Article::name('article')->field('arheart')->where('arID',$arID)->find();
    	$article['arheart']=$article['arheart']+1;
    	$article->validate(true)->save();
    	echo "<script type='text/javascript'>history.go(-1);</script>";
    }
    public function like_comment()
    {
		$coID=Request::instance()->param('coID/d');
		$comment=Comment::name('comment')->field('coheart')->where('coID',$coID)->find();
		// $comment=Comment::get($coID);
    	$comment->coheart=$comment->coheart+1;
    	$comment->validate(true)->save();
    	echo "<script type='text/javascript'>history.go(-1);</script>";
    }
    public function error403()
    {
    	// 取回打包后的数据
			$htmls = $this->fetch();
			// 将数据返回给用户
			return $htmls;
    }
    public function search()
    {
    		$search=Request::instance()->post('search_value');
    		$searches1=Article::name('article')->where('title|artext','like','%'.$search.'%')->where('arsource','王者荣耀')->paginate(10,100);
    		$searches2=Article::name('article')->where('title|artext','like','%'.$search.'%')->where('arsource','绝地求生')->paginate(10,100);
	    	// $searches=Article::query("select * from t_article where title like ? or artext like ?",[$search,$search]);
	    	if(!is_null($searches1) && !is_null($searches2))
	    	{
	    		$this->assign('searches1',$searches1);
	    		$this->assign('searches2',$searches2);
	    		// $this->assign('arsource',null);
	    		//取回打包后的数据
				$htmls = $this->fetch();
				// 将数据返回给用户
				return $htmls;
	    	}
    }
}
?>