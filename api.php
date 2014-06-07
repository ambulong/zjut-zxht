<?php

//某些函数直接带参数进去是否会导致安全问题?

function json_out($status = 0, $msg = "", $data = ""){
	$json	= array(
		"status"	=> $status,	/**< 0.出现错误 1.正常 */
		"msg"		=> $msg,	/**< 提示信息 */
		"data"		=> $data	/**< 参数信息 */
	);
	echo json_encode($json);
	if($GLOBALS['open301'] == 1){
		if($json['status'] == 0){
			if(trim($GLOBALS['errurl']) != ""){
				header('location:'.$GLOBALS['errurl']);	/**< 请注意php版本, 低版本可能出现HTTP头注入漏洞 */
			}else{
				echo "提交出错";
			}
		}else{
			if(trim($GLOBALS['reurl']) != ""){
				header('location:'.$GLOBALS['reurl']);	/**< 请注意php版本, 低版本可能出现HTTP头注入漏洞 */
			}else{
				echo "保存成功";
			}
		}
	}
	exit;
}

header('Content-type: application/json');
include("./init.php");

$open301 = isset($_REQUEST['open301'])?1:0;	/**< 0.不开启跳转 1.开启跳转 */

$pid	= isset($_REQUEST['id'])?intval($_REQUEST['id']):null;

/**
* 项目id是否为空
*/
if($pid == null){
	json_out(0, "项目id为空");
}

$proj = new Proj("", "", "", "");

/**
* 项目是否存在
*/
if(!$proj->isExist($pid)){
	json_out(0, "项目id无效");
}

$reurl = $proj->getReurl($pid);
$errurl = $proj->getErrurl($pid);

/**
* 项目是否已停止
*/
if($proj->getStatus($pid) == 0){
	json_out(0, "项目已停止");
}

$setting	= $proj->getSetting($pid);
$params		= $proj->getParams($pid);
$continue	= 0;

/**
* 项目是否需要验证码, 并校验验证码
* (如果密钥为错误也会导致验证码错误)
*/
if($setting['recaptcha_status'] == 1){
	if(isset($_REQUEST["recaptcha_response_field"])){
		$resp = recaptcha_check_answer($setting['recaptcha_privkey'],
																$_SERVER["REMOTE_ADDR"],
																$_POST["recaptcha_challenge_field"],
																$_POST["recaptcha_response_field"]);
		if ($resp->is_valid){
			$continue = 1;
		}else{
			json_out(0, "验证码错误");
		}
	}else{
		json_out(0, "未输入验证码");
	}
}else{
	$continue = 1;
}
if($continue != 1){
	json_out(0, "验证码错误");
}


/**
* 记录参数信息
*/
$params_data = array();
if(is_array($params) && count($params) > 0){
	foreach($params as $param){	/**< 遍厉记录并校验所有需要参数 */
		if(strcasecmp($param['method'],"request") == 0){
			$value = isset($_REQUEST[$param['name']])?$_REQUEST[$param['name']]:"";
		}else if(strcasecmp($param['method'],"post") == 0){
			$value = isset($_POST[$param['name']])?$_POST[$param['name']]:"";
		}else if(strcasecmp($param['method'],"get") == 0){
			$value = isset($_GET[$param['name']])?$_GET[$param['name']]:"";
		}else{
			$value = "";
		}
		if(strcasecmp($param['allow_null'],"n") == 0){	/**< 参数不准为空时执行 */
			if(!isset($value) || trim($value) == ""){
				json_out(0, htmlspecialchars($param['label'])."不准为空");
			}
		}
		if(trim($param['regex']) != ""){	/**< 参数正则表达式校验格式 */
			if(!preg_match('/'.$param['regex'].'/', $value)){
				json_out(0, htmlspecialchars($param['label'])."出错");
			}
		}
		$params_data[]	= array(
			"name"	=> $param['name'],
			"value"	=> $value
		);
		//echo $param['name'].":".$value."<br>";
	}
}
$ei	=	array(	/**< 数据提交者的信息 */
	"ip"	=> $_SERVER["REMOTE_ADDR"],
	"time"	=> func_TIME(),
	"HTTP_ACCEPT"	=>	@$_SERVER["HTTP_ACCEPT"],
	"HTTP_HOST"		=>	@$_SERVER["HTTP_HOST"],
	"HTTP_REFERER"	=>	@$_SERVER["HTTP_REFERER"],
	"HTTP_USER_AGENT"	=>	@$_SERVER["HTTP_USER_AGENT"]
);
$params_data[]	= array(
	"name"	=> "ei",
	"value"	=> json_encode($ei)
);

/**
* 添加记录
*/
$item = new Item($pid, $params_data);
if($item->add()){
		json_out(1, "操作成功", $params_data);
}else{
		json_out(0, "操作失败", $params_data);
}

/**
* 邮件通知
*/
if($setting['mail_status'] == 1 && trim($setting['mails']) != ""){
	$mails	= split(';', $setting['mails']);
	$title	= "项目 ".$proj->getName($pid)." 收到新信息";
	$body	= "{$title}<br>到管理平台查看:<a href=\"".URL_ROOT."\">".URL_ROOT."</a>";
	foreach($mails as $mail){
		func_mail($mail, $title, $body);
	}
}
exit;
