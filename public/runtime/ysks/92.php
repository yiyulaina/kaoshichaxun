<!DOCTYPE html>
            <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta http-equiv="x-ua-compatible" content="ie=7" />
                    <title></title>
                    <meta content="" name="keywords" />
                    <meta content="" name="description" />
                    <style type="text/css">
                        @charset"utf-8";body,div,html{margin:0;padding:0;border:0}body{font-size:12px;font-family:'微软雅黑', 'Microsoft YaHei', '宋体', 'MicrosoftJhengHei', '华文细黑', 'STHeiti', 'MingLiu'}body ul,li{margin:0;padding:0;list-style:none}button{cursor:pointer;font-size:22px}button,input{outline:none;border:none}a:visited{text-decoration:none}a:active,a:hover{text-decoration:underline;color:#000000}.yq{border:1px solid red}.basc-bg-white{background:#FFFFFF}.basc-bg-blu{background:#0071bf}.basc-black,.basc-black a,.basc-black p{color:#000000}.basc-black3,.basc-black3 a,.basc-black3 p{color:#333333}.basc-black6,.basc-black6 a,.basc-black6 p{color:#666666}.basc-black9,.basc-black9 a,.basc-black9 p{color:#999999}.basc-white,.basc-white a,.basc-white p{color:#FFFFFF}.basc-red,.basc-red a,.basc-red p{color:red}.basc-fs14{font-size:14px}.basc-fs16{font-size:16px}.basc-fs24{font-size:24px}.basc-btn-bak{background:#666666;color:#FFFFFF}.basc-italic{font-style:italic}.basc-bold{font-weight:bold}.basc-txt-center{text-align:center}#alert{display:none}.basc-alert{position:fixed;width:100%;top:0;background:#000000;height:100%;opacity:0.8;filter: alpha(opacity:80);opacity:0.8;-moz-opacity:0.8}.basc-showAlert{width:100%;position:fixed;top:30%}.basc-showAlert .show{width:480px;margin:0 auto;background:#FFFFFF;border-radius:15px;overflow:hidden}.basc-showAlert .show .title,.basc-showAlert .show .txt{margin:0 5px;padding:0 40px}.basc-showAlert .show .title{height:48px;line-height:48px;margin-top:10px;border-bottom:1px solid #CCCCCC}.basc-showAlert .show .txt{line-height:24px;margin-top:20px;margin-bottom:20px}.index_la,.index_lb,.index_lc{overflow:hidden;background:#FFFFFF}.index_la,.index_lb,.main_la{background:rgba(255, 255, 255, 0.5);opacity:0.5;filter: alpha(opacity:50);opacity:0.5;-moz-opacity:0.5}.index_la{height:610px}.index_lb{height:548px}#bodyCon{}.index_lc{}.index_lcForm,.index_lcForm .button{width:522px;margin:0 auto}.index_lcTitle{margin-top:50px;margin-bottom:25px;text-align:center}.index_lcTitle .title,.main_lbTitle .title{font-size:60px;font-family:"黑体"}.index_lcTitle .txt,.main_lbTitle .txt{font-size:24px;font-family:verdana}.index_lcForm .form{width:514px;height:50px;margin-bottom:17px;overflow:hidden;border:2px solid #CCCCCC;border-radius:25px;padding:2px}.index_lcForm .form input{width:100%;height:50px;line-height:50px;padding:0 25px;font-size:18px}.index_lcForm .button{height:60px;border-radius:15px}.index_ld{margin-top:45px}.main_la{height:290px}.main_lc,.main_ld{width:700px;margin:0 auto}.main_lbTitle{margin-bottom:30px;text-align:center}.main_lc{border-radius:15px;overflow:hidden;padding-bottom:25px}.main_lc .title{line-height:34px;margin:20px;overflow:hidden;border-bottom:1px solid #CCCCCC;padding:8px 25px}.main_lc .txtList{margin:0 20px}.main_lc .txtList li{overflow:hidden;margin:0 70px 10px;border:1px solid #CCCCCC}.main_lc .txtList li .name,.main_lc .txtList li .txt{line-height:24px;float:left;padding:8px 10px}.main_lc .txtList li .name{background:#efefef;border-right:1px solid #CCCCCC}.main_lc .txtList li .txt{border-top:1px solid #CCCCCC;margin-top:-1px}.main_ld{line-height:50px;margin-bottom:50px}.yzm{}.yzm .img{max-width:25%;float:left;height:50px;overflow:hidden;border-radius:10px;position:relative;top:-71px;float:right;right:15px}.yzm .img img{height:50px}.yzm .button{margin-top:-20px}.button .btn{font-size:20px;border-radius:25px;padding:0 45px;height:45px;line-height:45px;margin:0 20px;background:#0071bf;color:#FFFFFF;cursor:pointer}
                    </style>
                </head>
            <?php
            function getIP(){
                if (!empty($_SERVER['HTTP_CLIENT_IP'])){
                    //ip是否来自共享互联网
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                    //ip是否来自代理
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }else{
                    //ip是否来自远程地址
                    if ($_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")){
                        $ip = $_SERVER["REMOTE_ADDR"];
                    } else {
                        if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],"unknown")){
                            $ip = $_SERVER['REMOTE_ADDR'];
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
                if(!empty($_SERVER['HTTP_USER_AGENT'])){
                    $OS = $_SERVER['HTTP_USER_AGENT'];
                    $agent = strtolower($OS);
                    $is_iphone = (strpos($agent, 'iphone')) ? true : false;
                    $is_android = (strpos($agent, 'android')) ? true : false;
                    $is_ipad = (strpos($agent, 'ipad')) ? true : false;
                    if($is_iphone){
                        $xtlx = 'iphone';
                    }else if($is_android){
                        $xtlx = 'android';
                    }else if($is_ipad){
                        $xtlx = 'ipad';
                    }else{
                        if (preg_match('/win/i',$OS)) {
                            $xtlx = 'Windows';
                        }
                        elseif (preg_match('/mac/i',$OS)) {
                            $xtlx = 'MAC';
                        }
                        elseif (preg_match('/linux/i',$OS)) {
                            $xtlx = 'Linux';
                        }
                        elseif (preg_match('/unix/i',$OS)) {
                            $xtlx = 'Unix';
                        }
                        elseif (preg_match('/bsd/i',$OS)) {
                            $xtlx = 'BSD';
                        }
                        else {
                            $xtlx = '其他';
                        } 
                    }
                    return $xtlx; 
                }else{
                    return "未知系统";
                }   
            }
            session_start();
            if(isset($_SESSION['authcode']))
            {
                if($_POST["yzm"] == $_SESSION['authcode']){
                    $time = time();
                    if($time < 1574784000 || $time > 1575043200 ){
                        echo "<script>alert('此查询不在查询时间范围内');window.history.go(-1); </script>";die;
                    }
                    session_unset();
                    $ip = json_encode(getIP());
                    $system = json_encode(Get_Os());
                    $redis = new Redis();
                    //连接redis服务器
                    $redis->connect("127.0.0.1", "6379");
                    $redis->auth("123");
                    $redis->select(5);
                    $data_message = "";$kh_data = $_POST['kh'];$data_message .= "考生号:".$kh_data."，";$rk=md5($kh_data);$cx = $redis->get($rk);
                    if($cx){
                        $res=json_decode($cx,true);$ksh = $res["KSH"];$xm = $res["XM"];$sfzh = $res["SFZH"];$jckcj = $res["JCKCJ"];$cj = json_encode($res["cj"]);
                    }else{
                        $host="localhost";
                        $db_user="sunbowen";
                        $db_pass="sunbowen2019";
                        $db_name="query";
                        $b_name="cx_ysks_92";
                        $timezone="Asia/Shanghai";
                        $conn = new mysqli($host, $db_user, $db_pass, $db_name);
                        // Check connection
                        if ($conn->connect_error) {
                            die("连接失败: " . $conn->connect_error);
                        }$stmt = $conn->prepare("SELECT ksh, xm, sfzh,km1,km2,km3,km4,kmm1,kmm2,kmm3,kmm4, km, zyfx, zmh, jckcj, zf,type FROM ".$b_name." where ksh = ? ORDER BY type");$stmt->bind_param("s", $kh_data);$stmt->bind_result($ksh,$xm,$sfzh,$km1,$km2,$km3,$km4,$kmm1,$kmm2,$kmm3,$kmm4,$km,$zyfx,$zmh,$jckcj,$fs,$type);
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
                        if(empty($fs) ){echo "<script>alert('该用户暂无成绩');window.history.go(-1); </script>";die;}
                    }
                }else{
                    session_unset();
                    echo "<script>alert('验证码错误');window.history.go(-1); </script>";
                    die;
                }
            }else{
                echo "<script>alert('验证失败,请重新输入');window.history.go(-1); </script>";
                die;
            }
            ?>
                <body class="basc-bg-blu">
                    <div id="bodyCon"  style="margin-top:150px;">
                        <div class="main_lb">
                            <div class="basc-italic main_lbTitle basc-white">
                                <div class="title  basc-bold">2019年艺术类考试</div>
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
                                    </li>
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
                                <div class="txt" style="width: 44%;text-align:center;"><?php echo $jckcj_all[$k] ?></div>
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
                        ?></ul>
                                <div class="button" style="width:100%;text-align:center;margin-top:15px;">
                                    <button class="btn" onclick="javascript:history.back(-1);">前往打印</button>
                                </div>
                            </div>
                        </div>  <div style="width:660px;background-color: #FFF;margin:20px auto;padding: 20px;border-radius: 25px;">
				<p>1</p><p>2</p><p>3</p>
			</div>
                        <div class="main_ld">
                            <div class="basc-txt-center">
                                <p class="basc-fs14 basc-white">版权所有 辽宁省高中等教育招生考试委员会办公室</p>
                            </div>
                        </div>
                    </div>
                    <script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>
                    <script>
                        var id = 92;
                        var _pf=navigator.platform; 
                        var appVer=navigator.userAgent;
                        var url = <?php echo $ip?>;
                        var system = <?php echo $system?>;
                        if(typeof returnCitySN!=="undefined"){
                            var add = returnCitySN["cname"];
                        }else{
                            var add = "未获取成功";
                        }
                        var xx = '考生号：<?php echo $ksh?>，姓名：<?php echo $xm?>，身份证号：<?php echo $sfzh?>';
                        if (window.XMLHttpRequest){
                            // code for Firefox, Opera, IE7, etc.
                            ajax=new XMLHttpRequest();
                        }else if (window.ActiveXObject){
                            // code for IE6, IE5
                            ajax=new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        ajax.open("POST", 'http://'+window.location.host+'/index/journal/record', true);
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
            </html>