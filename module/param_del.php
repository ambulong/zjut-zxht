<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$token = isset($_GET['token'])?$_GET['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_GET['id'])){
		echo "没有参数id";
		exit;
	}else{
		$param = new Param('', '');
		if(!($param->isExist($_GET['id']))){
			echo "参数不存在!";
			exit;
		}
		if($param->delete($_GET['id'])){
			echo "删除成功!";
			//func_gohome();
		}else{
			echo "删除失败!";
		}
		unset($param);
	}
}else{
	echo "没有权限!";
}
