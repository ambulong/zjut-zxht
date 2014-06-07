<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
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
		if($proj->delete($_GET['id'])){
			echo "删除成功!";
			//func_gohome();
		}else{
			echo "删除失败!";
		}
		unset($proj);
	}
}else{
	echo "没有权限!";
}
