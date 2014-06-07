<?php
func_need_login();	/**< 判断用户是否已登录 */
$token = isset($_GET['token'])?$_GET['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_GET['id'])){
		echo "没有项目id";
		exit;
	}else{
		$proj = new Proj('', '', '', '');
		if(!($proj->isExist($_GET['id']))){
			echo "项目不存在!";
			exit;
		}
		if($proj->stop($_GET['id'])){
			echo "停止成功!";
			func_gohome();
		}else{
			echo "停止失败!";
		}
		unset($proj);
	}
}else{
	echo "没有权限!";
}
