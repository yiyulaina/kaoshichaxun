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
    $data = '<?php
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
    }else if($new['news_type']==5){
        $data .= '
                    $ksh = $res["KSH"];
                    $xm = $res["XM"];
                    $sfzh = $res["SFZH"];
                    $jckcj = $res["JCKCJ"];
                    $cj = explode("|",$res["cj"]);
                    $km1_all = explode(",",$cj[0]);
                    $km2_all = explode(",",$cj[1]);
                    $km3_all = explode(",",$cj[2]);
                    $km4_all = explode(",",$cj[3]);
                    $kmm1_all = explode(",",$cj[4]);
                    $kmm2_all = explode(",",$cj[5]);
                    $kmm3_all = explode(",",$cj[6]);
                    $kmm4_all = explode(",",$cj[7]);
                    $km_all = explode(",",$cj[8]);
                    $zyfx_all = explode(",",$cj[9]);
                    $zmh_all = explode(",",$cj[10]);
                    $fs_all = explode(",",$cj[11]);
                    $type_all = explode(",",$cj[12]);
        ';
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
            }else if($new['news_type']==5){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4, km, zyfx, zmh, jckcj, zf,type FROM ".$b_name." where ksh = ? ORDER BY type");$stmt->bind_param("s", $kh_data);';
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
            }else if($new['news_type']==5){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, km,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4, zyfx, zmh, jckcj, zf,type FROM ".$b_name." where xm = ? ORDER BY type");$stmt->bind_param("s", $name_data);';
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
            }else if($new['news_type']==5){
                $data .= '$stmt = $conn->prepare("SELECT ksh, xm, sfzh, km, zyfx,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4, zmh, jckcj, zf,type FROM ".$b_name." where sfzh = ? ORDER BY type");$stmt->bind_param("s", $shenfenzheng_data);';
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
        }else if($new['news_type']==5){
            $data .=    '$stmt->bind_result($ksh,$xm,$sfzh,$km1,$km2,$km3,$km4,$kmm1,$kmm2,$kmm3,$kmm4,$km,$zyfx,$zmh,$jckcj,$fs,$type);
                        $stmt->execute();
                        while($stmt->fetch()){
                            $km1_all[] = $km1;
                            $km2_all[] = $km2;
                            $km3_all[] = $km3;
                            $km4_all[] = $km4;
                            $kmm1_all[] = $kmm1;
                            $kmm2_all[] = $kmm2;
                            $kmm3_all[] = $kmm3;
                            $kmm4_all[] = $kmm4;
                            $km_all[] = $km;
                            $zyfx_all[] = $zyfx;
                            $zmh_all[] = $zmh;
                            $jckcj_all[] = $jckcj;
                            $fs_all[] = $fs;
                            $type_all[] = $type;
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
            <!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta http-equiv="x-ua-compatible" content="ie=7" />
                    <title></title>
                    <meta content="" name="keywords" />
                    <meta content="" name="description" />
                    <style type="text/css">
                        @charset"utf-8";body,div,html{margin:0;padding:0;border:0}body{font-size:12px;font-family:\'微软雅黑\', \'Microsoft YaHei\', \'宋体\', \'MicrosoftJhengHei\', \'华文细黑\', \'STHeiti\', \'MingLiu\'}body ul,li,p{margin:0;padding:0;list-style:none}button{cursor:pointer;font-size:22px}button,input{outline:none;border:none}a:visited{text-decoration:none}a:active,a:hover{text-decoration:underline;color:#000000}.basc-bg-white{background:#FFFFFF}.basc-bg-blu{background:#0071bf}.basc-black,.basc-black a,.basc-black p{color:#000000}.basc-black3,.basc-black3 a,.basc-black3 p{color:#333333}.basc-black6,.basc-black6 a,.basc-black6 p{color:#666666}.basc-black9,.basc-black9 a,.basc-black9 p{color:#999999}.basc-white,.basc-white a,.basc-white p{color:#FFFFFF}.basc-red,.basc-red a,.basc-red p{color:red}.basc-fs14{font-size:14px}.basc-fs16{font-size:16px}.basc-fs24{font-size:24px}.basc-btn-bak{background:#666666;color:#FFFFFF}.basc-italic{font-style:italic}.basc-bold{font-weight:bold}.basc-txt-center{text-align:center}#alert{display:none}.basc-alert{position:fixed;width:100%;top:0;background:#000000;height:100%;opacity:0.8;filter: alpha(opacity:80);opacity:0.8;-moz-opacity:0.8}.basc-showAlert{width:100%;position:fixed;top:30%}.basc-showAlert .show{width:480px;margin:0 auto;background:#FFFFFF;border-radius:15px;overflow:hidden}.basc-showAlert .show .title,.basc-showAlert .show .txt{margin:0 5px;padding:0 40px}.basc-showAlert .show .title{height:48px;line-height:48px;margin-top:10px;border-bottom:1px solid #CCCCCC}.basc-showAlert .show .txt{line-height:24px;margin-top:20px;margin-bottom:20px}.index_la,.index_lb,.index_lc{overflow:hidden;background:#FFFFFF}.index_la,.index_lb,.main_la{height:290px;margin-top:320px;background:rgba(255, 255, 255, 0.5);opacity:0.5;filter: alpha(opacity:50);opacity:0.5;-moz-opacity:0.5;position:fixed;top:0;width:100%;z-index:0}.index_la{height:610px}.index_lb{height:548px}.main{margin-top:150px}.main_lb{position:relative;z-index:5}.index_lcForm,.index_lcForm .button{width:522px;margin:0 auto}.index_lcTitle{margin-top:50px;margin-bottom:25px;text-align:center}.index_lcTitle .title,.main_lbTitle .title{font-size:60px;font-family:"黑体"}.index_lcTitle .txt,.main_lbTitle .txt{font-size:24px;font-family:verdana}.index_lcForm .form{width:514px;height:50px;margin-bottom:17px;overflow:hidden;border:2px solid #CCCCCC;border-radius:25px;padding:2px}.index_lcForm .form input{width:100%;height:50px;line-height:50px;padding:0 25px;font-size:18px}.index_lcForm .button{height:60px;border-radius:15px}.index_ld{margin-top:45px}.main_la{height:290px}.main_lc,.main_ld{width:950px;margin:0 auto}.main_lbTitle{margin-bottom:30px;text-align:center}.main_lc{border-radius:15px;overflow:hidden;padding-bottom:25px}.main_lc .title{line-height:34px;margin:20px;overflow:hidden;border-bottom:1px solid #CCCCCC;padding:8px 25px}.main_lc .txtList{margin:0 20px}.main_lc .txtList li{overflow:hidden;margin:0 70px 10px;border:1px solid #CCCCCC}.main_lc .txtList li .name,.main_lc .txtList li .txt{line-height:24px;float:left;padding:8px 10px}.main_lc .txtList li .name{background:#efefef;border-right:1px solid #CCCCCC}.main_lc .txtList li .txt{border-top:1px solid #CCCCCC;margin-top:-1px}.main_ld{line-height:50px;margin-bottom:50px}.yzm .img{max-width:25%;float:left;height:50px;overflow:hidden;border-radius:10px;position:relative;top:-71px;float:right;right:15px}.yzm .img img{height:50px}.yzm .button{margin-top:-20px}.button .btn{font-size:20px;border-radius:25px;padding:0 45px;height:45px;line-height:45px;margin:0 20px;background:#0071bf;color:#FFFFFF;cursor:pointer}.main_lh{font-family:"宋体", "黑体", "微软雅黑";border-radius:0;width:610px;margin:20px auto;padding:0 95px;color:#888888;font-size:16px;background:url("../bgtxt.png") #FFFFFF;min-height:1123px;max-height:none}.main_lh .title{font-weight:bold;font-size:24px;line-height:24px;margin-top:40px;margin-bottom:30px;border:none}.main_lh .lna{border-bottom:1px solid #000000;line-height:35px;height:35px}.main_lh .lna div{float:left}.main_lh .lna .div1{width:235px}.main_lh .lna .div2{width:140px}.main_lh .lnb{margin-top:2px;border-top:1px solid #000000;min-height:20px;line-height:20px;padding-top:20px;font-weight:bold;color:#666666}.main_lh .lnc{margin-top:5px}.main_lh .lnc p{color:#444444;line-height:26px}.main_lh .lnc dl{float:left;width:20%;line-height:30px;text-align:center;margin:0}.main_lh .lnc .txtUl{border-top:1px solid #000000;overflow:hidden;padding:0}.main_lh .ewm{position:absolute;bottom:75px;height:80px;width:610px;text-align:center}.main_ewm .name,.main_lh .ewm .name{width:80px;margin:0 auto}.main_ewm{height:80px;text-align:center;margin:30px}.main_ewm .name{width:80px;margin:0 auto}.main_lh .title{text-align:center;color:#000000;font-family: "宋体";font-size:28px;font-weight:bold;}
                    </style>
                    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
                    <script type="text/javascript">
                    (function(r){r.fn.qrcode=function(h){var s;function u(a){this.mode=s;this.data=a}function o(a,c){this.typeNumber=a;this.errorCorrectLevel=c;this.modules=null;this.moduleCount=0;this.dataCache=null;this.dataList=[]}function q(a,c){if(void 0==a.length)throw Error(a.length+"/"+c);for(var d=0;d<a.length&&0==a[d];)d++;this.num=Array(a.length-d+c);for(var b=0;b<a.length-d;b++)this.num[b]=a[b+d]}function p(a,c){this.totalCount=a;this.dataCount=c}function t(){this.buffer=[];this.length=0}u.prototype={getLength:function(){return this.data.length},
                    write:function(a){for(var c=0;c<this.data.length;c++)a.put(this.data.charCodeAt(c),8)}};o.prototype={addData:function(a){this.dataList.push(new u(a));this.dataCache=null},isDark:function(a,c){if(0>a||this.moduleCount<=a||0>c||this.moduleCount<=c)throw Error(a+","+c);return this.modules[a][c]},getModuleCount:function(){return this.moduleCount},make:function(){if(1>this.typeNumber){for(var a=1,a=1;40>a;a++){for(var c=p.getRSBlocks(a,this.errorCorrectLevel),d=new t,b=0,e=0;e<c.length;e++)b+=c[e].dataCount;
                    for(e=0;e<this.dataList.length;e++)c=this.dataList[e],d.put(c.mode,4),d.put(c.getLength(),j.getLengthInBits(c.mode,a)),c.write(d);if(d.getLengthInBits()<=8*b)break}this.typeNumber=a}this.makeImpl(!1,this.getBestMaskPattern())},makeImpl:function(a,c){this.moduleCount=4*this.typeNumber+17;this.modules=Array(this.moduleCount);for(var d=0;d<this.moduleCount;d++){this.modules[d]=Array(this.moduleCount);for(var b=0;b<this.moduleCount;b++)this.modules[d][b]=null}this.setupPositionProbePattern(0,0);this.setupPositionProbePattern(this.moduleCount-
                    7,0);this.setupPositionProbePattern(0,this.moduleCount-7);this.setupPositionAdjustPattern();this.setupTimingPattern();this.setupTypeInfo(a,c);7<=this.typeNumber&&this.setupTypeNumber(a);null==this.dataCache&&(this.dataCache=o.createData(this.typeNumber,this.errorCorrectLevel,this.dataList));this.mapData(this.dataCache,c)},setupPositionProbePattern:function(a,c){for(var d=-1;7>=d;d++)if(!(-1>=a+d||this.moduleCount<=a+d))for(var b=-1;7>=b;b++)-1>=c+b||this.moduleCount<=c+b||(this.modules[a+d][c+b]=
                    0<=d&&6>=d&&(0==b||6==b)||0<=b&&6>=b&&(0==d||6==d)||2<=d&&4>=d&&2<=b&&4>=b?!0:!1)},getBestMaskPattern:function(){for(var a=0,c=0,d=0;8>d;d++){this.makeImpl(!0,d);var b=j.getLostPoint(this);if(0==d||a>b)a=b,c=d}return c},createMovieClip:function(a,c,d){a=a.createEmptyMovieClip(c,d);this.make();for(c=0;c<this.modules.length;c++)for(var d=1*c,b=0;b<this.modules[c].length;b++){var e=1*b;this.modules[c][b]&&(a.beginFill(0,100),a.moveTo(e,d),a.lineTo(e+1,d),a.lineTo(e+1,d+1),a.lineTo(e,d+1),a.endFill())}return a},
                    setupTimingPattern:function(){for(var a=8;a<this.moduleCount-8;a++)null==this.modules[a][6]&&(this.modules[a][6]=0==a%2);for(a=8;a<this.moduleCount-8;a++)null==this.modules[6][a]&&(this.modules[6][a]=0==a%2)},setupPositionAdjustPattern:function(){for(var a=j.getPatternPosition(this.typeNumber),c=0;c<a.length;c++)for(var d=0;d<a.length;d++){var b=a[c],e=a[d];if(null==this.modules[b][e])for(var f=-2;2>=f;f++)for(var i=-2;2>=i;i++)this.modules[b+f][e+i]=-2==f||2==f||-2==i||2==i||0==f&&0==i?!0:!1}},setupTypeNumber:function(a){for(var c=
                    j.getBCHTypeNumber(this.typeNumber),d=0;18>d;d++){var b=!a&&1==(c>>d&1);this.modules[Math.floor(d/3)][d%3+this.moduleCount-8-3]=b}for(d=0;18>d;d++)b=!a&&1==(c>>d&1),this.modules[d%3+this.moduleCount-8-3][Math.floor(d/3)]=b},setupTypeInfo:function(a,c){for(var d=j.getBCHTypeInfo(this.errorCorrectLevel<<3|c),b=0;15>b;b++){var e=!a&&1==(d>>b&1);6>b?this.modules[b][8]=e:8>b?this.modules[b+1][8]=e:this.modules[this.moduleCount-15+b][8]=e}for(b=0;15>b;b++)e=!a&&1==(d>>b&1),8>b?this.modules[8][this.moduleCount-
                    b-1]=e:9>b?this.modules[8][15-b-1+1]=e:this.modules[8][15-b-1]=e;this.modules[this.moduleCount-8][8]=!a},mapData:function(a,c){for(var d=-1,b=this.moduleCount-1,e=7,f=0,i=this.moduleCount-1;0<i;i-=2)for(6==i&&i--;;){for(var g=0;2>g;g++)if(null==this.modules[b][i-g]){var n=!1;f<a.length&&(n=1==(a[f]>>>e&1));j.getMask(c,b,i-g)&&(n=!n);this.modules[b][i-g]=n;e--; -1==e&&(f++,e=7)}b+=d;if(0>b||this.moduleCount<=b){b-=d;d=-d;break}}}};o.PAD0=236;o.PAD1=17;o.createData=function(a,c,d){for(var c=p.getRSBlocks(a,
                    c),b=new t,e=0;e<d.length;e++){var f=d[e];b.put(f.mode,4);b.put(f.getLength(),j.getLengthInBits(f.mode,a));f.write(b)}for(e=a=0;e<c.length;e++)a+=c[e].dataCount;if(b.getLengthInBits()>8*a)throw Error("code length overflow. ("+b.getLengthInBits()+">"+8*a+")");for(b.getLengthInBits()+4<=8*a&&b.put(0,4);0!=b.getLengthInBits()%8;)b.putBit(!1);for(;!(b.getLengthInBits()>=8*a);){b.put(o.PAD0,8);if(b.getLengthInBits()>=8*a)break;b.put(o.PAD1,8)}return o.createBytes(b,c)};o.createBytes=function(a,c){for(var d=
                    0,b=0,e=0,f=Array(c.length),i=Array(c.length),g=0;g<c.length;g++){var n=c[g].dataCount,h=c[g].totalCount-n,b=Math.max(b,n),e=Math.max(e,h);f[g]=Array(n);for(var k=0;k<f[g].length;k++)f[g][k]=255&a.buffer[k+d];d+=n;k=j.getErrorCorrectPolynomial(h);n=(new q(f[g],k.getLength()-1)).mod(k);i[g]=Array(k.getLength()-1);for(k=0;k<i[g].length;k++)h=k+n.getLength()-i[g].length,i[g][k]=0<=h?n.get(h):0}for(k=g=0;k<c.length;k++)g+=c[k].totalCount;d=Array(g);for(k=n=0;k<b;k++)for(g=0;g<c.length;g++)k<f[g].length&&
                    (d[n++]=f[g][k]);for(k=0;k<e;k++)for(g=0;g<c.length;g++)k<i[g].length&&(d[n++]=i[g][k]);return d};s=4;for(var j={PATTERN_POSITION_TABLE:[[],[6,18],[6,22],[6,26],[6,30],[6,34],[6,22,38],[6,24,42],[6,26,46],[6,28,50],[6,30,54],[6,32,58],[6,34,62],[6,26,46,66],[6,26,48,70],[6,26,50,74],[6,30,54,78],[6,30,56,82],[6,30,58,86],[6,34,62,90],[6,28,50,72,94],[6,26,50,74,98],[6,30,54,78,102],[6,28,54,80,106],[6,32,58,84,110],[6,30,58,86,114],[6,34,62,90,118],[6,26,50,74,98,122],[6,30,54,78,102,126],[6,26,52,
                    78,104,130],[6,30,56,82,108,134],[6,34,60,86,112,138],[6,30,58,86,114,142],[6,34,62,90,118,146],[6,30,54,78,102,126,150],[6,24,50,76,102,128,154],[6,28,54,80,106,132,158],[6,32,58,84,110,136,162],[6,26,54,82,110,138,166],[6,30,58,86,114,142,170]],G15:1335,G18:7973,G15_MASK:21522,getBCHTypeInfo:function(a){for(var c=a<<10;0<=j.getBCHDigit(c)-j.getBCHDigit(j.G15);)c^=j.G15<<j.getBCHDigit(c)-j.getBCHDigit(j.G15);return(a<<10|c)^j.G15_MASK},getBCHTypeNumber:function(a){for(var c=a<<12;0<=j.getBCHDigit(c)-
                    j.getBCHDigit(j.G18);)c^=j.G18<<j.getBCHDigit(c)-j.getBCHDigit(j.G18);return a<<12|c},getBCHDigit:function(a){for(var c=0;0!=a;)c++,a>>>=1;return c},getPatternPosition:function(a){return j.PATTERN_POSITION_TABLE[a-1]},getMask:function(a,c,d){switch(a){case 0:return 0==(c+d)%2;case 1:return 0==c%2;case 2:return 0==d%3;case 3:return 0==(c+d)%3;case 4:return 0==(Math.floor(c/2)+Math.floor(d/3))%2;case 5:return 0==c*d%2+c*d%3;case 6:return 0==(c*d%2+c*d%3)%2;case 7:return 0==(c*d%3+(c+d)%2)%2;default:throw Error("bad maskPattern:"+
                    a);}},getErrorCorrectPolynomial:function(a){for(var c=new q([1],0),d=0;d<a;d++)c=c.multiply(new q([1,l.gexp(d)],0));return c},getLengthInBits:function(a,c){if(1<=c&&10>c)switch(a){case 1:return 10;case 2:return 9;case s:return 8;case 8:return 8;default:throw Error("mode:"+a);}else if(27>c)switch(a){case 1:return 12;case 2:return 11;case s:return 16;case 8:return 10;default:throw Error("mode:"+a);}else if(41>c)switch(a){case 1:return 14;case 2:return 13;case s:return 16;case 8:return 12;default:throw Error("mode:"+
                    a);}else throw Error("type:"+c);},getLostPoint:function(a){for(var c=a.getModuleCount(),d=0,b=0;b<c;b++)for(var e=0;e<c;e++){for(var f=0,i=a.isDark(b,e),g=-1;1>=g;g++)if(!(0>b+g||c<=b+g))for(var h=-1;1>=h;h++)0>e+h||c<=e+h||0==g&&0==h||i==a.isDark(b+g,e+h)&&f++;5<f&&(d+=3+f-5)}for(b=0;b<c-1;b++)for(e=0;e<c-1;e++)if(f=0,a.isDark(b,e)&&f++,a.isDark(b+1,e)&&f++,a.isDark(b,e+1)&&f++,a.isDark(b+1,e+1)&&f++,0==f||4==f)d+=3;for(b=0;b<c;b++)for(e=0;e<c-6;e++)a.isDark(b,e)&&!a.isDark(b,e+1)&&a.isDark(b,e+
                    2)&&a.isDark(b,e+3)&&a.isDark(b,e+4)&&!a.isDark(b,e+5)&&a.isDark(b,e+6)&&(d+=40);for(e=0;e<c;e++)for(b=0;b<c-6;b++)a.isDark(b,e)&&!a.isDark(b+1,e)&&a.isDark(b+2,e)&&a.isDark(b+3,e)&&a.isDark(b+4,e)&&!a.isDark(b+5,e)&&a.isDark(b+6,e)&&(d+=40);for(e=f=0;e<c;e++)for(b=0;b<c;b++)a.isDark(b,e)&&f++;a=Math.abs(100*f/c/c-50)/5;return d+10*a}},l={glog:function(a){if(1>a)throw Error("glog("+a+")");return l.LOG_TABLE[a]},gexp:function(a){for(;0>a;)a+=255;for(;256<=a;)a-=255;return l.EXP_TABLE[a]},EXP_TABLE:Array(256),
                    LOG_TABLE:Array(256)},m=0;8>m;m++)l.EXP_TABLE[m]=1<<m;for(m=8;256>m;m++)l.EXP_TABLE[m]=l.EXP_TABLE[m-4]^l.EXP_TABLE[m-5]^l.EXP_TABLE[m-6]^l.EXP_TABLE[m-8];for(m=0;255>m;m++)l.LOG_TABLE[l.EXP_TABLE[m]]=m;q.prototype={get:function(a){return this.num[a]},getLength:function(){return this.num.length},multiply:function(a){for(var c=Array(this.getLength()+a.getLength()-1),d=0;d<this.getLength();d++)for(var b=0;b<a.getLength();b++)c[d+b]^=l.gexp(l.glog(this.get(d))+l.glog(a.get(b)));return new q(c,0)},mod:function(a){if(0>
                    this.getLength()-a.getLength())return this;for(var c=l.glog(this.get(0))-l.glog(a.get(0)),d=Array(this.getLength()),b=0;b<this.getLength();b++)d[b]=this.get(b);for(b=0;b<a.getLength();b++)d[b]^=l.gexp(l.glog(a.get(b))+c);return(new q(d,0)).mod(a)}};p.RS_BLOCK_TABLE=[[1,26,19],[1,26,16],[1,26,13],[1,26,9],[1,44,34],[1,44,28],[1,44,22],[1,44,16],[1,70,55],[1,70,44],[2,35,17],[2,35,13],[1,100,80],[2,50,32],[2,50,24],[4,25,9],[1,134,108],[2,67,43],[2,33,15,2,34,16],[2,33,11,2,34,12],[2,86,68],[4,43,27],
                    [4,43,19],[4,43,15],[2,98,78],[4,49,31],[2,32,14,4,33,15],[4,39,13,1,40,14],[2,121,97],[2,60,38,2,61,39],[4,40,18,2,41,19],[4,40,14,2,41,15],[2,146,116],[3,58,36,2,59,37],[4,36,16,4,37,17],[4,36,12,4,37,13],[2,86,68,2,87,69],[4,69,43,1,70,44],[6,43,19,2,44,20],[6,43,15,2,44,16],[4,101,81],[1,80,50,4,81,51],[4,50,22,4,51,23],[3,36,12,8,37,13],[2,116,92,2,117,93],[6,58,36,2,59,37],[4,46,20,6,47,21],[7,42,14,4,43,15],[4,133,107],[8,59,37,1,60,38],[8,44,20,4,45,21],[12,33,11,4,34,12],[3,145,115,1,146,
                    116],[4,64,40,5,65,41],[11,36,16,5,37,17],[11,36,12,5,37,13],[5,109,87,1,110,88],[5,65,41,5,66,42],[5,54,24,7,55,25],[11,36,12],[5,122,98,1,123,99],[7,73,45,3,74,46],[15,43,19,2,44,20],[3,45,15,13,46,16],[1,135,107,5,136,108],[10,74,46,1,75,47],[1,50,22,15,51,23],[2,42,14,17,43,15],[5,150,120,1,151,121],[9,69,43,4,70,44],[17,50,22,1,51,23],[2,42,14,19,43,15],[3,141,113,4,142,114],[3,70,44,11,71,45],[17,47,21,4,48,22],[9,39,13,16,40,14],[3,135,107,5,136,108],[3,67,41,13,68,42],[15,54,24,5,55,25],[15,
                    43,15,10,44,16],[4,144,116,4,145,117],[17,68,42],[17,50,22,6,51,23],[19,46,16,6,47,17],[2,139,111,7,140,112],[17,74,46],[7,54,24,16,55,25],[34,37,13],[4,151,121,5,152,122],[4,75,47,14,76,48],[11,54,24,14,55,25],[16,45,15,14,46,16],[6,147,117,4,148,118],[6,73,45,14,74,46],[11,54,24,16,55,25],[30,46,16,2,47,17],[8,132,106,4,133,107],[8,75,47,13,76,48],[7,54,24,22,55,25],[22,45,15,13,46,16],[10,142,114,2,143,115],[19,74,46,4,75,47],[28,50,22,6,51,23],[33,46,16,4,47,17],[8,152,122,4,153,123],[22,73,45,
                    3,74,46],[8,53,23,26,54,24],[12,45,15,28,46,16],[3,147,117,10,148,118],[3,73,45,23,74,46],[4,54,24,31,55,25],[11,45,15,31,46,16],[7,146,116,7,147,117],[21,73,45,7,74,46],[1,53,23,37,54,24],[19,45,15,26,46,16],[5,145,115,10,146,116],[19,75,47,10,76,48],[15,54,24,25,55,25],[23,45,15,25,46,16],[13,145,115,3,146,116],[2,74,46,29,75,47],[42,54,24,1,55,25],[23,45,15,28,46,16],[17,145,115],[10,74,46,23,75,47],[10,54,24,35,55,25],[19,45,15,35,46,16],[17,145,115,1,146,116],[14,74,46,21,75,47],[29,54,24,19,
                    55,25],[11,45,15,46,46,16],[13,145,115,6,146,116],[14,74,46,23,75,47],[44,54,24,7,55,25],[59,46,16,1,47,17],[12,151,121,7,152,122],[12,75,47,26,76,48],[39,54,24,14,55,25],[22,45,15,41,46,16],[6,151,121,14,152,122],[6,75,47,34,76,48],[46,54,24,10,55,25],[2,45,15,64,46,16],[17,152,122,4,153,123],[29,74,46,14,75,47],[49,54,24,10,55,25],[24,45,15,46,46,16],[4,152,122,18,153,123],[13,74,46,32,75,47],[48,54,24,14,55,25],[42,45,15,32,46,16],[20,147,117,4,148,118],[40,75,47,7,76,48],[43,54,24,22,55,25],[10,
                    45,15,67,46,16],[19,148,118,6,149,119],[18,75,47,31,76,48],[34,54,24,34,55,25],[20,45,15,61,46,16]];p.getRSBlocks=function(a,c){var d=p.getRsBlockTable(a,c);if(void 0==d)throw Error("bad rs block @ typeNumber:"+a+"/errorCorrectLevel:"+c);for(var b=d.length/3,e=[],f=0;f<b;f++)for(var h=d[3*f+0],g=d[3*f+1],j=d[3*f+2],l=0;l<h;l++)e.push(new p(g,j));return e};p.getRsBlockTable=function(a,c){switch(c){case 1:return p.RS_BLOCK_TABLE[4*(a-1)+0];case 0:return p.RS_BLOCK_TABLE[4*(a-1)+1];case 3:return p.RS_BLOCK_TABLE[4*
                    (a-1)+2];case 2:return p.RS_BLOCK_TABLE[4*(a-1)+3]}};t.prototype={get:function(a){return 1==(this.buffer[Math.floor(a/8)]>>>7-a%8&1)},put:function(a,c){for(var d=0;d<c;d++)this.putBit(1==(a>>>c-d-1&1))},getLengthInBits:function(){return this.length},putBit:function(a){var c=Math.floor(this.length/8);this.buffer.length<=c&&this.buffer.push(0);a&&(this.buffer[c]|=128>>>this.length%8);this.length++}};"string"===typeof h&&(h={text:h});h=r.extend({},{render:"canvas",width:256,height:256,typeNumber:-1,
                    correctLevel:2,background:"#ffffff",foreground:"#000000"},h);return this.each(function(){var a;if("canvas"==h.render){a=new o(h.typeNumber,h.correctLevel);a.addData(h.text);a.make();var c=document.createElement("canvas");c.width=h.width;c.height=h.height;for(var d=c.getContext("2d"),b=h.width/a.getModuleCount(),e=h.height/a.getModuleCount(),f=0;f<a.getModuleCount();f++)for(var i=0;i<a.getModuleCount();i++){d.fillStyle=a.isDark(f,i)?h.foreground:h.background;var g=Math.ceil((i+1)*b)-Math.floor(i*b),
                    j=Math.ceil((f+1)*b)-Math.floor(f*b);d.fillRect(Math.round(i*b),Math.round(f*e),g,j)}}else{a=new o(h.typeNumber,h.correctLevel);a.addData(h.text);a.make();c=r("<table></table>").css("width",h.width+"px").css("height",h.height+"px").css("border","0px").css("border-collapse","collapse").css("background-color",h.background);d=h.width/a.getModuleCount();b=h.height/a.getModuleCount();for(e=0;e<a.getModuleCount();e++){f=r("<tr></tr>").css("height",b+"px").appendTo(c);for(i=0;i<a.getModuleCount();i++)r("<td></td>").css("width",
                    d+"px").css("background-color",a.isDark(e,i)?h.foreground:h.background).appendTo(f)}}a=c;jQuery(a).appendTo(this)})}})(jQuery);
                    </script>
                </head>
                <body class="basc-bg-blu">
                    <div id="bodyCon"  style="margin-top:150px;">
                        <div class="main_lb">
                            <div class="basc-italic main_lbTitle basc-white">
                                <div class="title  basc-bold">'.$new['news_title'].'</div>
                                <div class="txt">Examination Information Query System</div>
                            </div>
                            <div class="main_lc basc-bg-white" id="ShowCj">
                                <div class="title basc-black3 basc-bold basc-fs24"></div>';
        if($new['news_type']==5){
            $data .= '
                                <div class="button" style="width:100%;text-align:center;margin-top:20px;margin-bottom:20px;">
                                    <button class="btn" onclick="ShowDy()">打印DBF</button>
                                </div>';
        }
            $data .=    '
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
                        $data .=    '';
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
        }else if($new['news_type']==5){
            $data .=    '
                        <?php 
                            if(!empty($type_all)){
                                $ysks_type_1 = 0;
                                $ysks_type_2 = 0;
                                $ysks_type_3 = 0;
                                foreach($type_all as $k => $v ){ 
                                    if($v == 1){
                                        if($ysks_type_1 == 0){
                                            $ysks_type_1 = 1;
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">音乐舞蹈专业考试成绩</div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">基础课成绩</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php if(!empty($jckcj)){echo $jckcj;}else{echo $jckcj_all[$k];} ?></div>
                            </li>
                        <?php
                                        }
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;"></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">科目</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km_all[$k] ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">专业方向</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $zyfx_all[$k] ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">专门化</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $zmh_all[$k] ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">分数</div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs_all[$k] ?></div>
                            </li>
                        <?php
                                    }else if($v == 2){
                                        if($ysks_type_2 == 0){
                                            $ysks_type_2 = 1;
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">美术专业考试成绩</div>
                            </li>
                        <?php  
                                        }
                        ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm1_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km1_all[$k] ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm2_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km2_all[$k] ?></div>
                            </li>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm3_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km3_all[$k] ?></div>
                            </li>
                        <?php 
                                    }else{
                                        if($ysks_type_3 == 0){
                                            $ysks_type_3 = 1;
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">戏剧与影视类专业考试成绩</div>
                            </li>
                        <?php  
                                        }
                                        if($v == 3){
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">表演成绩</div>
                            </li>
                        <?php 
                                        }else if($v == 4){
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">戏剧影视导演成绩</div>
                            </li>
                        <?php 

                                        }else if($v == 5){
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">播音与主持艺术成绩</div>
                            </li>
                        <?php 
                    
                                        }else if($v == 6){
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">戏剧影视文学成绩</div>
                            </li>
                        <?php 
                    
                                        }else if($v == 7){
                        ?>
                            <li>
                                <div class="name" style="width: 100%;text-align: center;">广播电视编导成绩</div>
                            </li>
                        <?php 
                    
                                        }
                        ?>
                        <?php if(!empty($kmm1_all[$k])){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm1_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km1_all[$k] ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm2_all[$k])){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm2_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km2_all[$k] ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm3_all[$k])){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm3_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km3_all[$k] ?></div>
                            </li>
                        <?php } ?>
                        <?php if(!empty($kmm4_all[$k])){ ?>
                            <li>
                                <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;"><?php echo $kmm4_all[$k] ?></div>
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $km4_all[$k] ?></div>
                            </li>
                        <?php } ?>
                        <li>
                            <div class="txt" style="width: 48%;text-align:center;border-right: 1px solid #CCCCCC;">总分</div>
                            <div class="txt" style="width: 44%;text-align:center;"><?php echo $fs_all[$k] ?></div>
                        </li>
                        <?php 
                                    }
                                }
                            } 
                        ?>';
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
                    $data .=   '</ul>';
        if($new['news_type']==5){
            $data .=    '
                                <div class="main_ewm">
                                    <div id="code" class="name"></div>
                                </div>';
        }
        $data .=    '       </div>
                        </div>  ';
if(!empty($new['news_body'])){
    $data .= '<div style="width:660px;background-color: #FFF;margin:20px auto;padding: 20px;border-radius: 25px;">
				'.$new['news_body'].'
			</div>';
}
        if($new['news_type']==5){
            $data .= '
                        <div class="main_lb" style="display: none;" id="ShowDy">
                            <div class="main_lc basc-bg-white">
                            <!--startprint-->
                                <div class="main_lh" id="export_content">
                                    <div style="width: 100%;height: 1px;"></div>
                                    <div class="title">'.$new['news_title'].'</div>
                                    <div class="lna">
                                        <div class="div1">考 生 号：<?php echo $ksh?> </div>
                                        <div class="div2">姓名：<?php echo $xm?> </div>
                                        <div class="div1">身份证号：<?php echo $sfzh?></div>
                                    </div>
                                    <?php 
                                        if(!empty($type_all)){
                                            $ysks_type_1 = 0;
                                            $ysks_type_2 = 0;
                                            $ysks_type_3 = 0;
                                            foreach($type_all as $k => $v ){ 
                                                if($v == 1){
                                                    if($ysks_type_1 == 0){
                                                        $ysks_type_1 = 1;
                                    ?>
                                        <div class="lnb">音乐舞蹈专业考试成绩</div>
                                        <div class="lnc">
                                            <p>基础课成绩</p>
                                            <div class="txtUl">
                                                <dl>分数</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($jckcj)){echo $jckcj;}else{echo $jckcj_all[$k];} ?></dl>
                                            </div>
                                        </div>
                                    <?php
                                                    }
                                    ?>
                                        <div class="lnc">
                                            <p>艺术课成绩</p>
                                            <div class="txtUl">
                                                <dl>科目</dl>
                                                <dl>专业方向</dl>
                                                <dl>专门化</dl>
                                                <dl>分数</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php echo $km_all[$k] ?></dl>
                                                <dl><?php echo $zyfx_all[$k] ?></dl>
                                                <dl><?php echo $zmh_all[$k] ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php
                                                }else if($v == 2){
                                                    if($ysks_type_2 == 0){
                                                        $ysks_type_2 = 1;
                                    ?>
                                        <div class="lnb">美术专业考试成绩</div>
                                    <?php  
                                                    }
                                    ?>
                                        <div class="lnc">
                                            <div class="txtUl">
                                                <dl><?php echo $kmm1_all[$k] ?></dl>
                                                <dl><?php echo $kmm2_all[$k] ?></dl>
                                                <dl><?php echo $kmm3_all[$k] ?></dl>
                                                <dl>总分</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php echo $km1_all[$k] ?></dl>
                                                <dl><?php echo $km2_all[$k] ?></dl>
                                                <dl><?php echo $km3_all[$k] ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php 
                                                }else{
                                                    if($ysks_type_3 == 0){
                                                        $ysks_type_3 = 1;
                                    ?>
                                        <div class="lnb">戏剧与影视类专业考试成绩</div>
                                    <?php  
                                                    }
                                                    if($v == 3){
                                    ?>
                                        <div class="lnc">
                                            <p>表演成绩</p>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $kmm1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $kmm2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $kmm3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $kmm4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl>总分</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $km1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $km2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $km3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $km4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php 
                                                    }else if($v == 4){
                                    ?>
                                        <div class="lnc">
                                            <p>戏剧影视导演成绩</p>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $kmm1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $kmm2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $kmm3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $kmm4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl>总分</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $km1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $km2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $km3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $km4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php 
            
                                                    }else if($v == 5){
                                    ?>
                                        <div class="lnc">
                                            <p>播音与主持艺术成绩</p>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $kmm1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $kmm2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $kmm3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $kmm4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl>总分</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $km1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $km2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $km3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $km4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php 
                                
                                                    }else if($v == 6){
                                    ?>
                                        <div class="lnc">
                                            <p>戏剧影视文学成绩</p>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $kmm1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $kmm2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $kmm3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $kmm4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl>总分</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $km1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $km2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $km3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $km4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php 
                                
                                                    }else if($v == 7){
                                    ?>
                                        <div class="lnc">
                                            <p>广播电视编导成绩</p>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $kmm1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $kmm2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $kmm3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $kmm4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl>总分</dl>
                                            </div>
                                            <div class="txtUl">
                                                <dl><?php if(!empty($kmm1_all[$k])){echo $km1_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm2_all[$k])){echo $km2_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm3_all[$k])){echo $km3_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php if(!empty($kmm4_all[$k])){echo $km4_all[$k];}else{echo "&nbsp;";} ?></dl>
                                                <dl><?php echo $fs_all[$k] ?></dl>
                                            </div>
                                        </div>
                                    <?php 
                                
                                                    }
                                                }
                                            }
                                        } 
                                    ?>
                                    <div class="ewm">
                                    <div id="code_two" class="name"></div>
                                    </div>
                                </div>
                            <!--endprint-->
                            </div>
                        </div>';
        }
            $data .= '
                        <div class="main_ld">
                            <div class="basc-txt-center">
                                <p class="basc-fs14 basc-white">版权所有 辽宁省高中等教育招生考试委员会办公室</p>
                            </div>
                        </div>
                    </div>';
                    
        if($new['news_type']==5){
            $data .= '
                    <script>
                        var DEFAULT_VERSION = 8.0;  
                        var ua = navigator.userAgent.toLowerCase();  
                        var isIE = ua.indexOf("msie")>-1;  
                        var safariVersion;
                        if(isIE){  
                            safariVersion =  ua.match(/msie ([\d.]+)/)[1];  
                            if(safariVersion <= DEFAULT_VERSION ){  
                              alert(\'系统检测到您正在使用ie8或以下内核的浏览器，不能实现完美体验，请更换或升级浏览器访问！\')
                            }; 
                        }  
                    </script><script type="text/javascript">
                    $(function(){
                        var ksh = <?php echo json_encode($ksh)?>;
                        var xm = <?php echo json_encode($xm)?>;
                        var sfzh = <?php echo json_encode($sfzh)?>;
                        var str = toUtf8(\'考生号：\'+ksh+\'\n姓名：\'+xm+\'\n身份证号：\'+sfzh+\'\');
                        $("#code").qrcode({
                            render: "table",
                            width: 80,
                            height:80,
                            text: str
                        });
                        $("#code_two").qrcode({
                            render: "table",
                            width: 80,
                            height:80,
                            text: str
                        });
                    })
                    function toUtf8(str) {   
                        var out, i, len, c;   
                        out = "";   
                        len = str.length;   
                        for(i = 0; i < len; i++) {   
                            c = str.charCodeAt(i);   
                            if ((c >= 0x0001) && (c <= 0x007F)) {   
                                out += str.charAt(i);   
                            } else if (c > 0x07FF) {   
                                out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));   
                                out += String.fromCharCode(0x80 | ((c >>  6) & 0x3F));   
                                out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
                            } else {   
                                out += String.fromCharCode(0xC0 | ((c >>  6) & 0x1F));   
                                out += String.fromCharCode(0x80 | ((c >>  0) & 0x3F));   
                            }   
                        }   
                        return out;   
                    }  
                    </script>
                    <script src="../html2canvas.js"></script>
                    <script src="../jspdf.debug.js"></script>
                    <script>
                        function ShowDy(){
                            if(isIE){  
                                safariVersion =  ua.match(/msie ([\d.]+)/)[1];  
                                if(safariVersion <= DEFAULT_VERSION ){  
                                    alert(\'系统检测到您正在使用ie8或以下内核的浏览器，不能实现完美体验，请更换或升级浏览器访问！\')
                                    return;
                                }; 
                            }  
                            document.getElementById(\'ShowCj\').style.display ="none";
                            document.getElementById(\'ShowDy\').style.display ="block";
                            html2canvas(
                                    document.getElementById("export_content"),
                                    {
                                        dpi: 272,//导出pdf清晰度
                                        onrendered: function (canvas) {
                                            var contentWidth = canvas.width;
                                            var contentHeight = canvas.height;
                    
                                            //一页pdf显示html页面生成的canvas高度;
                                            var pageHeight = contentWidth / 592.28 * 841.89;
                                            //未生成pdf的html页面高度
                                            var leftHeight = contentHeight;
                                            //pdf页面偏移
                                            var position = 0;
                                            //html页面生成的canvas在pdf中图片的宽高（a4纸的尺寸[595.28,841.89]）
                                            var imgWidth = 595.28;
                                            var imgHeight = 592.28 / contentWidth * contentHeight;
                    
                                            var pageData = canvas.toDataURL(\'image/jpeg\', 1.0);
                                            var pdf = new jsPDF(\'\', \'pt\', \'a4\');
                    
                                            //有两个高度需要区分，一个是html页面的实际高度，和生成pdf的页面高度(841.89)
                                            //当内容未超过pdf一页显示的范围，无需分页
                                            if (leftHeight < pageHeight) {
                                                pdf.addImage(pageData, \'JPEG\', 0, 0, imgWidth, imgHeight);
                                            } else {
                                                while (leftHeight > 0) {
                                                    pdf.addImage(pageData, \'JPEG\', 0, position, imgWidth, imgHeight)
                                                    leftHeight -= pageHeight;
                                                    position -= 841.89;
                                                    //避免添加空白页
                                                    if (leftHeight > 0) {
                                                        pdf.addPage();
                                                    }
                                                }
                                            }
                                            pdf.save(\'content.pdf\');
                                        },
                                        //背景设为白色（默认为黑色）
                                        background: "#fff"  
                                    })
                            document.getElementById(\'ShowCj\').style.display ="block";
                            document.getElementById(\'ShowDy\').style.display ="none";
                        }
                    </script>';
        }
            $data .= '
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
