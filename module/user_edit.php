<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$token = isset($_POST['token'])?$_POST['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_POST['uid']) || !isset($_POST['user_new_pwd']) || !isset($_POST['user_new_pwd2'])){
		echo "1:填写不完整!";
		exit;
	}else if(trim($_POST['uid']) == "" || trim($_POST['user_new_pwd']) == "" || trim($_POST['user_new_pwd2']) == ""){
		echo "2:填写不完整!";
		exit;
	}else if(strcmp($_POST['user_new_pwd'],$_POST['user_new_pwd2']) != 0){	/**< 不要直接用等于比较字符串, 详见http://drops.wooyun.org/papers/1409 */
		echo "两次输入密码不一样!";
		exit;
	}else{
		$user = new User('', '');
		if(!($user->isExistU($user->getUsernameU($_POST['uid'])))){
			echo "用户不存在!";
			exit;
		}
		$username = $user->getUsernameU($_POST['uid']);
		unset($user);
		$user = new User($username, $_POST['user_new_pwd']);
		if($user->update()){
			echo "修改成功!";
		}else{
			echo "修改失败!";
		}
		unset($user);
	}
}else{
	echo "没有权限!";
}
