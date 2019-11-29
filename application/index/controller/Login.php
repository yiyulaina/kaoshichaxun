<?php
namespace app\index\controller;
//use think\View;
use think\Controller;
class login extends Controller{
    
    public function index(){
        if($_POST){
            if(!$_POST['yhm']){
                echo "<script>alert('请填写用户名！');window.history.go(-1);</script>";
                return;
            }
            if(!$_POST['mm']){
                echo "<script>alert('请输入密码！');window.history.go(-1);</script>";
                return;
            }
            //if(!captcha_check($_POST['yzm'])){
//                echo "<script>alert('输入的验证码有误！');window.history.go(-1);</script>";
//                return;
//            }else{
                $user = db('user')->where('user_account',$_POST['yhm'])->find();
                if(md5($_POST['yhm'].$_POST['mm']) != $user['user_paw']){
                    echo "<script>alert('您的账号或密码不正确！');window.history.go(-1);</script>";
                    return;
                }
                if($user['user_if'] == 0){
                    echo "<script>alert('此账号已停用！');window.history.go(-1);</script>";
                    return;
                }
                session('uid', $user['user_id']);
                session('name', $user['user_name']);
                session('account', $user['user_account']);
                $this->success('登录成功',url('index/index').'?type=1');
                return;
            //}
        }
        return $this->fetch('login/index');
    }
    
    public function logout(){
        session(null);
        echo "<script>alert('退出成功！');window.location.href='index';</script>";
    }
    
    public function captcha(){
        import('lib.src.Captcha',EXTEND_PATH);
        $Captcha = new\Captcha();
        return $Captcha->entry();
    }
    
    
}
