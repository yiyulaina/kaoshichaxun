<?php
namespace app\index\controller;
//use think\View;
use app\index\controller\Check;

class Data extends Check{
    //成人高考数据列表
    public function index(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            if(!empty($_GET['username'])){
                $where['KSH|XM|SFZH'] = ['like','%'.$_GET['username'].'%'];
            }else{
                $where = '';
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])
                        ->where($where)
                        ->paginate(10,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }
    }
    //自学考试数据列表
    public function index_zxks(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            if(!empty($_GET['username'])){
                $where['KSH|XM|SFZH'] = ['like','%'.$_GET['username'].'%'];
            }else{
                $where = '';
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])
                        ->where($where)
                        ->paginate(10,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $sum = db($news['news_dbname'])->where($where)->sum('FS');
            $this -> assign('sum',$sum);
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }
    }

    //艺术类考试数据列表
    public function index_ysks(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            if(!empty($_GET['type'])){
                $where['type'] = ['eq',$_GET['type']];
            }else{
                $where['type'] = ['eq',1];
            }
            if(!empty($_GET['username'])){
                $where['KSH|XM|SFZH'] = ['like','%'.$_GET['username'].'%'];
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])
                        ->where($where)
                        ->paginate(10,false,[
                            'query' => array('number'=>$_GET['number'],'type'=>$_GET['type'])
                        ]);
            $sum = db($news['news_dbname'])->where($where)->sum('ZF');
            $this -> assign('sum',$sum);
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }
    }

    //成人高考录取
    public function index_crgk_lq(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            if(!empty($_GET['username'])){
                $where['KSH|XM|SFZH'] = ['like','%'.$_GET['username'].'%'];
            }else{
                $where = '';
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])
                        ->where($where)
                        ->paginate(10,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }
    }

    //成人高考录取
    public function index_zsxx(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            if(!empty($_GET['username'])){
                $where['KSH|XM|SFZH'] = ['like','%'.$_GET['username'].'%'];
            }else{
                $where = '';
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])
                        ->where($where)
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }
    }

    //成人高考修改信息
    public function update(){
        if($_POST){
            if(!empty($_POST['number'])){
                $id = $_POST['id'];
                $news = db('news')->where('news_id = '.$_POST['number'])->find();
                $data= db($news['news_dbname'])->where('id = '.$id)->find();
                if($data){
                    $data_up['KSH'] = $_POST['ksh'];
                    $data_up['XM'] = $_POST['xm'];
                    $data_up['SFZH'] = $_POST['sfzh'];
                    $data_up['KMM1'] = $_POST['km1'];
                    $data_up['KMM2'] = $_POST['km2'];
                    $data_up['KMM3'] = $_POST['km3'];
                    $data_up['KMM4'] = $_POST['km4'];
                    $data_up['FS1'] = $_POST['fs1'];
                    $data_up['FS2'] = $_POST['fs2'];
                    $data_up['FS3'] = $_POST['fs3'];
                    $data_up['FS4'] = $_POST['fs4'];
                    $data_up['FS'] = $_POST['zf'];
                    $body = db($news['news_dbname'])->where('id = '.$id)->update($data_up);
                    if($body){
                        echo "<script>alert('修改成功！');location.href='/index/data/index?number=".$_POST['number']."&page=".$_POST['page']."';</script>";
                        die;
                    }else{
                        $this -> error('无修改不能提交！');
                    }
                }else{
                    $this -> error('要修改的数据不存在！');
                }
            }else{
                $this -> error('找不到主体信息,请联系管理员！');
            }
        }
        if(!empty($_GET['number'])){
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])->where('id = '.$_GET['id'])->find();
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }

    
    //自学考试修改信息
    public function update_zxks(){
        if($_POST){
            if(!empty($_POST['number'])){
                $id = $_POST['id'];
                $news = db('news')->where('news_id = '.$_POST['number'])->find();
                $data= db($news['news_dbname'])->where('id = '.$id)->find();
                if($data){
                    $data_up['KSH'] = $_POST['ksh'];
                    $data_up['XM'] = $_POST['xm'];
                    $data_up['SFZH'] = $_POST['sfzh'];
                    $data_up['KMM'] = $_POST['km'];
                    $data_up['FS'] = $_POST['fs'];
                    $body = db($news['news_dbname'])->where('id = '.$id)->update($data_up);
                    if($body){
                        echo "<script>alert('修改成功！');location.href='/index/data/index_zxks?number=".$_POST['number']."&page=".$_POST['page']."';</script>";
                        die;
                    }else{
                        $this -> error('无修改不能提交！');
                    }
                }else{
                    $this -> error('要修改的数据不存在！');
                }
            }else{
                $this -> error('找不到主体信息,请联系管理员！');
            }
        }
        if(!empty($_GET['number'])){
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $body =   db($news['news_dbname'])->where('id = '.$_GET['id'])->find();
            $this -> assign('news',$news);
            $this -> assign('body',$body);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //数据删除
    public function del(){
        if(!empty($_GET['number'])){
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
                $news = db('news')->where('news_id = '.$_GET['number'])->find();
                $data= db($news['news_dbname'])->where('id = '.$_GET['id'])->find();
                if($data){
                    $body = db($news['news_dbname'])->where('id = '.$_GET['id'])->delete();
                    if($body){
                        $tz_url = array(
                            '1'=>'index',
                            '2'=>'index_zxks',
                            '3'=>'index_zsxx',
                            '4'=>'index_crgk_lq',
                            '5'=>'index_ysks',
                            );
                        echo "<script>alert('删除成功！');location.href='/index/data/".$tz_url[$news['news_type']]."?number=".$_GET['number']."&page=".$_GET['page']."';</script>";
                        die;
                    }else{
                        $this -> error('删除失败！');
                    }
                }else{
                    $this -> error('要删除的数据不存在！');
                }
            }else{
                $this -> error('未获取删除目标！');
            }
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //各科分数总和
    public function gkfszh(){
        if(empty($_GET['number'])){
            $this -> error('找不到主体信息,请联系管理员！');
        }else{
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $sum = db($news['news_dbname'])->field('KMM,sum(FS) as zs')->group('KMM')->select();
            $this -> assign('sum',$sum);
            return $this->fetch();
        }
    }
    
    
}
