<?php
func_need_login();	/**< 判断用户是否已登录 */
$token = isset($_POST['token'])?$_POST['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_POST['user_pwd']) || !isset($_POST['user_new_pwd']) || !isset($_POST['user_new_pwd2'])){
		echo "1:填写不完整!";
		exit;
	}else if(trim($_POST['user_pwd']) == "" || trim($_POST['user_new_pwd']) == "" || trim($_POST['user_new_pwd2']) == ""){
		echo "2:填写不完整!";
		exit;
	}else if(strcmp($_POST['user_new_pwd'],$_POST['user_new_pwd2']) != 0){	/**< 不要直接用等于比较字符串, 详见http://drops.wooyun.org/papers/1409 */
		echo "两次输入密码不一样!";
		exit;
	}else if(strcmp($_SESSION['user']['password'],$_POST['user_pwd']) != 0){
		echo "旧密码错误!";
		exit;
	}else{
		$user = new User($_SESSION['user']['username'], $_POST['user_new_pwd']);
		$user->update();
		$user->logout();
		unset($user);
		func_gohome();
	}
}else{
	echo "没有权限!";
}
