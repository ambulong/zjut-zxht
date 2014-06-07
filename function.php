<?php
/**
* 包含HTML头
*/
function func_header($title){
	require(ROOT_PATH.'/theme/header.php');
}
/**
* 包含HTML尾
*/
function func_footer(){
	require(ROOT_PATH.'/theme/footer.php');
}
/**
* 包含HTML导航条
*/
function func_nav($active = 0){
	require(ROOT_PATH.'/theme/nav.php');
}
//URL $m = show|do $d = name
function func_url($m = "show", $d = "index"){
	return URL_ROOT."/index.php?action={$m}&m={$d}";
}
/**
* 检查登录
*/
function func_is_login(){
	if(isset($_SESSION['isLogin'])){
		if($_SESSION['isLogin'] == 1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
/**
* 需要登录
*/
function func_need_login(){
	if(!func_is_login()){
		header("location:".func_url("show","login"));
		exit;
	}
}
/**
* 需要管理权限
*/
function func_need_admin(){
	if($_SESSION['user']['role'] != 1){
		header("location:".func_url("show","index"));
		exit;
	}
}
/**
* 跳转到首页
*/
function func_gohome(){
	header("location:".func_url("show","index"));
	exit;
}
/**
* 项目操作URL生成
*/
function func_proj_url($action, $id){
	switch($action){
	case "del":		/**< 删除操作 */
		echo func_url("do","proj_del")."&id={$id}";
		break;
	case "stop":	/**< 停止操作 */
		echo func_url("do","proj_stop")."&id={$id}";
		break;
	case "start":	/**< 启用操作 */
		echo func_url("do","proj_start")."&id={$id}";
		break;
	case "export":	/**< 导出操作 */
		echo func_url("show","proj_export")."&id={$id}";
		break;
	case "set":		/**< 设置操作 */
		echo func_url("show","proj_set")."&id={$id}";
		break;
	case "profile":	/**< 配置操作 */
		echo func_url("show","proj_profile")."&id={$id}";
		break;
	case "auth":	/**< 权限分配 */
		echo func_url("show","proj_auth")."&id={$id}";
		break;
	case "view":	/**< 查看内容 */
		echo func_url("show","proj_item")."&id={$id}";
		break;
	default:		/**< 默认 */
		echo "";
		break;
	}
}
/**
* 生成token
*/
function func_token(){
	$token = md5(str_shuffle($_SERVER['REMOTE_ADDR'].rand().time()));
	return $token;
}
/**
* 设置token
*/
function func_set_token(){
	$_SESSION['token'] = func_token();
}
/**
* 检查token
*/
function func_verify_token($token){
	if($token == $_SESSION['token'])
		return 1;
	else
		return 0;
}
/**
* 退出登录
*/
function func_logout(){
	session_unset();
}
/**
* 提示信息
*/
function func_msg($msg){
	$_SESSION['msg'] = $msg;
	header("location: ".URL_ROOT."/index.php?action=show&m=msg");
}
/**
* 获取IP
*/
function func_IP(){
	return $_SERVER['REMOTE_ADDR'];
}
/**
* 获取时间
*/
function func_TIME(){
	return date('Y-m-d H:i:s');
}
/**
* 获取日期
*/
function func_DATE(){
	return date('Y-m-d');
}
/**
* 是否符合json格式
*/
function is_json($string) {
	json_decode($string, true);
	return (json_last_error() == JSON_ERROR_NONE);
}
/**
* HTML编码
*/
function func_htmlhtmlspecialchars($string){
	if(is_array($string)) { 
		foreach($string as $key => $val) { 
			$string[$key] = func_htmlhtmlspecialchars($val); 
		} 
	} else { 
		$string = htmlspecialchars($string); 
	} 
	return $string;
}
/**
* 防SQL注入(字符串)
*/
function func_addaddslashes($string, $force = 0){	//Add slashes
	if(!get_magic_quotes_gpc() || $force) { 
		if(is_array($string)) { 
			foreach($string as $key => $val) { 
				$string[$key] = func_addaddslashes($val, $force); 
			} 
		} else { 
			$string = addslashes($string); 
		} 
	} 

	return $string; 
}
/**
* 防SQL注入(整数)
*/
function func_intintval($int){ //Int value
	if(is_array($int)) {
			foreach($int as $key => $val) {
				$int[$key] = func_intintval($val);
			} 
		} else { 
			$int = intval($int); 
		}

	return $int;
}
/**
* 发送邮件
*/
function func_mail($mailto,$title,$body,$altbody = ''){
	require(ROOT_PATH.'/PHPMailer/PHPMailerAutoload.php');
	
	$mail = new PHPMailer;

	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp.exmail.qq.com;hwsmtp.exmail.qq.com';  // Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'auto@wooi.me';                            // SMTP username
	$mail->Password = '';                           // SMTP password
	$mail->CharSet ="UTF-8";

	$mail->From = 'auto@wooi.me';
	$mail->FromName = 'Wooi.me';
	$mail->addAddress($mailto);               // Name is optional
	$mail->addReplyTo('auto@wooi.me', 'Wooi.me');

	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = $title;
	$mail->Body    = $body;
	$mail->AltBody = $altbody;

	if(!$mail->send()) {
	   echo '<br>Message could not be sent.';
	   echo '<br>Mailer Error: ' . $mail->ErrorInfo;
	   return 0;
	}else{
		return 1;
	}
}
