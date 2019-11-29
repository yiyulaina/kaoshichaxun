<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------



// 应用公共文件
function redis_cr($data,$type,$query_type){
    $redis = new Redis();
    //连接redis服务器1111333
    $redis->connect('127.0.0.1', '6379');
    $redis->auth('123');
    $redis->select($type);
    $redis->pipeline();
    foreach ($data as $k => $v) {
        if(in_array(1,$query_type)){
            if(in_array(2,$query_type)){
                if(in_array(3,$query_type)){
                    $rk=md5($v['KSH'].$v['XM'].$v['SFZH']);
                }else{
                    $rk=md5($v['KSH'].$v['XM']);
                }
            }else{
                if(in_array(3,$query_type)){
                    $rk=md5($v['KSH'].$v['SFZH']);
                }else{
                    $rk=md5($v['KSH']);
                }
            }
        }else{
            if(in_array(2,$query_type)){
                if(in_array(3,$query_type)){
                    $rk=md5($v['XM'].$v['SFZH']);
                }else{
                    $rk=md5($v['XM']);
                }
            }else{
                if(in_array(3,$query_type)){
                    $rk=md5($v['SFZH']);
                }else{
                    return '请先选着搜索项';
                    die;
                }
            }
        }
        $str=json_encode($v);
        $redis->set($rk, $str);
    }
    $redis->exec();
    //$cx=$redis->dbSize();
    $redis->close();
    //if($cx==count($data)){
    //	return '已完全导入';
    //}else{
    	return '已导入完成';
    //}
}

function redis_jc_set($data){
    $redis = new Redis();
    //连接redis服务器1111333
    $redis->connect('127.0.0.1', '6379');
    $redis->auth('123');
    $redis->select('5');
    $redis->pipeline();
    foreach ($data as $k => $v) {
        $rk=$k;
        $str=$v;
        $redis->set($rk, $str);
    }
    $redis->exec();
    $redis->close();
    return 1;
}
function redis_jc_get($data){
    $redis = new Redis();
    //连接redis服务器1111333
    $redis->connect('127.0.0.1', '6379');
    $redis->auth('123');
    $redis->select('5');
    $sfz = $redis->get($data);
    $redis->close();
    return $sfz;
}


// 应用公共文件
function captcha_check($captcha){
    import('lib.src.Captcha',EXTEND_PATH);
    $Captcha = new\Captcha();
    return $Captcha->check($captcha);
}

 /**
 * [生成文件]
 * @param  [type] $content [内容]
 * @param  string $title   [文件夹名]
 * @param  string $keyp    [文件名]+[文件类型]
 */
function mylog($content,$title, $keyp = ""){
    $dir = ROOT_PATH.'public/runtime/'.$title;
    if ($keyp == "") {
        $log_filename = ROOT_PATH.'public/runtime/wzx/' . date('Ym-d') . ".html";
    } else {
        $log_filename = ROOT_PATH.'public/runtime/'.$title.'/' . $keyp;
    }
    if (!file_exists($dir)){
        mkdir ($dir);
    }
    //print_r(RUNTIME_PATH);die;
    $file = file_put_contents($log_filename,$content);
    if($file){
        return true;
    }else{
        return false;
    }
}

//get提交
function curl_get_https($url){
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
    //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
    $tmpInfo = curl_exec($curl);     //返回api的json对象
    //关闭URL请求
    curl_close($curl);
    return $tmpInfo;    //返回json对象
}
 
/**
 * 获取查询首页内容
 */
function Returnindex($query_type , $new){
    $data = '<!DOCTYPE html>
            <html>
            <head>
  		        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        		<meta http-equiv="x-ua-compatible" content="ie=7" />
        		<title></title>
        		<meta content="" name="keywords" />
        		<meta content="" name="description" />
        		<style>
        			@charset"utf-8";body,div,html{margin:0;padding:0;border:0}body{list-style:none font-size:12px;font-family:\'微软雅黑\', \'Microsoft YaHei\', \'宋体\', \'MicrosoftJhengHei\', \'华文细黑\', \'STHeiti\', \'MingLiu\'}button{cursor:pointer;font-size:22px}button,input{outline:none;border:none}a:visited{text-decoration:none}a:active,a:hover{text-decoration:underline;color:#000000}.index_lcForm,.index_lcForm .button{width:522px;margin:0 auto}.index_lcForm .form{width:514px;height:50px;margin-bottom:17px;overflow:hidden;border:2px solid #CCCCCC;border-radius:25px;padding:2px}.index_lcForm .form input{width:100%;height:50px;line-height:50px;padding:0 25px;font-size:18px}.drag{width:500px;height:52px;line-height:52px;background-color:#e8e8e8;position:relative;margin:0 auto}.bg{width:50px;height:100%;position:absolute;background-color:#75CDF9}.text{position:absolute;width:100%;height:100%;text-align:center;user-select:none}.btn{width:50px;height:50px;position:absolute;border:1px solid #ccc;cursor:move;font-family:"宋体";text-align:center;background-color:#fff;user-select:none;color:#666}
        		</style>
        	</head>
        	<body style="background: #0071bf">
                <div style="margin-top: 75px">
                    <div style="text-align: center">
                        <p style="font-size:24px;color:#FFFFFF">辽宁省高中等教育招生考试委员会办公室</p>
                    </div>
                </div>
        		<div style="margin-top:75px;">
        			<div style="padding-bottom: 50px; overflow: hidden;background: #FFFFFF">
        				<div style="margin-top: 50px;margin-bottom: 25px;text-align: center;font-style: italic">
        					<div style="font-size: 60px;font-family: " 黑体 ";font-weight: bold;color:#333333">'.$new['news_title'].'</div>
        					<div style="font-size: 24px;font-family: verdana;color:#666666">Examination Information Query System</div>
        				</div>
        				<form action="'.$new['news_id'].'.php" method="post" name="myform" onsubmit="return sub();">
        					<div class="index_lcForm">';
    if(in_array(1,$query_type)){
        $data .= '<div class="form"><input placeholder="请输入考生号" id="kh" name="kh" required="required" maxlength="20"/></div>';
    }
    if(in_array(2,$query_type)){
        $data .= '<div class="form"><input placeholder="请输入考生姓名" id="xm" name="xm" required="required" maxlength="100"/></div>';
    }
    if(in_array(3,$query_type)){
        $data .= '<div class="form"><input placeholder="请输入身份证号码" id="sfzh" name="sfzh" required="required" maxlength="20"/></div>';
    }
    if($new['news_type']==1){
        $data .= '<div class="form"><input placeholder="请输入准考证号" id="zkz" name="zkz" required="required" maxlength="20" /></div>';
    }
              $data .= '
						<div class="yzm" id="div_yzm">
							<div class="form">
								<input placeholder="请输入验证码" id="yzm" name="yzm" maxlength="6" />
							</div>
							<div style="max-width: 25%;float: left;height: 50px;overflow: hidden;border-radius: 10px;position: relative;top: -71px;float: right;right: 15px">
								<a href="javascript:void(0);" onclick="document.getElementById(\'captcha_img\').src=\'../captcha.php\';"><img id="captcha_img" class="height: 50px" src="../captcha.php" /></a>
							</div>
							<button type="submit" style="width:100%;background: #666666;color: #FFFFFF;height: 60px; border-radius: 15px;margin-top:-20px;">查询</button>
						</div>
					</div>
				</form>
			</div>';
if(!empty($new['news_body'])){
    $data .= '<div style="width:520px;background-color: #FFF;margin:20px auto;padding: 20px;border-radius: 25px;">
				'.$new['news_body'].'
			</div>';
}
    $data .= '
            <div style="margin-top: 45px">
				<div style="text-align: center">
					<p style="font-size:14px;color:#FFFFFF">版权所有 辽宁省高中等教育招生考试委员会办公室</p>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			function sub() {';
    if(in_array(1,$query_type)){
        $data .= 'var kh = document.getElementById("kh").value;';
    }
    if(in_array(2,$query_type)){
        $data .= 'var xm = document.getElementById("xm").value;';
    }
    if(in_array(3,$query_type)){
        $data .= 'var sfzh = document.getElementById("sfzh").value;';
    }		
        $data .= '
                var yzm = document.getElementById("yzm").value;
                var regName = /^[\u4e00-\u9fa5]{2,50}$/;
                var start = '.$new['news_start_time'].';
                var end = '.$new['news_end_time'].';
                var time = Date.parse(new Date())/1000;
				if(time < start || time > end ) {
					alert(\'此查询不在查询时间范围内\');
					return false;
				}
				if(kh == \'\') {
					alert(\'请输入您的考生号\');
					return false;
				}
				var regIdCard = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
				if(!regIdCard.test(sfzh)) {
					alert(\'请输入您的身份证号\');
					return false;
				}
				if(yzm == \'\') {
					alert(\'请输入验证码\');
					return false;
				}
			}
		</script>
	</body>
</html>';
    return $data;
}


 
/**
 * 获取查询内容页内容
 */
function Returnbody($query_type, $new){
    $data = '<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta http-equiv="x-ua-compatible" content="ie=7" />
                    <title></title>
                    <meta content="" name="keywords" />
                    <meta content="" name="description" />
                    <style type="text/css">
                        @charset"utf-8";body,div,html{margin:0;padding:0;border:0}body{font-size:12px;font-family:\'微软雅黑\', \'Microsoft YaHei\', \'宋体\', \'MicrosoftJhengHei\', \'华文细黑\', \'STHeiti\', \'MingLiu\'}body ul,li{margin:0;padding:0;list-style:none}button{cursor:pointer;font-size:22px}button,input{outline:none;border:none}a:visited{text-decoration:none}a:active,a:hover{text-decoration:underline;color:#000000}.yq{border:1px solid red}.basc-bg-white{background:#FFFFFF}.basc-bg-blu{background:#0071bf}.basc-black,.basc-black a,.basc-black p{color:#000000}.basc-black3,.basc-black3 a,.basc-black3 p{color:#333333}.basc-black6,.basc-black6 a,.basc-black6 p{color:#666666}.basc-black9,.basc-black9 a,.basc-black9 p{color:#999999}.basc-white,.basc-white a,.basc-white p{color:#FFFFFF}.basc-red,.basc-red a,.basc-red p{color:red}.basc-fs14{font-size:14px}.basc-fs16{font-size:16px}.basc-fs24{font-size:24px}.basc-btn-bak{background:#666666;color:#FFFFFF}.basc-italic{font-style:italic}.basc-bold{font-weight:bold}.basc-txt-center{text-align:center}#alert{display:none}.basc-alert{position:fixed;width:100%;top:0;background:#000000;height:100%;opacity:0.8;filter: alpha(opacity:80);opacity:0.8;-moz-opacity:0.8}.basc-showAlert{width:100%;position:fixed;top:30%}.basc-showAlert .show{width:480px;margin:0 auto;background:#FFFFFF;border-radius:15px;overflow:hidden}.basc-showAlert .show .title,.basc-showAlert .show .txt{margin:0 5px;padding:0 40px}.basc-showAlert .show .title{height:48px;line-height:48px;margin-top:10px;border-bottom:1px solid #CCCCCC}.basc-showAlert .show .txt{line-height:24px;margin-top:20px;margin-bottom:20px}.index_la,.index_lb,.index_lc{overflow:hidden;background:#FFFFFF}.index_la,.index_lb,.main_la{background:rgba(255, 255, 255, 0.5);opacity:0.5;filter: alpha(opacity:50);opacity:0.5;-moz-opacity:0.5}.index_la{height:610px}.index_lb{height:548px}#bodyCon{}.index_lc{}.index_lcForm,.index_lcForm .button{width:522px;margin:0 auto}.index_lcTitle{margin-top:50px;margin-bottom:25px;text-align:center}.index_lcTitle .title,.main_lbTitle .title{font-size:60px;font-family:"黑体"}.index_lcTitle .txt,.main_lbTitle .txt{font-size:24px;font-family:verdana}.index_lcForm .form{width:514px;height:50px;margin-bottom:17px;overflow:hidden;border:2px solid #CCCCCC;border-radius:25px;padding:2px}.index_lcForm .form input{width:100%;height:50px;line-height:50px;padding:0 25px;font-size:18px}.index_lcForm .button{height:60px;border-radius:15px}.index_ld{margin-top:45px}.main_la{height:290px}.main_lc,.main_ld{width:700px;margin:0 auto}.main_lbTitle{margin-bottom:30px;text-align:center}.main_lc{border-radius:15px;overflow:hidden;padding-bottom:25px}.main_lc .title{line-height:34px;margin:20px;overflow:hidden;border-bottom:1px solid #CCCCCC;padding:8px 25px}.main_lc .txtList{margin:0 20px}.main_lc .txtList li{overflow:hidden;margin:0 70px 10px;border:1px solid #CCCCCC}.main_lc .txtList li .name,.main_lc .txtList li .txt{line-height:24px;float:left;padding:8px 10px}.main_lc .txtList li .name{background:#efefef;border-right:1px solid #CCCCCC}.main_lc .txtList li .txt{border-top:1px solid #CCCCCC;margin-top:-1px}.main_ld{line-height:50px;margin-bottom:50px}.yzm{}.yzm .img{max-width:25%;float:left;height:50px;overflow:hidden;border-radius:10px;position:relative;top:-71px;float:right;right:15px}.yzm .img img{height:50px}.yzm .button{margin-top:-20px}
                    </style>
                </head>
            <?php
            function getIP(){
                if (!empty($_SERVER[\'HTTP_CLIENT_IP\'])){
                    //ip是否来自共享互联网
                    $ip = $_SERVER[\'HTTP_CLIENT_IP\'];
                }elseif (!empty($_SERVER[\'HTTP_X_FORWARDED_FOR\'])){
                    //ip是否来自代理
                    $ip = $_SERVER[\'HTTP_X_FORWARDED_FOR\'];
                }else{
                    //ip是否来自远程地址
                    if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")){
                        $ip = $_SERVER["REMOTE_ADDR"];
                    } else {
                        if (isset ($_SERVER[\'REMOTE_ADDR\']) && $_SERVER[\'REMOTE_ADDR\'] && strcasecmp($_SERVER[\'REMOTE_ADDR\'],"unknown")){
                            $ip = $_SERVER[\'REMOTE_ADDR\'];
                        } else {
                            $ip = "未获取成功";
                        }
                    }
                }
                return $ip;
            }
            function getIPLocation($queryIP){
                $city = "暂未获取";
                return $city;
            }
            function Get_Os(){
                if(!empty($_SERVER[\'HTTP_USER_AGENT\'])){
                    $OS = $_SERVER[\'HTTP_USER_AGENT\'];
                    $agent = strtolower($OS);
                    $is_iphone = (strpos($agent, \'iphone\')) ? true : false;
                    $is_android = (strpos($agent, \'android\')) ? true : false;
                    $is_ipad = (strpos($agent, \'ipad\')) ? true : false;
                    if($is_iphone){
                        $xtlx = \'iphone\';
                    }else if($is_android){
                        $xtlx = \'android\';
                    }else if($is_ipad){
                        $xtlx = \'ipad\';
                    }else{
                        if (preg_match(\'/win/i\',$OS)) {
                            $xtlx = \'Windows\';
                        }
                        elseif (preg_match(\'/mac/i\',$OS)) {
                            $xtlx = \'MAC\';
                        }
                        elseif (preg_match(\'/linux/i\',$OS)) {
                            $xtlx = \'Linux\';
                        }
                        elseif (preg_match(\'/unix/i\',$OS)) {
                            $xtlx = \'Unix\';
                        }
                        elseif (preg_match(\'/bsd/i\',$OS)) {
                            $xtlx = \'BSD\';
                        }
                        else {
                            $xtlx = \'其他\';
                        } 
                    }
                    return $xtlx; 
                }else{
                    return "未知系统";
                }   
            }
            session_start();
            if(isset($_SESSION[\'authcode\']))
            {
                if($_POST["yzm"] == $_SESSION[\'authcode\']){
                    $time = time();
                    if($time < '.$new['news_start_time'].' || $time > '.$new['news_end_time'].' ){
                        echo "<script>alert(\'此查询不在查询时间范围内\');window.history.go(-1); </script>";die;
                    }
                    session_unset();
                    $ip = json_encode(getIP());
                    $system = json_encode(Get_Os());
                    $redis = new Redis();
                    //连接redis服务器
                    $redis->connect("127.0.0.1", "6379");
                    $redis->auth("123");
                    $redis->select('.$new['news_type'].');
                    $data_message = "";';
    if(in_array(1,$query_type)){
        $data .= '$kh_data = $_POST[\'kh\'];$data_message .= "考生号:".$kh_data."，";';
    }
    if(in_array(2,$query_type)){
        $data .= '$name_data = $_POST[\'xm\'];$data_message .= "姓名:".$name_data."，";';
    }
    if(in_array(3,$query_type)){
        $data .= '$shenfenzheng_data = $_POST[\'sfzh\'];$data_message .= "身份证号码:".$shenfenzheng_data."，";';
    }
    if($new['news_type']==1){
        $data .= '$zkz_data = $_POST[\'zkz\'];';
    }
    if(in_array(1,$query_type)){
        if(in_array(2,$query_type)){
            if(in_array(3,$query_type)){
                $data .= '$rk=md5($kh_data.$name_data.$shenfenzheng_data);';
            }else{
                $data .= '$rk=md5($kh_data.$name_data);';
            }
        }else{
            if(in_array(3,$query_type)){
                $data .= '$rk=md5($kh_data.$shenfenzheng_data);';
            }else{
                $data .= '$rk=md5($kh_data);';
            }
        }
    }else{
        if(in_array(2,$query_type)){
            if(in_array(3,$query_type)){
                $data .= '$rk=md5($name_data.$shenfenzheng_data);';
            }else{
                $data .= '$rk=md5($name_data);';
            }
        }else{
            if(in_array(3,$query_type)){
                $data .= '$rk=md5($shenfenzheng_data);';
            }
        }
    }
        $data .=   '$cx = $redis->get($rk);
                    if($cx){
                        $res=json_decode($cx,true);';
    if($new['news_type']==1){
        $data .= '$ksh = $res["KSH"];$xm = $res["XM"];$sfzh = $res["SFZH"];$zkzh = $res["ZKZH"];$kmm1 = $res["KMM1"];$kmm2 = $res["KMM2"];$kmm3 = $res["KMM3"];$kmm4 = $res["KMM4"];$fs1 = $res["FS1"];$fs2 = $res["FS2"];$fs3 = $res["FS3"];$fs4 = $res["FS4"];$fs = $res["FS"];
                 if($zkzh != $zkz_data ){echo "<script>alert(\'准考证号不正确\');window.history.go(-1); </script>";die;}
                 ';
    }else if($new['news_type']==2){
        $data .= '$ksh = $res["KSH"];$xm = $res["XM"];$sfzh = $res["SFZH"];$cj = json_encode($res["cj"]);';
    }else if($new['news_type']==4){
        $data .= '$ksh = $res["KSH"];$xm = $res["XM"];$sfzh = $res["SFZH"];$ccdm = $res["CCDM"];$ccmc = $res["CCMC"];$yxdm = $res["YXDM"];$yxmc = $res["YXMC"];$zydm = $res["ZYDM"];$zymc = $res["ZYMC"];$xznx = $res["XZNX"];';
    }else if($new['news_type']==11){
        $data .= '$ksh = $res["KSH"];$xm = $res["XM"];$sfzh = $res["SFZH"];$jckcj = $res["JCKCJ"];$cj = json_encode($res["cj"]);';
    }else{
        $data .= '$ksh = $res["KSH"];$xm = $res["XM"];$sfzh = $res["SFZH"];$km1 = $res["KM1"];$km2 = $res["KM2"];$km3 = $res["KM3"];$km4 = $res["KM4"];$kmm1 = $res["KMM1"];$kmm2 = $res["KMM2"];$kmm3 = $res["KMM3"];$kmm4 = $res["KMM4"];$fs = $res["ZF"];';
    }
                    
        $data .= '
                    }else{
                        $host="localhost";
                        $db_user="sunbowen";
                        $db_pass="sunbowen2019";
                        $db_name="query";
                        $b_name="cx_'.$new['type_dbname'].'_'.$new['news_id'].'";
                        $timezone="Asia/Shanghai";
                        $conn = new mysqli($host, $db_user, $db_pass, $db_name);
                        // Check connection
                        if ($conn->connect_error) {
                            die("连接失败: " . $conn->connect_error);
                        }';
        if(in_array(1,$query_type)){
            if($new['news_type']==1){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,zkzh,kmm1,kmm2,kmm3,kmm4,fs1,fs2,fs3,fs4, fs FROM ".$b_name." where ksh = ?");$stmt->bind_param("s", $kh_data);';
            }else if($new['news_type']==2){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, kmm, fs, type FROM ".$b_name." where ksh = ?");$stmt->bind_param("s", $kh_data);';
            }else if($new['news_type']==4){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, ccdm,ccmc,yxdm,yxmc,zydm,zymc,xznx FROM ".$b_name." where ksh = ?");$stmt->bind_param("s", $kh_data);';
            }else if($new['news_type']==11){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, km, zyfx, zmh, jckcj, zf FROM ".$b_name." where ksh = ?");$stmt->bind_param("s", $kh_data);';
            }else{
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4,zf FROM ".$b_name." where ksh = ?");$stmt->bind_param("s", $kh_data);';
            }
        }else if(in_array(2,$query_type)){
            if($new['news_type']==1){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,zkzh,kmm1,kmm2,kmm3,kmm4,fs1,fs2,fs3,fs4, fs FROM ".$b_name." where xm = ?");$stmt->bind_param("s", $name_data);';
            }else if($new['news_type']==2){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, kmm, fs, type FROM ".$b_name." where xm = ?");$stmt->bind_param("s", $name_data);';
            }else if($new['news_type']==4){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, ccdm,ccmc,yxdm,yxmc,zydm,zymc,xznx FROM ".$b_name." where xm = ?");$stmt->bind_param("s", $name_data);';
            }else if($new['news_type']==11){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, km, zyfx, zmh, jckcj, zf FROM ".$b_name." where xm = ?");$stmt->bind_param("s", $name_data);';
            }else{
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4,zf FROM ".$b_name." where xm = ?");$stmt->bind_param("s", $name_data);';
            }
        }else if(in_array(2,$query_type)){
            if($new['news_type']==1){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,zkzh,kmm1,kmm2,kmm3,kmm4,fs1,fs2,fs3,fs4, fs FROM ".$b_name." where sfzh = ?");$stmt->bind_param("s", $shenfenzheng_data);';
            }else if($new['news_type']==2){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, kmm, fs, type FROM ".$b_name." where sfzh = ?");$stmt->bind_param("s", $shenfenzheng_data);';
            }else if($new['news_type']==4){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, ccdm,ccmc,yxdm,yxmc,zydm,zymc,xznx FROM ".$b_name." where sfzh = ?");$stmt->bind_param("s", $shenfenzheng_data);';
            }else if($new['news_type']==11){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, km, zyfx, zmh, jckcj, zf FROM ".$b_name." where sfzh = ?");$stmt->bind_param("s", $shenfenzheng_data);';
            }else{
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4,zf FROM ".$b_name." where sfzh = ?");$stmt->bind_param("s", $shenfenzheng_data);';
            }
        }
        if($new['news_type']==1){
            $data .=    '$stmt->bind_result($ksh,$xm,$sfzh,$zkzh,$kmm1,$kmm2,$kmm3,$kmm4,$fs1,$fs2,$fs3,$fs4,$fs);
                        $stmt->execute();
                        $stmt->fetch();
                        if(empty($ksh) ){
                            echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                        }
                        if($zkzh != $zkz_data ){echo "<script>alert(\'准考证号不正确\');window.history.go(-1); </script>";die;}';
        }else if($new['news_type']==2){
            $data .=    '$stmt->bind_result($ksh,$xm,$sfzh,$kmm,$fs,$type);
                        $stmt->execute();
                        while($stmt->fetch()){
                            $kmm_all[] = $kmm;
                            $fs_all[] = $fs;
                            $type_all[] = $type;
                        };
                        if(empty($ksh) ){
                            $ip = getIP();
                            $add = getIPLocation($ip);
                            $system = Get_Os();
                            $time = time();
                            $data_message .= \'查询条件不正确\';
                            $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                            $conn->query($sql);
                            echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                        }';
        }else if($new['news_type']==4){
            $data .=    '$stmt->bind_result($ksh,$xm,$sfzh,$ccdm,$ccmc,$yxdm,$yxmc,$zydm,$zymc,$xznx);
                        $stmt->execute();
                        $stmt->fetch();
                        if(empty($ccdm) ){echo "<script>alert(\'该用户暂无录取数据\');window.history.go(-1); </script>";die;}';
        }else if($new['news_type']==11){
            $data .=    '$stmt->bind_result($ksh,$xm,$sfzh,$km,$zyfx,$zmh,$jckcj,$fs);
                        $stmt->execute();
                        while($stmt->fetch()){
                            $kmm_all[] = $km."->".$zyfx."->".$zmh;
                            $fs_all[] = $fs;
                        };
                        if(empty($fs) ){echo "<script>alert(\'该用户暂无成绩\');window.history.go(-1); </script>";die;}';
        }else{
            $data .=    '$stmt->bind_result($ksh,$xm,$sfzh,$km1,$km2,$km3,$km4,$kmm1,$kmm2,$kmm3,$kmm4,$fs);
                        $stmt->execute();
                        $stmt->fetch();
                        if(empty($fs) ){echo "<script>alert(\'该用户暂无录取数据\');window.history.go(-1); </script>";die;}';
        }
        if(in_array(1,$query_type)){
            if(in_array(2,$query_type)){
                $data .= '
                            if($xm != $name_data){
                                $ip = getIP();
                                $add = getIPLocation($ip);
                                $system = Get_Os();
                                $time = time();
                                $data_message .= \'查询条件不正确\';
                                $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                                $conn->query($sql);
                                echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                            }else{';
                if(in_array(3,$query_type)){
                    $data .= '
                                if($sfzh != $shenfenzheng_data){
                                    $ip = getIP();
                                    $add = getIPLocation($ip);
                                    $system = Get_Os();
                                    $time = time();
                                    $data_message .= \'查询条件不正确\';
                                    $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                                    $conn->query($sql);
                                    echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                                }';
                }
                $data .= '}';
            }else{
                if(in_array(3,$query_type)){
                    $data .= '
                                if($sfzh != $shenfenzheng_data){
                                    $ip = getIP();
                                    $add = getIPLocation($ip);
                                    $system = Get_Os();
                                    $time = time();
                                    $data_message .= \'查询条件不正确\';
                                    $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                                    $conn->query($sql);
                                    echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                                }';
                }
            }
        }else{
            if(in_array(2,$query_type)){
                $data .= '
                            if($sfzh != $shenfenzheng_data){
                                $ip = getIP();
                                $add = getIPLocation($ip);
                                $system = Get_Os();
                                $time = time();
                                $data_message .= \'查询条件不正确\';
                                $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                                $conn->query($sql);
                                echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                            }';
            }else{
                if(in_array(3,$query_type)){
                    $data .= '
                                if($sfzh != $shenfenzheng_data){
                                    $ip = getIP();
                                    $add = getIPLocation($ip);
                                    $system = Get_Os();
                                    $time = time();
                                    $data_message .= \'查询条件不正确\';
                                    $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                                    $conn->query($sql);
                                    echo "<script>alert(\'查询条件不正确\');window.history.go(-1); </script>";die;
                                }';
                }else{
                    $data .= '
                                if($sfzh != $shenfenzheng_data){
                                    $ip = getIP();
                                    $add = getIPLocation($ip);
                                    $system = Get_Os();
                                    $time = time();
                                    $data_message .= \'该考试查询还未开启\';
                                    $sql = "INSERT INTO cx_journal (journal_news_id,journal_system,journal_ip,journal_add,journal_message,journal_addtime,journal_sf) VALUES (\''.$new['news_id'].'\',\'$system\',\'$ip\',\'$add\',\'$data_message\',\'$time\',\'1\')";
                                    $conn->query($sql);
                                    echo "<script>alert(\'该考试查询还未开启\');window.history.go(-1); </script>";die;
                                }';
                }
            }
        }
            $data .= '
                    }
                }else{
                    session_unset();
                    echo "<script>alert(\'验证码错误\');window.history.go(-1); </script>";
                    die;
                }
            }else{
                echo "<script>alert(\'验证失败,请重新输入\');window.history.go(-1); </script>";
                die;
            }
            ?>
                <body class="basc-bg-blu">
                    <div id="bodyCon"  style="margin-top:150px;">
                        <div class="main_lb">
                            <div class="basc-italic main_lbTitle basc-white">
                                <div class="title  basc-bold">'.$new['news_title'].'</div>
                                <div class="txt">Examination Information Query System</div>
                            </div>
                            <div class="main_lc basc-bg-white">
                                <div class="title basc-black3 basc-bold basc-fs24"></div>
                                <ul id="chengji" class="txtList">
                                    <li>
                                        <div class="name" style="width: 60px;text-align:center;">考生姓名</div>
                                        <div class="txt"><?php echo $xm?></div>
                                    </li>
                                    <li>
                                        <div class="name" style="width: 60px;text-align:center;">考 试 号</div>
                                        <div class="txt"><?php echo $ksh?></div>
                                    </li>
                                    <li>
                                        <div class="name" style="width: 60px;text-align:center;">身份证号</div>
                                        <div class="txt"><?php echo $sfzh?></div>
                                    </li>';
        if($new['news_type']==1){
                        $data .=    '<li>
                                        <div class="name" style="width: 60px;text-align:center;">准考证号</div>
                                        <div class="txt"><?php echo $zkzh?></div>
                                    </li>';
        }
        if($new['news_type']==4){
                        $data .=    '<li>
                                        <div class="name" style="width: 100%;text-align: center;">录取院校</div>
                                    </li>';
        }else if($new['news_type']==2){
                        $data .=    '<li>
                                        <div class="name" style="width: 100%;text-align: center;">自学考试成绩</div>
                                    </li>';
        }else{
                        $data .=    '<li>
                                        <div class="name" style="width: 100%;text-align: center;">考生成绩</div>
                                    </li>';
        }
                                    
                                    
        if($new['news_type']==1){
            $data .=    '<?php if(!empty($kmm1)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm1 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs1 ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm2)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm2 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs2 ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm3)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm3 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs3 ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm4)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm4 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs4 ?></div>
                            </li>
                        <?php } ?>
                        <li>
                            <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">总分</div>
                            <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs ?></div>
                        </li>';
        }else if($new['news_type']==2){
            $data .=    '<?php 
                            if(!empty($kmm_all)){
                            $a1 = 0;
                                foreach($kmm_all as $k => $v ){ 
                                    if($type_all[$k]==1){
                                    $a1++;
                        ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;"><?php echo $v ?></div>
                                <div class="txt" style="width: 44%;text-align:center;border-left: 1px solid #CCCCCC;">
                                    <?php if($fs_all[$k]==-1){echo "考生缺考";}else if($fs_all[$k]==-2){echo "考生违纪，取消本次考试违纪科目的单科考试成绩";}else if($fs_all[$k]==-3||$fs_all[$k]==-4||$fs_all[$k]==-5){echo "考生作弊，取消本次考试的全部成绩";}else{echo $fs_all[$k];} ?>
                                </div>
                            </li>
                        <?php       
                                    }
                                }
                                if($a1==0){
                         ?>
                            <li><div class=\'txt\' style=\'width: 100%;text-align: center;\'>无</div></li>
                        <?php
                                }
                        ?>
                            <li><div class=\'name\' style=\'width: 100%;text-align: center;\'>自学考试实践环节成绩</div></li>
                        <?php 
                            $a2 = 0;
                                foreach($kmm_all as $k => $v ){ 
                                    if($type_all[$k]==2){
                                    $a2++;
                        ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;"><?php echo $v ?></div>
                                <div class="txt" style="width: 44%;text-align:center;border-left: 1px solid #CCCCCC;">
                                    <?php if($fs_all[$k]==-1){echo "考生缺考";}else if($fs_all[$k]==-2){echo "考生违纪，取消本次考试违纪科目的单科考试成绩";}else if($fs_all[$k]==-3||$fs_all[$k]==-4||$fs_all[$k]==-5){echo "考生作弊，取消本次考试的全部成绩";}else{echo $fs_all[$k];} ?>
                                </div>
                            </li>
                        <?php  
                                    }
                                }
                                if($a2==0){
                         ?>
                            <li><div class=\'txt\' style=\'width: 100%;text-align: center;\'>无</div></li>
                        <?php
                                }
                            }
                        ?>';
        }else if($new['news_type']==4){
            $data .=    '   <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">层次名称</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $ccmc ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">院校名称</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $yxmc ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">专业名称</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $zymc ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">学制</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $xznx ?></div>
                            </li>';
        }else if($new['news_type']==11){
            $data .=    '<li>
                            <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">基础课成绩</div>
                            <div class="txt" style="width: 44%;text-align:center;"><?php echo $jckcj ?></div>
                        </li>
                        <?php if(!empty($kmm_all)){foreach($kmm_all as $k => $v ){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $v ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs_all[$k] ?></div>
                            </li>
                        <?php }} ?>';
        }else{
            $data .=    '<?php if(!empty($kmm1)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm1 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km1 ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm2)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm2 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km2 ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm3)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm3 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km3 ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm4)){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm4 ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km4 ?></div>
                            </li>
                        <?php } ?>
                        <li>
                            <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">总分</div>
                            <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs ?></div>
                        </li>';
        }
                    $data .=    '</ul>
                            </div>
                        </div>  ';
if(!empty($new['news_body'])){
    $data .= '<div style="width:660px;background-color: #FFF;margin:20px auto;padding: 20px;border-radius: 25px;">
				'.$new['news_body'].'
			</div>';
}
    $data .= '
                        <div class="main_ld">
                            <div class="basc-txt-center">
                                <p class="basc-fs14 basc-white">版权所有 辽宁省高中等教育招生考试委员会办公室</p>
                            </div>
                        </div>
                    </div>
                    <script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>
                    <script>
                        var id = '.$new['news_id'].';
                        var _pf=navigator.platform; 
                        var appVer=navigator.userAgent;
                        var url = <?php echo $ip?>;
                        var system = <?php echo $system?>;
                        if(typeof returnCitySN!=="undefined"){
                            var add = returnCitySN["cname"];
                        }else{
                            var add = "未获取成功";
                        }
                        var xx = \'考生号：<?php echo $ksh?>，姓名：<?php echo $xm?>，身份证号：<?php echo $sfzh?>\';';
            if($new['news_type']==2){
                $data .= '
                            <?php if(!empty($cj)){ ?>
                                var cj = <?php echo $cj?>;
                                var cj = cj.split("|");
                                var km = cj[0].split(",");
                                var cjfs = cj[1].split(",");
                                var type = cj[2].split(",");
                                var chengji = document.getElementById("chengji").innerHTML;
								var a1 = 0;
								for (var i=0;i<km.length;i++){
                                    if(type[i] == 1){
										a1++;
                                        if(cjfs[i] == -1){
                                            var fsms = \'考生缺考\';
                                        }else if(cjfs[i] == -2){
                                            var fsms = \'考生违纪，取消本次考试违纪科目的单科考试成绩\';
                                        }else if(cjfs[i] == -3||cjfs[i] == -4||cjfs[i] == -5){
                                            var fsms = \'考生作弊，取消本次考试的全部成绩\';
                                        }else{
                                            var fsms = cjfs[i];
                                        }
                                        document.getElementById("chengji").innerHTML += "<li><div class=\'txt\' style=\'width: 48%;text-align:center;\'>"+km[i]+"</div><div class=\'txt\' style=\'width: 44%;text-align:center;border-left: 1px solid #CCCCCC;\'>"+fsms+"</div></li>"
                                    }
                                }
								if(a1==0){
									document.getElementById("chengji").innerHTML += "<li><div class=\'txt\' style=\'width: 100%;text-align: center;\'>无</div></li>"
								}
                                document.getElementById("chengji").innerHTML += "<li><div class=\'name\' style=\'width: 100%;text-align: center;\'>自学考试实践环节成绩</div></li>";
                                var a2 = 0;
								for (var i=0;i<km.length;i++){
                                    if(type[i] == 2){
										a2++;
                                        if(cjfs[i] == -1){
                                            var fsms = \'考生缺考\';
                                        }else if(cjfs[i] == -2){
                                            var fsms = \'考生违纪，取消本次考试违纪科目的单科考试成绩\';
                                        }else if(cjfs[i] == -3||cjfs[i] == -4||cjfs[i] == -5){
                                            var fsms = \'考生作弊，取消本次考试的全部成绩\';
                                        }else{
                                            var fsms = cjfs[i];
                                        }
                                        document.getElementById("chengji").innerHTML += "<li><div class=\'txt\' style=\'width: 48%;text-align:center;\'>"+km[i]+"</div><div class=\'txt\' style=\'width: 44%;text-align:center;border-left: 1px solid #CCCCCC;\'>"+fsms+"</div></li>"
                                    }
                                }
								if(a2==0){
									document.getElementById("chengji").innerHTML += "<li><div class=\'txt\' style=\'width: 100%;text-align: center;\'>无</div></li>"
								}
                            <?php } ?>';
            }
            if($new['news_type']==11){
                $data .= '
                            <?php if(!empty($cj)){ ?>
                                var cj = <?php echo $cj?>;
                                var cj = cj.split("|");
                                var km = cj[0].split(",");
                                var zyfx = cj[1].split(",");
                                var zmh = cj[2].split(",");
                                var cj = cj[3].split(",");
                                var chengji = document.getElementById("chengji").innerHTML;
                                for (var i=0;i<km.length;i++){
                                    document.getElementById("chengji").innerHTML += "<li><div class=\'txt\' style=\'width: 48%;text-align:center;border-right: 1px solid #CCCCCC;\'>"+km[i]+"->"+zyfx[i]+"->"+zmh[i]+"</div><div class=\'txt\' style=\'width: 44%;text-align:center;\'>"+cj[i]+"</div></li>"
                                }
                            <?php } ?>';
            }
        $data .= '
                        if (window.XMLHttpRequest){
                            // code for Firefox, Opera, IE7, etc.
                            ajax=new XMLHttpRequest();
                        }else if (window.ActiveXObject){
                            // code for IE6, IE5
                            ajax=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        ajax.open("POST", \'http://\'+window.location.host+\'/index/journal/record\', true);
                        // 设置请求头数据传输格式
                        ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                
                        // 把query拼接成urlencoded
                        ajax.send("id="+id+"&system="+system+"&url="+url+"&add="+add+"&xx="+xx);
                        ajax.onreadystatechange = function () {
                            if(ajax.readyState === 4) {
                                if(ajax.status === 200){
                                }
                            }
                        }
                    </script>
                </body>
            </html>';
    return $data;
}
