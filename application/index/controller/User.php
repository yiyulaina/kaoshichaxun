<?php
namespace app\index\controller;
//use think\View;
use app\index\controller\Check;

class User extends Check{
    
    public function index(){
        $where = '';
        if(!empty($_GET['start'])&&!empty($_GET['end'])){
            $where['user_addtime'] = ['between',[strtotime($_GET['start']),strtotime($_GET['end'])+24*60*60]];
        }
        if(!empty($_GET['username'])){
            $where['user_name'] = ['like','%'.$_GET['username'].'%'];
        }
        $user = db('user')
                        ->alias('a')
                        ->field('a.*,i.roles_name')
                        ->join('cx_roles i','a.user_grade = i.roles_id')
                        ->where($where)
                        ->paginate(10);
        $this -> assign('user',$user);
        return $this->fetch();
    }
    
    public function add(){
        if($_POST){
            $data['user_account'] = $_POST['user'];
            $data['user_paw'] = MD5($_POST['user'].$_POST['paw']);
            $data['user_addtime'] = time();
            $data['user_name'] = $_POST['name'];
            $data['user_grade'] = $_POST['type'];
            $data['user_if'] = 1;
            $user = db('user')->insertGetId($data);
            if($user){
                // 添加成功
                $data['type'] = 1;
                return json($data);die;
            }else{
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '添加失败！';
                return json($data);die;
            }
        }
        $roles = db('roles')->where('roles_if = 1')->select();
        $this -> assign('roles',$roles);
        return $this->fetch();
    }
    
    public function del(){
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $user = db('user')->where('user_id',$id)->find();
            if($user){
                if($user['user_id']==1||$user['user_id']==2){
                    $this -> error('总管理员不可删除！');
                }
                $body = db('user')->where('user_id = '.$id)->delete();
                if($body){
                    echo "<script>alert('删除成功！');location.href='/index/user/index';</script>";
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
    
    public function update(){
        if($_POST){
            $id = $_POST['id'];
            $user = db('user')->where('user_id',$id)->find();
            if($user){
                $data['user_account'] = $_POST['user'];
                $data['user_name'] = $_POST['name'];
                $data['user_grade'] = $_POST['type'];
                $body = db('user')->where('user_id = '.$id)->update($data);
                if($body){
                    // 添加成功
                    $data['type'] = 1;
                    return json($data);die;
                }else{
                    // 提交失败获取错误信息
                    $data['type'] = 2;
                    $data['error'] = '无修改不能提交！';
                    return json($data);die;
                }
            }else{
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '要修改的数据不存在！';
                return json($data);die;
            }
        }
        if(!empty($_GET['id'])){
            $user = db('user')->where('user_id = '.$_GET['id'])->find();
            $roles = db('roles')->where('roles_if = 1')->select();
            $this -> assign('roles',$roles);
            $this -> assign('user',$user);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    public function paw(){
        if($_POST){
            $id = $_POST['id'];
            $user = db('user')->where('user_id',$id)->find();
            if($user){
                $data['user_paw'] = MD5($user['user_account'].$_POST['paw']);
                $body = db('user')->where('user_id = '.$id)->update($data);
                if($body){
                    // 添加成功
                    $data['type'] = 1;
                    return json($data);die;
                }else{
                    // 提交失败获取错误信息
                    $data['type'] = 2;
                    $data['error'] = '无修改不能提交！';
                    return json($data);die;
                }
            }else{
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '要修改的数据不存在！';
                return json($data);die;
            }
        }
        if(!empty($_GET['id'])){
            $this -> assign('id',$_GET['id']);
            return $this->fetch();
        }else{
            $this -> error('找不到主体信息,请联系管理员！');
        }
    }
    
    
    public function user_if(){
        if($_POST){
            $id = $_POST['id'];
            $user = db('user')->where('user_id',$id)->find();
            if($user){
                if($user['user_id']==1||$user['user_id']==2){
                    // 提交失败获取错误信息
                    $data['type'] = 2;
                    $data['error'] = '总管理员不可停用！';
                    return json($data);die;
                }
                $data['user_if'] = $_POST['type'];
                $body = db('user')->where('user_id = '.$id)->update($data);
                if($body){
                    // 添加成功
                    $data['type'] = 1;
                    return json($data);die;
                }else{
                    // 提交失败获取错误信息
                    $data['type'] = 2;
                    $data['error'] = '无修改不能提交！';
                    return json($data);die;
                }
            }else{
                // 提交失败获取错误信息
                $data['type'] = 2;
                $data['error'] = '要修改的数据不存在！';
                return json($data);die;
            }
        }else{
            // 提交失败获取错误信息
            $data['type'] = 2;
            $data['error'] = '无法获取修改项！';
            return json($data);die;
        }
    }
}
