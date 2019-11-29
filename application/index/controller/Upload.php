<?php
namespace app\index\controller;
//use think\View;
use app\index\controller\Check;

class Upload extends Check{
    
    //成人高考成绩列表
    public function index(){
        if(!empty($_GET['start'])&&!empty($_GET['end'])){
            $where['news_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
        }
        if(!empty($_GET['username'])){
            $where['news_title'] = ['like','%'.$_GET['username'].'%'];
        }
        $where['news_type'] = ['eq',1];
        $where['news_if'] = ['eq',0];
        $upload =   db('news')
                    ->alias('a')
                    ->order('news_id desc')
                    ->where($where)
                    ->paginate(10,false,[
                    ]);
        //print_r(db('news')->getLastSql());die;
        $this -> assign('upload',$upload);
        return $this->fetch('');
    }
    
    //自学考试成绩列表
    public function index_zxks(){
        if(!empty($_GET['start'])&&!empty($_GET['end'])){
            $where['news_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
        }
        if(!empty($_GET['username'])){
            $where['news_title'] = ['like','%'.$_GET['username'].'%'];
        }
        $where['news_type'] = ['eq',2];
        $where['news_if'] = ['eq',0];
        $upload =   db('news')
                    ->alias('a')
                    ->order('news_id desc')
                    ->where($where)
                    ->paginate(10,false,[
                    ]);
        $this -> assign('upload',$upload);
        return $this->fetch();
    }
    
    
    //研究生考场信息列表
    public function index_zsxx(){
        if(!empty($_GET['start'])&&!empty($_GET['end'])){
            $where['news_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
        }
        if(!empty($_GET['username'])){
            $where['news_title'] = ['like','%'.$_GET['username'].'%'];
        }
        $where['news_type'] = ['eq',3];
        $where['news_if'] = ['eq',0];
        $upload =   db('news')
                    ->alias('a')
                    ->order('news_id desc')
                    ->where($where)
                    ->paginate(10,false,[
                    ]);
        $this -> assign('upload',$upload);
        return $this->fetch();
    }
    
    
    //成人高考录取列表
    public function index_crgk_lq(){
        if(!empty($_GET['start'])&&!empty($_GET['end'])){
            $where['news_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
        }
        if(!empty($_GET['username'])){
            $where['news_title'] = ['like','%'.$_GET['username'].'%'];
        }
        $where['news_type'] = ['eq',4];
        $where['news_if'] = ['eq',0];
        $upload =   db('news')
                    ->alias('a')
                    ->order('news_id desc')
                    ->where($where)
                    ->paginate(10,false,[
                    ]);
        $this -> assign('upload',$upload);
        return $this->fetch('');
    }
    
    //艺术类考试成绩列表  
    public function index_ysks(){
        if(!empty($_GET['start'])&&!empty($_GET['end'])){
            $where['news_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
        }
        if(!empty($_GET['username'])){
            $where['news_title'] = ['like','%'.$_GET['username'].'%'];
        }
        $where['news_type'] = ['eq',5];
        $where['news_if'] = ['eq',0];
        $upload =   db('news')
                    ->alias('a')
                    ->order('news_id desc')
                    ->where($where)
                    ->paginate(10,false,[
                    ]);
        $this -> assign('upload',$upload);
        return $this->fetch();
    }
    
    //创建信息主体
    public function add(){
        if($_POST){
            if($_POST['go'] == 1){
                if(empty($_POST['number'])){
                    $this -> error('找不到主体信息,请联系管理员！');
                }
                if(empty($_POST['title'])){
                    $this -> error('请填写信息内容标题！');
                }
                $data['news_title'] = $_POST['title'];
                $data['news_body'] = $_POST['desc'];
                $update = db('news')->where('news_id = '.$_POST['number'])->update($data);
                if($update){
                    $news = db('news')->where('news_id = '.$_POST['number'])->find();
                    $tz_url = array(
                                    '1'=>'index',
                                    '2'=>'index_zxks',
                                    '3'=>'index_zsxx',
                                    '4'=>'index_crgk_lq',
                                    '5'=>'index_ysks',
                                    );
                    echo "<script>alert('修改成功！');location.href='/index/upload/".$tz_url[$news['news_type']]."';</script>";
                    die;
                }else{
                    $this -> error('信息未修改，不能提交！');
                }
            }
            if(empty($_POST['class'])){
                $this -> error('请选择主体类型！');
            }
            if(empty($_POST['title'])){
                $this -> error('请填写信息内容标题！');
            }
            $type = db('type')->where('type_id = '.$_POST['class'])->find();
            $data['news_title'] = $_POST['title'];
            $data['news_addtime'] = time();
            $data['news_type'] = $_POST['class'];
            $data['news_body'] = $_POST['desc'];
            $number = db('news')->insertGetId($data);
            if($number){
                if($_POST['class'] == 1){
                    $data_save['news_dbname'] = 'cx_'.$type['type_dbname'].'_'.$number;
                    $sql_add =  "CREATE TABLE IF NOT EXISTS `".$data_save['news_dbname']."` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `KSH` VARCHAR (20) NOT NULL COMMENT '考生号',
                            `ZKZH` VARCHAR (20) NOT NULL COMMENT '准考证号',
                            `XM` VARCHAR (100) NOT NULL COMMENT '姓名',
                            `KM1` int (11) NOT NULL COMMENT '科目1',
                            `KM2` int (11) NOT NULL COMMENT '科目2',
                            `KM3` int (11) NOT NULL COMMENT '科目3',
                            `KM4` int (11) NOT NULL COMMENT '科目4',
                            `KMM1` VARCHAR (50) NOT NULL COMMENT '科目名1',
                            `KMM2` VARCHAR (50) NOT NULL COMMENT '科目名2',
                            `KMM3` VARCHAR (50) NOT NULL COMMENT '科目名3',
                            `KMM4` VARCHAR (50) NOT NULL COMMENT '科目名4',
                            `FS1` float (6,1) NOT NULL COMMENT '分数1',
                            `FS2` float (6,1) NOT NULL COMMENT '分数2',
                            `FS3` float (6,1) NOT NULL COMMENT '分数3',
                            `FS4` float (6,1) NOT NULL COMMENT '分数4',
                            `SFZH` CHAR (18) NOT NULL COMMENT '身份证号',
                            `FS` float (6,1) NOT NULL  COMMENT '总分',
                              PRIMARY KEY (`id`),
                              KEY `KSH` (`KSH`) USING BTREE,
                              KEY `XM` (`XM`) USING BTREE,
                              KEY `SFZH` (`SFZH`) USING BTREE
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='".$_POST['title']."';";
                    $add = db()->execute($sql_add);
                    $data_save['news_dbname'] = $type['type_dbname'].'_'.$number;
                    $news = db('news')->where('news_id = '.$number)->update($data_save);
                    if($news){
                        echo "<script>location.href='/index/upload/time?number=$number';</script>";
                        die;
                    }else{
                        $this -> error('创建考生表失败 , 请联系管理员！');
                    }
                    
                }else if($_POST['class'] == 2){
                    $data_save['news_dbname'] = 'cx_'.$type['type_dbname'].'_'.$number;
                    $sql_add =  "CREATE TABLE IF NOT EXISTS `".$data_save['news_dbname']."` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `KSH` VARCHAR (20) NOT NULL COMMENT '考生号',
                            `XM` VARCHAR (100) NOT NULL COMMENT '姓名',
                            `KM` VARCHAR (11) NOT NULL COMMENT '科目',
                            `KMM` VARCHAR (50) NOT NULL COMMENT '科目名',
                            `FS` float (6,1) NOT NULL COMMENT '分数',
                            `SFZH` CHAR (18) NOT NULL COMMENT '身份证号',
                            `type` TINYINT (1) NOT NULL COMMENT '类型 1 = 基础课  2 = 实践课',
                              PRIMARY KEY (`id`),
                              KEY `KSH` (`KSH`) USING BTREE,
                              KEY `XM` (`XM`) USING BTREE,
                              KEY `SFZH` (`SFZH`) USING BTREE
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='".$_POST['title']."';";
                    $add = db()->execute($sql_add);
                    $data_save['news_dbname'] = $type['type_dbname'].'_'.$number;
                    $news = db('news')->where('news_id = '.$number)->update($data_save);
                    if($news){
                        echo "<script>location.href='/index/upload/time?number=$number';</script>";
                        die;
                    }else{
                        $this -> error('创建考生表失败 , 请联系管理员！');
                    }
                    
                }else if($_POST['class'] == 4){
                    $data_save['news_dbname'] = 'cx_'.$type['type_dbname'].'_'.$number;
                    $sql_add =  "CREATE TABLE IF NOT EXISTS `".$data_save['news_dbname']."` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `KSH` VARCHAR (20) NOT NULL COMMENT '考生号',
                            `XM` VARCHAR (100) NOT NULL COMMENT '姓名',
                            `CCDM` VARCHAR (1) NOT NULL COMMENT '层次代码',
                            `CCMC` VARCHAR (20) NOT NULL COMMENT '层次名称',
                            `YXDM` VARCHAR (5) NOT NULL COMMENT '院校代码',
                            `YXMC` VARCHAR (64) NOT NULL COMMENT '院校名称',
                            `ZYDM` VARCHAR (6) NOT NULL COMMENT '专业代码',
                            `ZYMC` VARCHAR (64) NOT NULL COMMENT '专业名称',
                            `XZNX` VARCHAR (40) NOT NULL COMMENT '学制年限',
                            `SFZH` CHAR (18) NOT NULL COMMENT '身份证号',
                              PRIMARY KEY (`id`),
                              KEY `KSH` (`KSH`) USING BTREE,
                              KEY `XM` (`XM`) USING BTREE,
                              KEY `SFZH` (`SFZH`) USING BTREE
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='".$_POST['title']."';";
                    $add = db()->execute($sql_add);
                    $data_save['news_dbname'] = $type['type_dbname'].'_'.$number;
                    $news = db('news')->where('news_id = '.$number)->update($data_save);
                    if($news){
                        echo "<script>location.href='/index/upload/time?number=$number';</script>";
                        die;
                    }else{
                        $this -> error('创建考生表失败 , 请联系管理员！');
                    }
                    
                }else if($_POST['class'] == 5){
                    $data_save['news_dbname'] = 'cx_'.$type['type_dbname'].'_'.$number;
                    $sql_add =  "CREATE TABLE IF NOT EXISTS `".$data_save['news_dbname']."` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `KSH` CHAR (14) NOT NULL COMMENT '考生号',
                            `XM` CHAR (50) NOT NULL COMMENT '姓名',
                            `KM1` float (6,1) NOT NULL COMMENT '科目1',
                            `KM2` float (6,1) NOT NULL COMMENT '科目2',
                            `KM3` float (6,1) NOT NULL COMMENT '科目3',
                            `KM4` float (6,1) NOT NULL COMMENT '科目4',
                            `KMM1` CHAR (50) NOT NULL COMMENT '科目名1',
                            `KMM2` CHAR (50) NOT NULL COMMENT '科目名2',
                            `KMM3` CHAR (50) NOT NULL COMMENT '科目名3',
                            `KMM4` CHAR (50) NOT NULL COMMENT '科目名4',
                            `KM` CHAR (10) NOT NULL COMMENT '美术科目',
                            `ZYFX` CHAR (10) NOT NULL COMMENT '专业方向',
                            `ZMH` CHAR (15) NOT NULL COMMENT '专门化',
                            `JCKCJ` CHAR (15) NOT NULL COMMENT '基础课成绩',
                            `ZF` float (6,1) NOT NULL COMMENT '分数',
                            `SFZH` CHAR (18) NOT NULL COMMENT '身份证号',
                            `type` TINYINT (1) NOT NULL COMMENT '专业分类 1 = 音乐舞蹈  2 = 美术  3 = 表演  4 = 导演  5 = 播音主持  6 =  戏剧 7 = 编导',
                              PRIMARY KEY (`id`),
                              KEY `KSH` (`KSH`) USING BTREE,
                              KEY `XM` (`XM`) USING BTREE,
                              KEY `SFZH` (`SFZH`) USING BTREE
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='".$_POST['title']."';";
                    $add = db()->execute($sql_add);
                    $data_save['news_dbname'] = $type['type_dbname'].'_'.$number;
                    $news = db('news')->where('news_id = '.$number)->update($data_save);
                    if($news){
                        echo "<script>location.href='/index/upload/time?number=$number';</script>";
                        die;
                    }else{
                        $this -> error('创建考生表失败 , 请联系管理员！');
                    }
                    
                }
            }else{
                $this -> error('创建信息内容失败 , 请联系管理员！');
            }
        }
        if(!empty($_GET['go'])){
            if(!empty($_GET['number'])){
                $news = db('news')->where('news_id = '.$_GET['number'])->find();
                $this -> assign('news',$news);
                $this -> assign('go',$_GET['go']);
                $this -> assign('number',$_GET['number']);
            }
        }else{
            $this -> assign('go',0);
        }
        $type = db('type')->select();
        $this -> assign('type',$type);
        return $this->fetch();
    }
    
    //研究生项目添加页
    public function zzxx_add(){
        if($_POST){
            if($_POST['go'] == 1){
                if(empty($_POST['number'])){
                    $this -> error('找不到主体信息,请联系管理员！');
                }
                if(empty($_POST['title'])){
                    $this -> error('请填写信息内容标题！');
                }
                $data['news_title'] = $_POST['title'];
                $update = db('news')->where('news_id = '.$_POST['number'])->update($data);
                if($update){
                    $news = db('news')->where('news_id = '.$_POST['number'])->find();
                    if($news['news_type']==3){
                        echo "<script>alert('修改成功！');location.href='".url('index/upload/index_zsxx')."';</script>";
                    }
                    die;
                }else{
                    $this -> error('信息未修改，不能提交！');
                }
            }
            if(empty($_POST['class'])){
                $this -> error('请选择主体类型！');
            }
            if(empty($_POST['title'])){
                $this -> error('请填写信息内容标题！');
            }
            $type = db('type')->where('type_id = '.$_POST['class'])->find();
            $data['news_title'] = $_POST['title'];
            $data['news_addtime'] = time();
            $data['news_type'] = $_POST['class'];
            $data['news_query_type'] = '1,3';
            $number = db('news')->insertGetId($data);
            if($number){
                if($_POST['class'] == 3){
                    $data_save['news_dbname'] = 'cx_'.$type['type_dbname'].'_'.$number;
                    $sql_add =  "CREATE TABLE IF NOT EXISTS `".$data_save['news_dbname']."` (
                            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                            `FP` tinyint (1) NOT NULL COMMENT '',
                            `KSH` VARCHAR (20) NOT NULL COMMENT '考生号',
                            `BMH` VARCHAR (20) NOT NULL COMMENT '报名号',
                            `XM` VARCHAR (100) NOT NULL COMMENT '姓名',
                            `ZJLX` CHAR (2) NOT NULL COMMENT '证件类型',
                            `SFZH` CHAR (18) NOT NULL COMMENT '证件号码',
                            `KSFSM` CHAR (2) NOT NULL COMMENT '考试方式码',
                            `KSFSMC` CHAR (40) NOT NULL COMMENT '考试方式名称',
                            `BMDDM` CHAR (4) NOT NULL COMMENT '报名地点码',
                            `BMDMC` CHAR (40) NOT NULL COMMENT '报名地点名称',
                            `BKDWDM` CHAR (5) NOT NULL COMMENT '报考单位码',
                            `BKDWMC` CHAR (32) NOT NULL COMMENT '报考单位名称',
                            `BKZYDM` CHAR (6) NOT NULL COMMENT '报考专业代码',
                            `BKZYMC` CHAR (40) NOT NULL COMMENT '报考专业名称',
                            `ZZLLKD` CHAR (64) NOT NULL COMMENT '',
                            `ZZLLKDDZ` CHAR (64) NOT NULL COMMENT '',
                            `ZZLLZKZH` CHAR (10) NOT NULL COMMENT '',
                            `ZZLLKSRQ` CHAR (32) NOT NULL COMMENT '',
                            `ZZLLKCBH` CHAR (8) NOT NULL COMMENT '',
                            `ZZLLZWH` CHAR (2) NOT NULL COMMENT '',
                            `ZZLLM` CHAR (3) NOT NULL COMMENT '',
                            `ZZLLMC` CHAR (32) NOT NULL COMMENT '政治理论',
                            `WGYKD` CHAR (64) NOT NULL COMMENT '',
                            `WGYKDDZ` CHAR (64) NOT NULL COMMENT '',
                            `WGYZKZH` CHAR (10) NOT NULL COMMENT '',
                            `WGYKSRQ` CHAR (32) NOT NULL COMMENT '',
                            `WGYKCBH` CHAR (8) NOT NULL COMMENT '',
                            `WGYZWH` CHAR (10) NOT NULL COMMENT '',
                            `WGYM` CHAR (3) NOT NULL COMMENT '',
                            `WGYMC` CHAR (32) NOT NULL COMMENT '英语一',
                            `YWK1KD` CHAR (64) NOT NULL COMMENT '',
                            `YWK1KDDZ` CHAR (64) NOT NULL COMMENT '',
                            `YWK1ZKZH` CHAR (10) NOT NULL COMMENT '',
                            `YWK1KSRQ` CHAR (32) NOT NULL COMMENT '',
                            `YWK1KCBH` CHAR (8) NOT NULL COMMENT '',
                            `YWK1ZWH` CHAR (2) NOT NULL COMMENT '',
                            `YWK1M` CHAR (3) NOT NULL COMMENT '',
                            `YWK1MC` CHAR (32) NOT NULL COMMENT '',
                            `YWK2KD` CHAR (64) NOT NULL COMMENT '科一',
                            `YWK2KDDZ` CHAR (64) NOT NULL COMMENT '',
                            `YWK2ZKZH` CHAR (10) NOT NULL COMMENT '',
                            `YWK2KSRQ` CHAR (32) NOT NULL COMMENT '',
                            `YWK2KCBH` CHAR (8) NOT NULL COMMENT '',
                            `YWK2ZWH` CHAR (2) NOT NULL COMMENT '',
                            `YWK2M` CHAR (3) NOT NULL COMMENT '',
                            `YWK2MC` CHAR (32) NOT NULL COMMENT '科二',
                            `ZZLLKDBH` CHAR (6) NOT NULL COMMENT '政治理论考点编号',
                            `WGYKDBH` CHAR (6) NOT NULL COMMENT '英语一考点编号',
                            `YWK1KDBH` CHAR (6) NOT NULL COMMENT '科一考点编号',
                            `YWK2KDBH` CHAR (6) NOT NULL COMMENT '科二考点编号',
                              PRIMARY KEY (`id`),
                              KEY `KSH` (`KSH`) USING BTREE,
                              KEY `XM` (`XM`) USING BTREE,
                              KEY `SFZH` (`SFZH`) USING BTREE
                            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='".$_POST['title']."';";
                    $add = db()->execute($sql_add);
                    $data_save['news_dbname'] = $type['type_dbname'].'_'.$number;
                    $news = db('news')->where('news_id = '.$number)->update($data_save);
                    if($news){
                        echo "<script>location.href='".url('index/upload/zzxx_yd_add')."?number=$number';</script>";
                        die;
                    }else{
                        $this -> error('创建考生表失败 , 请联系管理员！');
                    }
                    
                }
            }else{
                $this -> error('创建信息内容失败 , 请联系管理员！');
            }
        }
        if(!empty($_GET['go'])){
            if(!empty($_GET['number'])){
                $news = db('news')->where('news_id = '.$_GET['number'])->find();
                $this -> assign('news',$news);
                $this -> assign('go',$_GET['go']);
                $this -> assign('number',$_GET['number']);
            }
        }else{
            $this -> assign('go',0);
        }
        $type = db('type')->select();
        $this -> assign('type',$type);
        return $this->fetch();
    }
    
    //研究生阅读添加页
    public function zzxx_yd_add(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            $news = db('news')->where('news_id = '.$_POST['number'])->find();
            if($_POST['go']==1){
                echo "<script>alert('编辑完成！');location.href='".url('index/upload/index_zsxx')."';</script>";
                die;
            }else{
                echo "<script>location.href='".url('index/upload/time')."?number=".$_POST['number']."';</script>";
                die;
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $read =   db('read')
                        ->alias('a')
                        ->field('a.*,i.news_title')
                        ->join('cx_news i','a.read_new_id = i.news_id')
                        ->where('read_new_id = '.$_GET['number'])
                        ->order('read_id desc')
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('read',$read);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //研究生阅读修改页
    public function zzxx_yd_update(){
        if($_POST){
            if(empty($_POST['id'])){
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '找不到修改项,请联系管理员！';
                return json($data);die;
            }
            $data['read_title'] = $_POST['title'];
            $data['read_body'] = $_POST['desc'];
            $data['read_name'] = $_POST['name'];
            $data['read_sort'] = $_POST['sort']?$_POST['sort']:0;
            $read = db('read')->where('read_id = '.$_POST['id'])->update($data);
            if($read){
                // 上传成功
                $data['type'] = 1;
                return json($data);die;
            }else{
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '无修改不能提交！';
                return json($data);die;
            }
        }
        if(!empty($_GET['id'])){
            $read = db('read')->where('read_id = '.$_GET['id'])->find();
            $this -> assign('read',$read);
            $this -> assign('id',$_GET['id']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //上传主体时间页
    public function time(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            if(empty($_POST['start'])){
                $this -> error('请填写开始时间！');
            }
            if(empty($_POST['end'])){
                $this -> error('请填写结束时间！');
            }
            $data['news_start_time'] = strtotime($_POST['start']);
            $data['news_end_time'] = strtotime($_POST['end']);
            $update = db('news')->where('news_id = '.$_POST['number'])->update($data);
            if($update){
                if($_POST['go']==1){
                    echo "<script>location.href='/index/upload/website?number=".$_POST['number']."&&go=1';</script>";
                    die;
                }else{
                    $news = db('news')->where('news_id = '.$_POST['number'])->find();
                    if($news['news_type']==1||$news['news_type']==2){
                        echo "<script>location.href='/index/upload/crgk_km_upload?number=".$_POST['number']."';</script>";
                    }else if($news['news_type']==3){
                        echo "<script>location.href='".url('index/upload/zsxx_xx_upload')."?number=".$_POST['number']."';</script>";
                    }else if($news['news_type']==4){
                        echo "<script>location.href='/index/upload/crgk_lq_upload?number=".$_POST['number']."';</script>";
                    }else{
                        echo "<script>location.href='/index/upload/crgk_cj_upload?number=".$_POST['number']."';</script>";
                    }
                    die;
                }
            }else{
                $this -> error('时间未修改，不能提交！');
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
                $news = db('news')->where('news_id = '.$_GET['number'])->find();
                $this -> assign('news',$news);
            }else{
                $go = 0;
            }
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //成人高考科目上传页
    public function crgk_km_upload(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            $news = db('news')->where('news_id = '.$_POST['number'])->find();
            if($_POST['go']==1){
                if($news['news_type']==1){
                    echo "<script>location.href='/index/upload/crgk_cj_upload?number=".$_POST['number']."&&go=1';</script>";
                }else if($news['news_type']==2){
                    echo "<script>location.href='/index/upload/zxks_jc_upload?number=".$_POST['number']."&&go=1';</script>";
                }
                die;
            }else{
                if($news['news_type']==1){
                    echo "<script>location.href='/index/upload/crgk_cj_upload?number=".$_POST['number']."';</script>";
                }else if($news['news_type']==2){
                    echo "<script>location.href='/index/upload/zxks_jc_upload?number=".$_POST['number']."';</script>";
                }
                die;
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $upload =   db('upload_files')
                        ->alias('a')
                        ->field('a.*,i.news_title')
                        ->join('cx_news i','a.upload_files_news_id = i.news_id')
                        ->where('upload_files_news_id = '.$_GET['number'])
                        ->order('upload_files_id desc')
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('news',$news);
            $this -> assign('upload',$upload);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //成人高考录取信息上传页
    public function crgk_lq_upload(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            $news = db('news')->where('news_id = '.$_POST['number'])->find();
            if($_POST['go']==1){
                echo "<script>location.href='/index/upload/index_crgk_lq?number=".$_POST['number']."&&go=1';</script>";
                die;
            }else{
                echo "<script>location.href='/index/upload/custom_query?number=".$_POST['number']."';</script>";
                die;
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $upload =   db('upload_files')
                        ->alias('a')
                        ->field('a.*,i.news_title')
                        ->join('cx_news i','a.upload_files_news_id = i.news_id')
                        ->where('upload_files_news_id = '.$_GET['number'])
                        ->order('upload_files_id desc')
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('upload',$upload);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //招生信息上传页
    public function zsxx_xx_upload(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            $news = db('news')->where('news_id = '.$_POST['number'])->find();
            if($_POST['go']==1){
                echo "<script>alert('编辑完成！');location.href='".url('index/upload/index_zsxx')."';</script>";
                die;
            }else{
                echo "<script>location.href='".url('index/upload/website')."?number=".$_POST['number']."';</script>";
                die;
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $upload =   db('upload_files')
                        ->alias('a')
                        ->field('a.*,i.news_title')
                        ->join('cx_news i','a.upload_files_news_id = i.news_id')
                        ->where('upload_files_news_id = '.$_GET['number'])
                        ->order('upload_files_id desc')
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('upload',$upload);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //自学考试基础表上传页
    public function zxks_jc_upload(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            if($_POST['go']==1){
                echo "<script>location.href='/index/upload/crgk_cj_upload?number=".$_POST['number']."&&go=1';</script>";
                die;
            }else{
                echo "<script>location.href='/index/upload/crgk_cj_upload?number=".$_POST['number']."';</script>";
                die;
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $upload =   db('upload_files')
                        ->alias('a')
                        ->field('a.*,i.news_title')
                        ->join('cx_news i','a.upload_files_news_id = i.news_id')
                        ->where('upload_files_news_id = '.$_GET['number'])
                        ->order('upload_files_id desc')
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('upload',$upload);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //成人高考cj上传页
    public function crgk_cj_upload(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            if($_POST['go']==1){
                $news = db('news')->where('news_id = '.$_POST['number'])->find();
                $tz_url = array(
                                '1'=>'index',
                                '2'=>'index_zxks',
                                '3'=>'index_zsxx',
                                '4'=>'index_crgk_lq',
                                '5'=>'index_ysks',
                                );
                echo "<script>alert('修改成功！');location.href='/index/upload/".$tz_url[$news['news_type']]."';</script>";
                die;
            }else{
                echo "<script>location.href='/index/upload/custom_query?number=".$_POST['number']."';</script>";
                die;
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            $upload =   db('upload_files')
                        ->alias('a')
                        ->field('a.*,i.news_title')
                        ->join('cx_news i','a.upload_files_news_id = i.news_id')
                        ->where('upload_files_news_id = '.$_GET['number'])
                        ->order('upload_files_id desc')
                        ->paginate(6,false,[
                            'query' => array('number'=>$_GET['number'])
                        ]);
            $this -> assign('news',$news);
            $this -> assign('upload',$upload);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //自定义查询项
    public function custom_query(){
        if($_POST){
            if(empty($_POST['number'])){
                $this -> error('找不到主体信息,请联系管理员！');
            }
            if(empty($_POST['class'])){
                $this -> error('请选择自定义查询项！');
            }
            $str = '';
            foreach($_POST['class'] as $key => $value){
                $str .=','.$value;
            }
            $str = trim($str,',');
            $data['news_query_type'] = $str;
            $update = db('news')->where('news_id = '.$_POST['number'])->update($data);
            if($update){
                if($_POST['go']==1){
                    echo "<script>location.href='/index/upload/website?number=".$_POST['number']."&&go=1';</script>";
                    die;
                }else{
                    echo "<script>location.href='/index/upload/website?number=".$_POST['number']."';</script>";
                    die;
                }
            }else{
                $this -> error('查询条件未修改，不能提交！');
            }
        }
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
                $news = db('news')->where('news_id = '.$_GET['number'])->find();
                $news = explode(",",$news['news_query_type']);
                $this -> assign('news',$news);
            }else{
                $news = array();
                $this -> assign('news',$news);
                $go = 0;
            }
            $class = db('class')->select();
            $this -> assign('class',$class);
            $this -> assign('go',$go);
            $this -> assign('number',$_GET['number']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    
    //获取发布信息URL
    public function website(){
        if(!empty($_GET['number'])){
            if(!empty($_GET['go'])){
                $go = 1;
            }else{
                $go = 0;
            }
            $new = db('news')->alias('a')->field('a.*,i.type_dbname')->join('cx_type i','a.news_type = i.type_id')->where('news_id = '.$_GET['number'])->find();
            if($new['news_start_time'] == 0||$new['news_end_time'] == 0){
                echo "<script>alert('请填写查询时间段！');location.href='/index/upload/time?number=".$_GET['number']."&&go=".$go."';</script>";
                die;
            }
            if($new['news_type']==3){
                $url = 'http://'.$_SERVER['SERVER_NAME'].url('index/message/index').'?id='.$_GET['number'];
                $data_news['news_url'] = $url;
                $update = db('news')->where('news_id = '.$_GET['number'])->update($data_news);
                $this -> assign('type',$new['news_type']);
                $this -> assign('url',$url);
                $this -> assign('go',$go);
                return $this->fetch();
            }
            if(empty($new['news_query_type'])){
                echo "<script>alert('请先选择显示条件！');location.href='/index/upload/custom_query?number=".$_GET['number']."&&go=".$go."';</script>";
                die;
            }
            $query_type = explode(",",$new['news_query_type']);
            $content = Returnbody($query_type,$new);
            $html = mylog($content,$new['type_dbname'],$new['news_id'].'.php');
            if(!$html){
                $this -> error('生成url失败,请联系管理员！');
            }
            $content = Returnindex($query_type,$new);
            $html = mylog($content,$new['type_dbname'],$new['news_id'].'.html');
            if(!$html){
                $this -> error('生成url失败,请联系管理员！');
            }
            $urls = db('ip')->select();
            foreach ($urls as $key => $value) {
                $re = curl_get_https('http://'.$value['ip_url'].'/index/journal/website?number='.$_GET['number']);
				$err='';
                if($re==0){
                    $err .= $value['ip_url'].',';
                }
            }
            if(!empty($err)){
                $this -> error($err.'虚拟机生成url失败,请从新生成！');
            }
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/runtime/'.$new['type_dbname'].'/'.$new['news_id'].'.html';
            $data_news['news_url'] = $url;
            $update = db('news')->where('news_id = '.$_GET['number'])->update($data_news);
            $this -> assign('type',$new['news_type']);
            $this -> assign('url',$url);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    //添加阅读项
    public function read_add(){
        if($_POST){
            if(empty($_POST['id'])){
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '找不到主体信息,请联系管理员！';
                return json($data);die;
            }
            if(empty($_POST['title'])){
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '请填写阅读项标题！';
                return json($data);die;
            }
            if(empty($_POST['desc'])){
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '请编辑阅读项内容！';
                return json($data);die;
            }
            $data_read['read_title'] = $_POST['title'];
            $data_read['read_body'] = $_POST['desc'];
            $data_read['read_name'] = $_POST['name'];
            $data_read['read_addtime'] = time();
            $data_read['read_new_id'] = $_POST['id'];
            $data_read['read_sort'] = $_POST['sort']?$_POST['sort']:0;
            $read = db('read')->insertGetId($data_read);
            if($read){
                // 上传成功
                $data['type'] = 1;
                return json($data);die;
            }else{
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '添加失败！';
                return json($data);die;
            }
        }else{
            // 提交失败获取错误信息
            $data['type'] = 2;
            $data['error'] = '无提交数据！';
            return json($data);die;
        }
    }
    
    //上传dbf文件
    public function upload_dbf(){
        $file = request()->file('files');
        if($file){
            $info = $file->validate(['ext'=>'dbf'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $route = ROOT_PATH.'public'.DS.'uploads'.DS.$info->getSaveName();
                $str=explode(DS,$info->getSaveName());
                $data_upload_files['upload_files_name'] = $str[(count($str)-1)];
                $data_upload_files['upload_files_path'] = $route;
                $data_upload_files['upload_files_news_id'] = $_POST['id'];
                $data_upload_files['upload_files_addtime'] = time();
                $data_upload_files['upload_files_body'] = $_POST['body'];
                $data_upload_files['upload_files_mode'] = $_POST['mode'];
                $news = db('news')->where('news_id = '.$_POST['id'])->find();
                if($_POST['type']==1){
                    if(!empty($_POST['lx'])){
                        $data_upload_files['upload_files_lx'] = $_POST['lx'];
                    }
                    $data_upload_files['upload_files_news_dbname'] = $news['news_dbname'];
                }else{
                    if($news['news_type']==1){
                        $data_upload_files['upload_files_news_dbname'] = 'crgk_km';
                    }else if($news['news_type']==2){
                        if($_POST['type']==2){
                            $data_upload_files['upload_files_lx'] = $_POST['lx'];
                            $data_upload_files['upload_files_news_dbname'] = 'zxks_jc';
                        }else{
                            $data_upload_files['upload_files_lx'] = $_POST['lx'];
                            $data_upload_files['upload_files_news_dbname'] = 'zxks_km';
                        }
                    }
                }
                $number = db('upload_files')->insertGetId($data_upload_files);
                if($number){
                    // 上传成功
                    $data['type'] = 1;
                    return json($data);die;
                }else{
                    // 上传失败获取错误信息
                    $data['type'] = 2;
                    $data['error'] = '上传失败,请重新上传';
                    return json($data);die;
                }
            }else{
                // 上传失败获取错误信息
                $data['type'] = 2;
                $data['error'] = $file->getError();
                return json($data);die;
            }
        }else{
            // 上传失败获取错误信息
            $data['type'] = 2;
            $data['error'] = '请选择上传文件';
            return json($data);die;
        }
    }
    
    
    
    //删除信息主体相关
    public function news_del(){
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $news = db('news')->where('news_id',$id)->find();
            if($news){
                $data['news_if'] = 1;
                $body = db('news')->where('news_id = '.$id)->update($data);
                if($body){
                    $type = db('type')->column('type_id,type_dbname');
                    if(file_exists(ROOT_PATH.'public/runtime/'.$type[$news['news_type']].'/'.$id.'.html')){
                        unlink(ROOT_PATH.'public/runtime/'.$type[$news['news_type']].'/'.$id.'.html');
                    }
                    if(file_exists(ROOT_PATH.'public/runtime/'.$type[$news['news_type']].'/'.$id.'.php')){
                        unlink(ROOT_PATH.'public/runtime/'.$type[$news['news_type']].'/'.$id.'.php');
                    }
                    $tz_url = array(
                                    '1'=>'index',
                                    '2'=>'index_zxks',
                                    '3'=>'index_zsxx',
                                    '4'=>'index_crgk_lq',
                                    '5'=>'index_ysks',
                                    );
                    echo "<script>alert('删除成功！');location.href='/index/upload/".$tz_url[$news['news_type']]."';</script>";
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
    }
    
    //删除dbf文件
    public function upload_del(){
        if($_POST['id']){
            $id = $_POST['id'];
            $upload_files = db('upload_files')->where('upload_files_id',$id)->find();
            if($upload_files){
                $body = db('upload_files')->where('upload_files_id = '.$id)->delete();
                if($body){
                    if(file_exists($upload_files['upload_files_path'])){
                        //unlink($upload_files['upload_files_path']);
                    }
                    // 删除成功
                    $data['type'] = 1;
                    $data['error'] = '删除成功';
                    return json($data);die;
                }else{
                    // 删除失败
                    $data['type'] = 2;
                    $data['error'] = '删除失败';
                    return json($data);die;
                }
            }else{
                // 删除失败
                $data['type'] = 2;
                $data['error'] = '要删除的数据不存在';
                return json($data);die;
            }
        }else{
            // 删除失败
            $data['type'] = 2;
            $data['error'] = '未获取删除目标';
            return json($data);die;
        }
    }
    
    
    //删除阅读项
    public function read_del(){
        if($_POST['id']){
            $id = $_POST['id'];
            $read = db('read')->where('read_id',$id)->find();
            if($read){
                $body = db('read')->where('read_id = '.$id)->delete();
                if($body){
                    // 删除成功
                    $data['type'] = 1;
                    $data['error'] = '删除成功';
                    return json($data);die;
                }else{
                    // 删除失败
                    $data['type'] = 2;
                    $data['error'] = '删除失败';
                    return json($data);die;
                }
            }else{
                // 删除失败
                $data['type'] = 2;
                $data['error'] = '要删除的数据不存在';
                return json($data);die;
            }
        }else{
            // 删除失败
            $data['type'] = 2;
            $data['error'] = '未获取删除目标';
            return json($data);die;
        }
    }
    
    
    //导入dbf文件
    public function handle(){
        if($_POST['id']){
            $id = $_POST['id'];
            $upload_files = db('upload_files')->where('upload_files_id',$id)->find();
            $news = db('news')->where('news_id',$upload_files['upload_files_news_id'])->find();
            if($upload_files){
                $tb_res = dbase_open($upload_files['upload_files_path'],0);
                if($upload_files['upload_files_news_dbname'] == 'crgk_km'){
                    if($upload_files['upload_files_mode']==1){
                        db('crgk_km')->where('1=1')->delete();
                        $start = "INSERT INTO cx_crgk_km (crgk_km_bh,crgk_km_title) VALUES";
                    }else if($upload_files['upload_files_mode']==2){
                        $start = "INSERT INTO cx_crgk_km (crgk_km_bh,crgk_km_title) VALUES";
                    }else if($upload_files['upload_files_mode']==3){
                        $start = "delete from cx_crgk_km where crgk_km_bh in (";
                    }
                }else if($upload_files['upload_files_news_dbname'] == 'zxks_km'){
                    if($upload_files['upload_files_mode']==1){
                        db('zxks_km')->where('1=1')->delete();
                        $start = "INSERT INTO cx_zxks_km (zxks_km_bh,zxks_km_title,zxks_km_type) VALUES";
                    }else if($upload_files['upload_files_mode']==2){
                        $start = "INSERT INTO cx_zxks_km (zxks_km_bh,zxks_km_title,zxks_km_type) VALUES";
                    }else if($upload_files['upload_files_mode']==3){
                        $start = "delete from cx_zxks_km where zxks_km_bh in (";
                    }
                }else if($upload_files['upload_files_news_dbname'] == 'zxks_jc'){
                    if($upload_files['upload_files_mode']==1){
                        db('zxks_jc')->where('1=1')->delete();
                        $start = "INSERT INTO cx_zxks_jc (zxks_jc_kh,zxks_jc_xm,zxks_jc_sfz,zxks_jc_type) VALUES";
                    }else if($upload_files['upload_files_mode']==2){
                        $start = "INSERT INTO cx_zxks_jc (zxks_jc_kh,zxks_jc_xm,zxks_jc_sfz,zxks_jc_type) VALUES";
                    }else if($upload_files['upload_files_mode']==3){
                        $start = "delete from cx_zxks_jc where zxks_jc_kh in (";
                    }
                }else if($upload_files['upload_files_news_dbname'] == $news['news_dbname']){
                    if($upload_files['upload_files_mode']==3){
                        $start = "delete from cx_".$news['news_dbname']." where KSH in (";
                    }else{
                        if($upload_files['upload_files_mode']==1){
                            db($news['news_dbname'])->where('1=1')->delete();
                        }
                        if($news['news_type']==1){
                            $start = "INSERT INTO cx_".$news['news_dbname']." (KSH,ZKZH,XM,KM1,KM2,KM3,KM4,KMM1,KMM2,KMM3,KMM4,FS1,FS2,FS3,FS4,SFZH,FS) VALUES";
                        }else if($news['news_type']==2){
                            $start = "INSERT INTO cx_".$news['news_dbname']." (KSH,XM,KM,KMM,FS,SFZH,type) VALUES";
                        }else if($news['news_type']==3){
                            $start = "INSERT INTO cx_".$news['news_dbname']." (FP,KSH,BMH,XM,ZJLX,SFZH,KSFSM,KSFSMC,BMDDM,BMDMC,BKDWDM,BKDWMC,BKZYDM,BKZYMC,ZZLLKD,ZZLLKDDZ,ZZLLZKZH,ZZLLKSRQ,ZZLLKCBH,ZZLLZWH,ZZLLM,ZZLLMC,WGYKD,WGYKDDZ,WGYZKZH,WGYKSRQ,WGYKCBH,WGYZWH,WGYM,WGYMC,YWK1KD,YWK1KDDZ,YWK1ZKZH,YWK1KSRQ,YWK1KCBH,YWK1ZWH,YWK1M,YWK1MC,YWK2KD,YWK2KDDZ,YWK2ZKZH,YWK2KSRQ,YWK2KCBH,YWK2ZWH,YWK2M,YWK2MC,ZZLLKDBH,WGYKDBH,YWK1KDBH,YWK2KDBH) VALUES";
                        }else if($news['news_type']==4){
                            $start = "INSERT INTO cx_".$news['news_dbname']." (KSH,XM,CCDM,CCMC,YXDM,YXMC,ZYDM,ZYMC,XZNX,SFZH) VALUES";
                        }else if($news['news_type']==5){
                            $start = "INSERT INTO cx_".$news['news_dbname']." (KSH,XM,KM1,KM2,KM3,KM4,KMM1,KMM2,KMM3,KMM4,KM,ZYFX,ZMH,JCKCJ,ZF,SFZH,type) VALUES";
                        }else{
                            $start = "INSERT INTO cx_".$news['news_dbname']." (KSH,XM,KM1,KM2,KM3,KM4,KMM1,KMM2,KMM3,KMM4,ZF,SFZH) VALUES";
                        }
                    }
                }
                $sql = $start;
                $x = 0;
                if($upload_files['upload_files_news_dbname'] == $news['news_dbname']&&$news['news_type']==2){
                    if($upload_files['upload_files_lx']==1){
                        $where['zxks_km_type'] = ['eq',1];
                    }else if($upload_files['upload_files_lx']==2){
                        $where['zxks_km_type'] = ['eq',2];
                    }else{
                        $where['zxks_km_type'] = ['eq',0];
                    }
                    $km = db('zxks_km')->where($where)->column('zxks_km_title','zxks_km_bh');
                    $km_lx = db('zxks_km')->where($where)->column('zxks_km_type','zxks_km_bh');
                    if(empty($km)){
                        // 导入失败
                        $data['type'] = 2;
                        $data['error'] = '请先导入科目表';
                        return json($data);die;
                    }
                    $sfz = db('zxks_jc')->column('zxks_jc_sfz','zxks_jc_kh');
                    //print_r($km);die;
                    if(empty($sfz)){
                        // 导入失败
                        $data['type'] = 2;
                        $data['error'] = '请先导入自考基础表';
                        return json($data);die;
                    } 
                    redis_jc_set($sfz);
                }
                for($i=1;$i<=dbase_numrecords($tb_res);$i++){
                    $row = dbase_get_record_with_names($tb_res,$i);
                    if($upload_files['upload_files_news_dbname'] == 'crgk_km'){
                        if(empty($row['KMMC'])){
                            $row['kmmc'] = trim($row['kmmc']);
                            //$fileType = mb_detect_encoding($row['kmmc'] , array('UTF-8','GBK','LATIN1','BIG5'));
                            $row['kmmc'] = mb_convert_encoding($row['kmmc'] ,'utf-8' , 'gbk');
                            if($upload_files['upload_files_mode']!=3){
                                $sql .= '("'.trim($row['kmdm']).'",';//科目号
                                $sql .= '"'.trim($row['kmmc']).'"),';//科目名
                            }else{
                                $sql .= '"'.trim($row['kmdm']).'",';//科目号
                            }
                        }else{
                            $row['KMMC'] = trim($row['KMMC']);
                            //$fileType = mb_detect_encoding($row['KMMC'] , array('UTF-8','GBK','LATIN1','BIG5'));
                            $row['KMMC'] = mb_convert_encoding($row['KMMC'] ,'utf-8' , 'gbk');
                            if($upload_files['upload_files_mode']!=3){
                                $sql .= '("'.trim($row['KMDM']).'",';//科目号
                                $sql .= '"'.trim($row['KMMC']).'"),';//科目名
                            }else{
                                $sql .= '"'.trim($row['KMDM']).'",';//科目号
                            }
                        }
                    }else if($upload_files['upload_files_news_dbname'] == 'zxks_km'){
                        if(empty($row['KMM'])){
                            $row['kmm'] = trim($row['kmm']);
                            //$fileType = mb_detect_encoding($row['kmm'] , array('UTF-8','GBK','LATIN1','BIG5'));
                            $row['kmm'] = mb_convert_encoding($row['kmm'] ,'utf-8' , 'gbk');
                            if($upload_files['upload_files_mode']!=3){
                                $sql .= '("'.trim($row['km']).'",';//科目号
                                $sql .= '"'.trim($row['kmm']).'",';//科目名
                                $sql .= '"'.trim($upload_files['upload_files_lx']).'"),';//分类
                            }else{
                                $sql .= '"'.trim($row['km']).'",';//科目号
                            }
                        }else{
                            $row['KMM'] = trim($row['KMM']);
                            //$fileType = mb_detect_encoding($row['KMM'] , array('UTF-8','GBK','LATIN1','BIG5'));
                            $row['KMM'] = mb_convert_encoding($row['KMM'] ,'utf-8' , 'gbk');
                            if($upload_files['upload_files_mode']!=3){
                                $sql .= '("'.trim($row['KM']).'",';//科目号
                                $sql .= '"'.trim($row['KMM']).'",';//科目名
                                $sql .= '"'.trim($upload_files['upload_files_lx']).'"),';//分类
                            }else{
                                $sql .= '"'.trim($row['KM']).'",';//科目号
                            }
                        }
                    }else if($upload_files['upload_files_news_dbname'] == 'zxks_jc'){
                        if(empty($row['XM'])){
                            $row['xm'] = trim($row['xm']);
                            //$fileType = mb_detect_encoding($row['xm'] , array('UTF-8','GBK','LATIN1','BIG5'));
                            $row['xm'] = mb_convert_encoding($row['xm'] ,'utf-8' , 'gbk');
                            if($upload_files['upload_files_mode']!=3){
                                $sql .= '("'.trim($row['kh']).'",';//考号
                                $sql .= '"'.trim($row['xm']).'",';//姓名
                                $sql .= '"'.trim($row['sfz']).'",';//身份证号
                                $sql .= '"'.trim($upload_files['upload_files_lx']).'"),';//分类
                            }else{
                                $sql .= '"'.trim($row['kh']).'",';//考号
                            }
                        }else{
                            $row['XM'] = trim($row['XM']);
                            //$fileType = mb_detect_encoding($row['XM'] , array('UTF-8','GBK','LATIN1','BIG5'));
                            $row['XM'] = mb_convert_encoding($row['XM'] ,'utf-8' , 'gbk');
                            if($upload_files['upload_files_mode']!=3){
                                $sql .= '("'.trim($row['KH']).'",';//考号
                                $sql .= '"'.trim($row['XM']).'",';//姓名
                                $sql .= '"'.trim($row['SFZ']).'",';//身份证号
                                $sql .= '"'.trim($upload_files['upload_files_lx']).'"),';//分类
                            }else{
                                $sql .= '"'.trim($row['KH']).'",';//考号
                            }
                        }
                    }else if($upload_files['upload_files_news_dbname'] == $news['news_dbname']){
                        if($news['news_type']==1){
                            $km = db('crgk_km')->column('crgk_km_title','crgk_km_bh');
                            if(empty($km)){
                                // 导入失败
                                $data['type'] = 2;
                                $data['error'] = '请先导入科目表';
                                return json($data);die;
                            }
                            $km[0] = '';
                            if(empty($row['XM'])){
                                $row['xm'] = trim($row['xm']);
                                //$fileType = mb_detect_encoding($row['xm'] , array('UTF-8','GBK','LATIN1','BIG5'));
                                $row['xm'] = mb_convert_encoding($row['xm'] ,'utf-8' , 'gbk');
                                if($upload_files['upload_files_mode']!=3){
                                    $sql .= '("'.trim($row['ksh']).'",';//考生号
                                    $sql .= '"'.trim($row['zkzh']).'",';//准考证号
                                    $sql .= '"'.trim($row['xm']).'",';//姓名
                                    $sql .= '"'.trim($row['km1']).'",';//科目id1
                                    $sql .= '"'.trim($row['km2']).'",';//科目id2
                                    $sql .= '"'.trim($row['km3']).'",';//科目id3
                                    $sql .= '"'.trim($row['km4']).'",';//科目id4
                                    $sql .= '"'.trim($km[(int)$row['km1']]).'",';//科目名1
                                    $sql .= '"'.trim($km[(int)$row['km2']]).'",';//科目名2
                                    $sql .= '"'.trim($km[(int)$row['km3']]).'",';//科目名3
                                    $sql .= '"'.trim($km[(int)$row['km4']]).'",';//科目名4
                                    $sql .= '"'.trim($row['fs1']).'",';//分数1
                                    $sql .= '"'.trim($row['fs2']).'",';//分数2
                                    $sql .= '"'.trim($row['fs3']).'",';//分数3
                                    $sql .= '"'.trim($row['fs4']).'",';//分数4
                                    $sql .= '"'.trim($row['sfzh']).'",';//身份证号码
                                    $sql .= '"'.trim($row['zf']).'"),';//准考证号
                                }else{
                                    $sql .= '"'.trim($row['ksh']).'",';//考生号
                                }
                            }else{
                                $row['XM'] = trim($row['XM']);
                                //$fileType = mb_detect_encoding($row['XM'] , array('UTF-8','GBK','LATIN1','BIG5'));
                                $row['XM'] = mb_convert_encoding($row['XM'] ,'utf-8' , 'gbk');
                                if($upload_files['upload_files_mode']!=3){
                                    $sql .= '("'.trim($row['KSH']).'",';//考生号
                                    $sql .= '"'.trim($row['ZKZH']).'",';//准考证号
                                    $sql .= '"'.trim($row['XM']).'",';//姓名
                                    $sql .= '"'.trim($row['KM1']).'",';//科目id1
                                    $sql .= '"'.trim($row['KM2']).'",';//科目id2
                                    $sql .= '"'.trim($row['KM3']).'",';//科目id3
                                    $sql .= '"'.trim($row['KM4']).'",';//科目id4
                                    $sql .= '"'.trim($km[(int)$row['KM1']]).'",';//科目名1
                                    $sql .= '"'.trim($km[(int)$row['KM2']]).'",';//科目名2
                                    $sql .= '"'.trim($km[(int)$row['KM3']]).'",';//科目名3
                                    $sql .= '"'.trim($km[(int)$row['KM4']]).'",';//科目名4
                                    $sql .= '"'.trim($row['FS1']).'",';//分数1
                                    $sql .= '"'.trim($row['FS2']).'",';//分数2
                                    $sql .= '"'.trim($row['FS3']).'",';//分数3
                                    $sql .= '"'.trim($row['FS4']).'",';//分数4
                                    $sql .= '"'.trim($row['SFZH']).'",';//身份证号码
                                    $sql .= '"'.trim($row['ZF']).'"),';//准考证号
                                }else{
                                    $sql .= '"'.trim($row['KSH']).'",';//考生号
                                }
                            }
                        }else if($news['news_type']==2){
                            if(empty($row['XM'])){
                                $row['xm'] = trim($row['xm']);
                                //$fileType = mb_detect_encoding($row['xm'] , array('UTF-8','GBK','LATIN1','BIG5'));
                                $row['xm'] = mb_convert_encoding($row['xm'] ,'utf-8' , 'gbk');
                                if($upload_files['upload_files_mode']!=3){
                                    $ls_sfz = redis_jc_get(trim($row['kh']));
                                    $sql .= '("'.trim($row['kh']).'",';//考生号
                                    $sql .= '"'.trim($row['xm']).'",';//姓名
                                    $sql .= '"'.trim($row['km']).'",';//科目id
                                    $sql .= '"'.trim($km[trim($row['km'])]).'",';//科目名
                                    $sql .= '"'.trim($row['fs']).'",';//分数
                                    $sql .= '"'.trim($ls_sfz).'",';//身份证号码
                                    $sql .= '"'.trim($km_lx[trim($row['km'])]).'"),';//类型
                                }else{
                                    $sql .= '"'.trim($row['kh']).'",';//考生号
                                }
                            }else{
                                $row['XM'] = trim($row['XM']);
                                //$fileType = mb_detect_encoding($row['XM'] , array('UTF-8','GBK','LATIN1','BIG5'));
                                $row['XM'] = mb_convert_encoding($row['XM'] ,'utf-8' , 'gbk');
                                if($upload_files['upload_files_mode']!=3){
                                    $ls_sfz = redis_jc_get(trim($row['KH']));
                                    $sql .= '("'.trim($row['KH']).'",';//考生号
                                    $sql .= '"'.trim($row['XM']).'",';//姓名
                                    $sql .= '"'.trim($row['KM']).'",';//科目id
                                    $sql .= '"'.trim($km[trim($row['KM'])]).'",';//科目名
                                    $sql .= '"'.trim($row['FS']).'",';//分数
                                    $sql .= '"'.trim($ls_sfz).'",';//身份证号码
                                    $sql .= '"'.trim($km_lx[trim($row['KM'])]).'"),';//类型
                                }else{
                                    $sql .= '"'.trim($row['KH']).'",';//考生号
                                }
                            }
                        }else if($news['news_type']==3){
                            if(empty($row['XM'])){
                                $array = array("xm","ksfsmc","bmdmc","bkdwmc","bkzymc","zzllkd","zzllkddz","zzllksrq","zzllmc","wgykd","wgykddz","wgyksrq","wgymc","ywk1kd","ywk1kddz","ywk1ksrq","ywk1mc","ymw2kd","ywk2kddz","ywk2ksrq","ywk2mc");
                                foreach($array as $k => $v){
                                    $row[$v] = trim($row[$v]);
                                    //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                    $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                }
                                if($upload_files['upload_files_mode']!=3){
                                    $sql .= '("'.trim($row['fp']).'",';
                                    $sql .= '"'.trim($row['ksbh']).'",';
                                    $sql .= '"'.trim($row['bmh']).'",';
                                    $sql .= '"'.trim($row['xm']).'",';
                                    $sql .= '"'.trim($row['zjlx']).'",';
                                    $sql .= '"'.trim($row['zjhk']).'",';
                                    $sql .= '"'.trim($row['ksfsm']).'",';
                                    $sql .= '"'.trim($row['ksfsmc']).'",';
                                    $sql .= '"'.trim($row['bmddm']).'",';
                                    $sql .= '"'.trim($row['bmdmc']).'",';
                                    $sql .= '"'.trim($row['bkdwdm']).'",';
                                    $sql .= '"'.trim($row['bkdwmc']).'",';
                                    $sql .= '"'.trim($row['bkzydm']).'",';
                                    $sql .= '"'.trim($row['bkzymc']).'",';
                                    $sql .= '"'.trim($row['zzllkd']).'",';
                                    $sql .= '"'.trim($row['zzllkddz']).'",';
                                    $sql .= '"'.trim($row['zzllzkzh']).'",';
                                    $sql .= '"'.trim($row['zzllksrq']).'",';
                                    $sql .= '"'.trim($row['zzllkcbh']).'",';
                                    $sql .= '"'.trim($row['zzllzwh']).'",';
                                    $sql .= '"'.trim($row['zzllm']).'",';
                                    $sql .= '"'.trim($row['zzllmc']).'",';
                                    $sql .= '"'.trim($row['wgykd']).'",';
                                    $sql .= '"'.trim($row['wgykddz']).'",';
                                    $sql .= '"'.trim($row['wgyzkzh']).'",';
                                    $sql .= '"'.trim($row['wgyksrq']).'",';
                                    $sql .= '"'.trim($row['wgykcbh']).'",';
                                    $sql .= '"'.trim($row['wgyzwh']).'",';
                                    $sql .= '"'.trim($row['wgym']).'",';
                                    $sql .= '"'.trim($row['wgymc']).'",';
                                    $sql .= '"'.trim($row['ywk1kd']).'",';
                                    $sql .= '"'.trim($row['ywk1kkdz']).'",';
                                    $sql .= '"'.trim($row['ywk1zkzh']).'",';
                                    $sql .= '"'.trim($row['ywk1ksrq']).'",';
                                    $sql .= '"'.trim($row['ywk1kcbh']).'",';
                                    $sql .= '"'.trim($row['ywk1zwh']).'",';
                                    $sql .= '"'.trim($row['ywk1m']).'",';
                                    $sql .= '"'.trim($row['ywk1mc']).'",';
                                    $sql .= '"'.trim($row['ywk2kd']).'",';
                                    $sql .= '"'.trim($row['ywk2kddz']).'",';
                                    $sql .= '"'.trim($row['ywk2zkzh']).'",';
                                    $sql .= '"'.trim($row['ywk2ksrq']).'",';
                                    $sql .= '"'.trim($row['ywk2kcbh']).'",';
                                    $sql .= '"'.trim($row['ywk2zwh']).'",';
                                    $sql .= '"'.trim($row['ywk2m']).'",';
                                    $sql .= '"'.trim($row['ywk2mc']).'",';
                                    $sql .= '"'.trim($row['zzllkdbh']).'",';
                                    $sql .= '"'.trim($row['wgykdbh']).'",';
                                    $sql .= '"'.trim($row['ywk1kdbh']).'",';
                                    $sql .= '"'.trim($row['ywk2kdbh']).'"),';//身份证号码
                                }else{
                                    $sql .= '"'.trim($row['ksbh']).'",';//考生号
                                }
                            }else{
                                $array = array("XM","KSFSMC","BMDMC","BKDWMC","BKZYMC","ZZLLKD","ZZLLKDDZ","ZZLLKSRQ","ZZLLMC","WGYKD","WGYKDDZ","WGYKSRQ","WGYMC","YWK1KD","YWK1KDDZ","YWK1KSRQ","YWK1MC","YWK2KD","YWK2KDDZ","YWK2KSRQ","YWK2MC");
                                foreach($array as $k => $v){
                                    $row[$v] = trim($row[$v]);
                                    //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                    $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                }
                                if($upload_files['upload_files_mode']!=3){
                                    $sql .= '("'.trim($row['FP']).'",';//考生号
                                    $sql .= '"'.trim($row['KSBH']).'",';//姓名
                                    $sql .= '"'.trim($row['BMH']).'",';
                                    $sql .= '"'.trim($row['XM']).'",';
                                    $sql .= '"'.trim($row['ZJLX']).'",';
                                    $sql .= '"'.trim($row['ZJHM']).'",';
                                    $sql .= '"'.trim($row['KSFSM']).'",';
                                    $sql .= '"'.trim($row['KSFSMC']).'",';
                                    $sql .= '"'.trim($row['BMDDM']).'",';
                                    $sql .= '"'.trim($row['BMDMC']).'",';
                                    $sql .= '"'.trim($row['BKDWDM']).'",';
                                    $sql .= '"'.trim($row['BKDWMC']).'",';
                                    $sql .= '"'.trim($row['BKZYDM']).'",';
                                    $sql .= '"'.trim($row['BKZYMC']).'",';
                                    $sql .= '"'.trim($row['ZZLLKD']).'",';
                                    $sql .= '"'.trim($row['ZZLLKDDZ']).'",';
                                    $sql .= '"'.trim($row['ZZLLZKZH']).'",';
                                    $sql .= '"'.trim($row['ZZLLKSRQ']).'",';
                                    $sql .= '"'.trim($row['ZZLLKCBH']).'",';
                                    $sql .= '"'.trim($row['ZZLLZWH']).'",';
                                    $sql .= '"'.trim($row['ZZLLM']).'",';
                                    $sql .= '"'.trim($row['ZZLLMC']).'",';
                                    $sql .= '"'.trim($row['WGYKD']).'",';
                                    $sql .= '"'.trim($row['WGYKDDZ']).'",';
                                    $sql .= '"'.trim($row['WGYZKZH']).'",';
                                    $sql .= '"'.trim($row['WGYKSRQ']).'",';
                                    $sql .= '"'.trim($row['WGYKCBH']).'",';
                                    $sql .= '"'.trim($row['WGYZWH']).'",';
                                    $sql .= '"'.trim($row['WGYM']).'",';
                                    $sql .= '"'.trim($row['WGYMC']).'",';
                                    $sql .= '"'.trim($row['YWK1KD']).'",';
                                    $sql .= '"'.trim($row['YWK1KDDZ']).'",';
                                    $sql .= '"'.trim($row['YWK1ZKZH']).'",';
                                    $sql .= '"'.trim($row['YWK1KSRQ']).'",';
                                    $sql .= '"'.trim($row['YWK1KCBH']).'",';
                                    $sql .= '"'.trim($row['YWK1ZWH']).'",';
                                    $sql .= '"'.trim($row['YWK1M']).'",';
                                    $sql .= '"'.trim($row['YWK1MC']).'",';
                                    $sql .= '"'.trim($row['YWK2KD']).'",';
                                    $sql .= '"'.trim($row['YWK2KDDZ']).'",';
                                    $sql .= '"'.trim($row['YWK2ZKZH']).'",';
                                    $sql .= '"'.trim($row['YWK2KSRQ']).'",';
                                    $sql .= '"'.trim($row['YWK2KCBH']).'",';
                                    $sql .= '"'.trim($row['YWK2ZWH']).'",';
                                    $sql .= '"'.trim($row['YWK2M']).'",';
                                    $sql .= '"'.trim($row['YWK2MC']).'",';
                                    $sql .= '"'.trim($row['ZZLLKDBH']).'",';
                                    $sql .= '"'.trim($row['WGYKDBH']).'",';
                                    $sql .= '"'.trim($row['YWK1KDBH']).'",';
                                    $sql .= '"'.trim($row['YWK2KDBH']).'"),';//身份证号码
                                }else{
                                    $sql .= '"'.trim($row['KSBH']).'",';//考生号
                                }
                            }
                        }else if($news['news_type']==4){
                            if(empty($row['XM'])){
                                $array = array("xm","ccmc","yxmc","zymc");
                                foreach($array as $k => $v){
                                    $row[$v] = trim($row[$v]);
                                    //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                    $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                }
                                if($upload_files['upload_files_mode']!=3){
                                    $sql .= '("'.trim($row['ksh']).'",';//考生号
                                    $sql .= '"'.trim($row['xm']).'",';//姓名
                                    $sql .= '"'.trim($row['ccdm']).'",';//科目id
                                    $sql .= '"'.trim($row['ccmc']).'",';//科目id
                                    $sql .= '"'.trim($row['yxdm']).'",';//科目id
                                    $sql .= '"'.trim($row['yxmc']).'",';//科目id
                                    $sql .= '"'.trim($row['zydm']).'",';//科目id
                                    $sql .= '"'.trim($row['zymc']).'",';//科目id
                                    $sql .= '"'.trim($row['xznx']).'",';//科目id
                                    $sql .= '"'.trim($row['sfzh']).'"),';//身份证号码
                                }else{
                                    $sql .= '"'.trim($row['kh']).'",';//考生号
                                }
                            }else{
                                $array = array("XM","CCMC","YXMC","ZYMC");
                                foreach($array as $k => $v){
                                    $row[$v] = trim($row[$v]);
                                    //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                    $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                }
                                if($upload_files['upload_files_mode']!=3){
                                    $sql .= '("'.trim($row['KSH']).'",';//考生号
                                    $sql .= '"'.trim($row['XM']).'",';//姓名
                                    $sql .= '"'.trim($row['CCDM']).'",';//科目id
                                    $sql .= '"'.trim($row['CCMC']).'",';//科目id
                                    $sql .= '"'.trim($row['YXDM']).'",';//科目id
                                    $sql .= '"'.trim($row['YXMC']).'",';//科目id
                                    $sql .= '"'.trim($row['ZYDM']).'",';//科目id
                                    $sql .= '"'.trim($row['ZYMC']).'",';//科目id
                                    $sql .= '"'.trim($row['XZNX']).'",';//科目id
                                    $sql .= '"'.trim($row['SFZH']).'"),';//身份证号码
                                }else{
                                    $sql .= '"'.trim($row['KH']).'",';//考生号
                                }
                            }
                        }else if($news['news_type']==5){
                            if(empty($row['XM'])){
                                if($upload_files['upload_files_lx']==1){
                                    $array = array("xm","km","zyfx","zmh");
                                    foreach($array as $k => $v){
                                        $row[$v] = trim($row[$v]);
                                        //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                        $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                    }
                                    if($upload_files['upload_files_mode']!=3){
                                        $sql .= '("'.trim($row['ksh']).'",';//考生号
                                        $sql .= '"'.trim($row['xm']).'",';//姓名
                                        $sql .= '"",';//科目1
                                        $sql .= '"",';//科目2
                                        $sql .= '"",';//科目3
                                        $sql .= '"",';//科目4
                                        $sql .= '"",';//科目名1
                                        $sql .= '"",';//科目名2
                                        $sql .= '"",';//科目名3
                                        $sql .= '"",';//科目名4
                                        $sql .= '"'.trim($row['km']).'",';//科目
                                        $sql .= '"'.trim($row['zyfx']).'",';//专业方向
                                        $sql .= '"'.trim($row['zmh']).'",';//专业化
                                        $sql .= '"'.trim($row['jckcj']).'",';//基础课成绩
                                        $sql .= '"'.trim($row['zf']).'",';//总分
                                        $sql .= '"'.trim($row['sfzh']).'",';//身份证号码
                                        $sql .= '"'.$upload_files['upload_files_lx'].'"),';//类型
                                    }else{
                                        $sql .= '"'.trim($row['ksh']).'",';//考生号
                                    }
                                }else if($upload_files['upload_files_lx']==2){
                                    $array = array("xm");
                                    foreach($array as $k => $v){
                                        $row[$v] = trim($row[$v]);
                                        //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                        $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                    }
                                    if($upload_files['upload_files_mode']!=3){
                                        $sql .= '("'.trim($row['ksh']).'",';//考生号
                                        $sql .= '"'.trim($row['xm']).'",';//姓名
                                        $sql .= '"'.trim($row['sc']).'",';//科目1
                                        $sql .= '"'.trim($row['sm']).'",';//科目2
                                        $sql .= '"'.trim($row['sx']).'",';//科目3
                                        $sql .= '"",';//科目4
                                        $sql .= '"色彩",';//科目名1
                                        $sql .= '"素描",';//科目名2
                                        $sql .= '"速写",';//科目名3
                                        $sql .= '"",';//科目名4
                                        $sql .= '"",';//科目
                                        $sql .= '"",';//专业方向
                                        $sql .= '"",';//专业化
                                        $sql .= '"",';//基础课成绩
                                        $sql .= '"'.trim($row['zf']).'",';//总分
                                        $sql .= '"'.trim($row['sfzh']).'",';//身份证号码
                                        $sql .= '"'.$upload_files['upload_files_lx'].'"),';//类型
                                    }else{
                                        $sql .= '"'.trim($row['ksh']).'",';//考生号
                                    }
                                }else{
                                    if($upload_files['upload_files_lx']==3){
                                        $km1 = trim($row['km1']);
                                        $km2 = trim($row['km2']);
                                        $km3 = trim($row['km3']);
                                        $km4 = trim($row['km4']);
                                        $kmm1 = '命题表演';
                                        $kmm2 = '形体';
                                        $kmm3 = '朗诵';
                                        $kmm4 = '声乐';
                                    }else if($upload_files['upload_files_lx']==4){
                                        $km1 = trim($row['km1']);
                                        $km2 = trim($row['km2']);
                                        $km3 = trim($row['km3']);
                                        $km4 = trim($row['km4']);
                                        $kmm1 = '朗诵';
                                        $kmm2 = '命题表演';
                                        $kmm3 = '命题故事';
                                        $kmm4 = '作品分析';
                                    }else if($upload_files['upload_files_lx']==5){
                                        $km1 = trim($row['km1']);
                                        $km2 = trim($row['km2']);
                                        $km3 = trim($row['km3']);
                                        $km4 = trim($row['km4']);
                                        $kmm1 = '朗诵';
                                        $kmm2 = '即兴演讲';
                                        $kmm3 = '艺术特长';
                                        $kmm4 = '语言基础';
                                    }else if($upload_files['upload_files_lx']==6){
                                        $km1 = trim($row['km1']);
                                        $km2 = trim($row['km2']);
                                        $km3 = trim($row['km3']);
                                        $km4 = '';
                                        $kmm1 = '文学常识';
                                        $kmm2 = '命题故事';
                                        $kmm3 = '作品分析';
                                        $kmm4 = '';
                                    }else if($upload_files['upload_files_lx']==7){
                                        $km1 = trim($row['km1']);
                                        $km2 = trim($row['km2']);
                                        $km3 = trim($row['km3']);
                                        $km4 = trim($row['km4']);
                                        $kmm1 = '即兴演讲';
                                        $kmm2 = '艺术特长';
                                        $kmm3 = '作品分析';
                                        $kmm4 = '文学常识';
                                    }
                                    $array = array("xm");
                                    foreach($array as $k => $v){
                                        $row[$v] = trim($row[$v]);
                                        //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                        $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                    }
                                    if($upload_files['upload_files_mode']!=3){
                                        $sql .= '("'.trim($row['ksh']).'",';//考生号
                                        $sql .= '"'.trim($row['xm']).'",';//姓名
                                        $sql .= '"'.$km1.'",';//科目1
                                        $sql .= '"'.$km2.'",';//科目2
                                        $sql .= '"'.$km3.'",';//科目3
                                        $sql .= '"'.$km4.'",';//科目4
                                        $sql .= '"'.$kmm1.'",';//科目名1
                                        $sql .= '"'.$kmm2.'",';//科目名2
                                        $sql .= '"'.$kmm3.'",';//科目名3
                                        $sql .= '"'.$kmm4.'",';//科目名4
                                        $sql .= '"",';//科目
                                        $sql .= '"",';//专业方向
                                        $sql .= '"",';//专业化
                                        $sql .= '"",';//基础课成绩
                                        $sql .= '"'.trim($row['zf']).'",';//总分
                                        $sql .= '"'.trim($row['sfzh']).'",';//身份证号码
                                        $sql .= '"'.$upload_files['upload_files_lx'].'"),';//类型
                                    }else{
                                        $sql .= '"'.trim($row['ksh']).'",';//考生号
                                    }
                                }
                            }else{
                                if($upload_files['upload_files_lx']==1){
                                    $array = array("XM","KM","ZYFX","ZMH");
                                    foreach($array as $k => $v){
                                        $row[$v] = trim($row[$v]);
                                        //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                        $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                    }
                                    if($upload_files['upload_files_mode']!=3){
                                        $sql .= '("'.trim($row['KSH']).'",';//考生号
                                        $sql .= '"'.trim($row['XM']).'",';//姓名
                                        $sql .= '"",';//科目1
                                        $sql .= '"",';//科目2
                                        $sql .= '"",';//科目3
                                        $sql .= '"",';//科目4
                                        $sql .= '"",';//科目名1
                                        $sql .= '"",';//科目名2
                                        $sql .= '"",';//科目名3
                                        $sql .= '"",';//科目名4
                                        $sql .= '"'.trim($row['KM']).'",';//科目
                                        $sql .= '"'.trim($row['ZYFX']).'",';//专业方向
                                        $sql .= '"'.trim($row['ZMH']).'",';//专业化
                                        $sql .= '"'.trim($row['JCKCJ']).'",';//基础课成绩
                                        $sql .= '"'.trim($row['ZF']).'",';//总分
                                        $sql .= '"'.trim($row['SFZH']).'",';//身份证号码
                                        $sql .= '"'.$upload_files['upload_files_lx'].'"),';//类型
                                    }else{
                                        $sql .= '"'.trim($row['KSH']).'",';//考生号
                                    }
                                }else if($upload_files['upload_files_lx']==2){
                                    $array = array("XM");
                                    foreach($array as $k => $v){
                                        $row[$v] = trim($row[$v]);
                                        //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                        $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                    }
                                    if($upload_files['upload_files_mode']!=3){
                                        $sql .= '("'.trim($row['KSH']).'",';//考生号
                                        $sql .= '"'.trim($row['XM']).'",';//姓名
                                        $sql .= '"'.trim($row['SC']).'",';//科目1
                                        $sql .= '"'.trim($row['SM']).'",';//科目2
                                        $sql .= '"'.trim($row['SX']).'",';//科目3
                                        $sql .= '"",';//科目4
                                        $sql .= '"色彩",';//科目名1
                                        $sql .= '"素描",';//科目名2
                                        $sql .= '"速写",';//科目名3
                                        $sql .= '"",';//科目名4
                                        $sql .= '"",';//科目
                                        $sql .= '"",';//专业方向
                                        $sql .= '"",';//专业化
                                        $sql .= '"",';//基础课成绩
                                        $sql .= '"'.trim($row['ZF']).'",';//总分
                                        $sql .= '"'.trim($row['SFZH']).'",';//身份证号码
                                        $sql .= '"'.$upload_files['upload_files_lx'].'"),';//类型
                                    }else{
                                        $sql .= '"'.trim($row['KSH']).'",';//考生号
                                    }
                                }else{
                                    if($upload_files['upload_files_lx']==3){
                                        $km1 = trim($row['KM1']);
                                        $km2 = trim($row['KM2']);
                                        $km3 = trim($row['KM3']);
                                        $km4 = trim($row['KM4']);
                                        $kmm1 = '命题表演';
                                        $kmm2 = '形体';
                                        $kmm3 = '朗诵';
                                        $kmm4 = '声乐';
                                    }else if($upload_files['upload_files_lx']==4){
                                        $km1 = trim($row['KM1']);
                                        $km2 = trim($row['KM2']);
                                        $km3 = trim($row['KM3']);
                                        $km4 = trim($row['KM4']);
                                        $kmm1 = '朗诵';
                                        $kmm2 = '命题表演';
                                        $kmm3 = '命题故事';
                                        $kmm4 = '作品分析';
                                    }else if($upload_files['upload_files_lx']==5){
                                        $km1 = trim($row['KM1']);
                                        $km2 = trim($row['KM2']);
                                        $km3 = trim($row['KM3']);
                                        $km4 = trim($row['KM4']);
                                        $kmm1 = '朗诵';
                                        $kmm2 = '即兴演讲';
                                        $kmm3 = '艺术特长';
                                        $kmm4 = '语言基础';
                                    }else if($upload_files['upload_files_lx']==6){
                                        $km1 = trim($row['KM1']);
                                        $km2 = trim($row['KM2']);
                                        $km3 = trim($row['KM3']);
                                        $km4 = '';
                                        $kmm1 = '文学常识';
                                        $kmm2 = '命题故事';
                                        $kmm3 = '作品分析';
                                        $kmm4 = '';
                                    }else if($upload_files['upload_files_lx']==7){
                                        $km1 = trim($row['KM1']);
                                        $km2 = trim($row['KM2']);
                                        $km3 = trim($row['KM3']);
                                        $km4 = trim($row['KM4']);
                                        $kmm1 = '即兴演讲';
                                        $kmm2 = '艺术特长';
                                        $kmm3 = '作品分析';
                                        $kmm4 = '文学常识';
                                    }
                                    $array = array("XM");
                                    foreach($array as $k => $v){
                                        $row[$v] = trim($row[$v]);
                                        //$fileType = mb_detect_encoding($row[$v] , array('UTF-8','GBK','LATIN1','BIG5'));
                                        $row[$v] = mb_convert_encoding($row[$v] ,'utf-8' , 'gbk');
                                    }
                                    if($upload_files['upload_files_mode']!=3){
                                        $sql .= '("'.trim($row['KSH']).'",';//考生号
                                        $sql .= '"'.trim($row['XM']).'",';//姓名
                                        $sql .= '"'.$km1.'",';//科目1
                                        $sql .= '"'.$km2.'",';//科目2
                                        $sql .= '"'.$km3.'",';//科目3
                                        $sql .= '"'.$km4.'",';//科目4
                                        $sql .= '"'.$kmm1.'",';//科目名1
                                        $sql .= '"'.$kmm2.'",';//科目名2
                                        $sql .= '"'.$kmm3.'",';//科目名3
                                        $sql .= '"'.$kmm4.'",';//科目名4
                                        $sql .= '"",';//科目
                                        $sql .= '"",';//专业方向
                                        $sql .= '"",';//专业化
                                        $sql .= '"",';//基础课成绩
                                        $sql .= '"'.trim($row['ZF']).'",';//总分
                                        $sql .= '"'.trim($row['SFZH']).'",';//身份证号码
                                        $sql .= '"'.$upload_files['upload_files_lx'].'"),';//类型
                                    }else{
                                        $sql .= '"'.trim($row['KSH']).'",';//考生号
                                    }
                                }
                            }
                        }
                    }
                    $x++;
                    if($x==10000){
                        if($upload_files['upload_files_mode']==3){
                            $sql = trim($sql,',');
                            $sql .= ')';
                        }else{
                            $sql = trim($sql,',');
                        }
                        $num = db()->execute($sql);
                        $x=0;
                        $sql = $start;
                    }
                }
                if($x!=0){
                    if($upload_files['upload_files_mode']==3){
                        $sql = trim($sql,',');
                        $sql .= ')';
                    }else{
                        $sql = trim($sql,',');
                    }
                    $num = db()->execute($sql);
                }
                if($num){
                    $data['upload_files_type'] = 1;
                    $data['upload_files_drtime'] = time();
                    $asd = db('upload_files')->where('upload_files_id ='.$id)->update($data);
                    // 导入成功
                    $data['type'] = 1;
                    $data['error'] = '导入成功';
                    return json($data);die;
                }else{
                    // 导入失败
                    $data['type'] = 2;
                    $data['error'] = '导入失败';
                    return json($data);die;
                }
            }else{
                // 删除失败
                $data['type'] = 2;
                $data['error'] = '要导入的数据不存在';
                return json($data);die;
            }
        }else{
            // 删除失败
            $data['type'] = 2;
            $data['error'] = '未获取导入目标';
            return json($data);die;
        }
    }
    
    //导入redis
    public function redis_dr(){
        if(!empty($_GET['number'])){
            $news = db('news')->where('news_id = '.$_GET['number'])->find();
            if($news['news_type']==3){
                $data = db($news['news_dbname'])->select();
                if(empty($data)){
                    $this -> error('请先导入招生信息！');
                }
            }else{
                if($news['news_type']==2){
                    $data = db($news['news_dbname'])->field(['KSH','XM','SFZH','concat(group_concat(KMM),"|",group_concat(0+CAST(FS as CHAR)),"|",group_concat(type))'=>'cj'])->group('KSH')->select();
                }else if($news['news_type']==5){
                    $data = db($news['news_dbname'])->field(['KSH','XM','SFZH','JCKCJ','concat(group_concat(KM1),"|",concat(group_concat(KM2),"|",concat(group_concat(KM3),"|",concat(group_concat(KM4),"|",concat(group_concat(KMM1),"|",concat(group_concat(KMM2),"|",concat(group_concat(KMM3),"|",concat(group_concat(KMM4),"|",concat(group_concat(KM),"|",group_concat(ZYFX),"|",group_concat(ZMH),"|",group_concat(ZF),"|",group_concat(type)))'=>'cj'])->group('KSH')->select();
                }else{
                    $data = db($news['news_dbname'])->select();
                }
                if(empty($data)){
                    $this -> error('请先导入成绩！');
                }
            }
            $urls = db('ip')->select();
            foreach ($urls as $key => $value) {
                $re = curl_get_https('http://'.$value['ip_url'].'/index/journal/redis_dr?number='.$_GET['number']);
				$err='';
                if($re==0){
                    $err .= $value['ip_url'].',';
                }
            }
            if(!empty($err)){
                $this -> error($err.'虚拟机导入redis失败,请从新生成！');
            }
            $query_type = explode(",",$news['news_query_type']);
            $cr = redis_cr($data,$news['news_type'],$query_type);
            $tz_url = array(
                            '1'=>'index',
                            '2'=>'index_zxks',
                            '3'=>'index_zsxx',
                            '4'=>'index_crgk_lq',
                            '5'=>'index_ysks',
                            );
            echo "<script>alert('".$cr."！');location.href='/index/upload/".$tz_url[$news['news_type']]."';</script>";
            die;
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    
}
