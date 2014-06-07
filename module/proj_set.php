<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$token = isset($_POST['token'])?$_POST['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_POST['id']) || trim($_POST['id']) == ""){
		echo "无效项目!";
		exit;
	}else if(!isset($_POST['proj_set_perpage']) || !isset($_POST['optionsReCaptcha']) || !isset($_POST['optionsMail'])){
		echo "1.填写不完整!";
		exit;
	}else if(trim($_POST['proj_set_perpage']) == "" || trim($_POST['optionsReCaptcha']) == "" || trim($_POST['optionsMail']) == ""){
		echo "2.填写不完整!";
		exit;
	}else if(!is_json(trim($_POST['default_show']))){
		echo "参数数据错误";
		exit;
	}else{
		//echo $_POST['proj_set_perpage']."\n".$_POST['optionsReCaptcha']."\n".$_POST['optionsMail']."\n".$_POST['default_show'];
		$pid		= intval($_POST['id']);
		$setting["perpage"]	= isset($_POST['proj_set_perpage'])?intval($_POST['proj_set_perpage']):23;
		$setting["reurl"]		= isset($_POST['proj_set_reurl'])?$_POST['proj_set_reurl']:"";
		$setting["errurl"]		= isset($_POST['proj_set_errurl'])?$_POST['proj_set_errurl']:"";
		$setting["default_show"]		= trim($_POST['default_show']);
		$setting["recaptcha_status"]	= isset($_POST['optionsReCaptcha'])?intval($_POST['optionsReCaptcha']):0;
		$setting["mail_status"]		= isset($_POST['optionsMail'])?intval($_POST['optionsMail']):0;
		$setting["recaptcha_pubkey"]	= isset($_POST['proj_set_recaptchapubkey'])?$_POST['proj_set_recaptchapubkey']:"";
		$setting["recaptcha_privkey"]	= isset($_POST['proj_set_recaptchaprivkey'])?$_POST['proj_set_recaptchaprivkey']:"";
		$setting["mails"]		= isset($_POST['proj_set_mail'])?$_POST['proj_set_mail']:"";
		//var_dump($setting["default_show"]);
		$proj = new Proj("", "", "", "");
		if(!$proj->isExist($pid)){
			echo "项目不存在!";
			exit;
		}
		$name = $proj->getName($pid);
		$desc = $proj->getDesc($pid);
		unset($proj);
		$proj = new Proj($name, $desc, "", $setting);
		if($proj->updateSetting($pid)){
			echo "更新成功!";
		}else{
			echo "更新失败!";
		}
	}
}else{
	echo "没有权限!";
}
