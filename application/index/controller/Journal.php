<?php
namespace app\index\controller;
//use think\View;
use think\Controller;

class Journal extends Controller{
    //记录日志
    public function index(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            if(!empty($_GET['start'])&&!empty($_GET['end'])){
                $where['journal_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
            }
            if(!empty($_GET['username'])){
                $where['journal_message'] = ['like','%'.$_GET['username'].'%'];
            }
            if(!empty($_GET['type'])){
                $where['journal_sf'] = ['eq',($_GET['type']-1)];
            }
			
			
			//print_r($where);die;
            $where['journal_news_id'] = ['eq',$_GET['number']];
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $upload =   db('journal')
                        ->alias('a')
                        ->order('journal_id desc')
                        ->where($where)
                        ->paginate(10,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
			//查询人数
            $sum = db('journal')->where($where)->group('journal_message')->count();
			$this -> assign('sum',$sum);
            $this -> assign('news',$news);
            $this -> assign('upload',$upload);
            return $this->fetch();
        }
    }
    //记录日志
    public function record(){
        if(!empty($_POST)){
            $data['journal_news_id'] = $_POST['id'];
            $data['journal_system'] = $_POST['system'];
            $data['journal_ip'] = $_POST['url'];
            $data['journal_add'] = $_POST['add'];
            $data['journal_message'] = $_POST['xx'];
            $data['journal_addtime'] = time();
            $journal = db('journal')->insertGetId($data);
        }
    }
    
    //生成访问的静态页
    public function website(){
        if(!empty($_GET['number'])){
            $new = db('news')->alias('a')->field('a.*,i.type_dbname')->join('cx_type i','a.news_type = i.type_id')->where('news_id = '.$_GET['number'])->find();
            $query_type = explode(",",$new['news_query_type']);
            $content = Returnbody($query_type,$new);
            $html = mylog($content,$new['type_dbname'],$new['news_id'].'.php');
            if(!$html){
                return 0;
            }
            $content = Returnindex($query_type,$new);
            $html = mylog($content,$new['type_dbname'],$new['news_id'].'.html');
            if(!$html){
                return 0;
            }
            return 1;
        }
    }

	//导入redis
    public function redis_dr(){
        if(!empty($_GET['number'])){
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            if($news['news_type']==3){
                $data = db($news['news_dbname'])->select();
            }else{
                if($news['news_type']==2){
                    $data = db($news['news_dbname'])->field(['KSH','XM','SFZH','concat(group_concat(KMM),"|",group_concat(0+CAST(FS as CHAR)),"|",group_concat(type))'=>'cj'])->group('KSH')->select();
                }else if($news['news_type']==11){
                    $data = db($news['news_dbname'])->field(['KSH','XM','SFZH','JCKCJ','concat(group_concat(KM),"|",group_concat(ZYFX),"|",group_concat(ZMH),"|",group_concat(ZF))'=>'cj'])->group('KSH')->select();
                }else{
                    $data = db($news['news_dbname'])->select();
                }
            }
            $query_type = explode(",",$news['news_query_type']);
            $cr = redis_cr($data,$news['news_type'],$query_type);
			if($cr == '已导入完成'){
				return 1;
			}else{
				return 0;
			}
        }
    }
}
