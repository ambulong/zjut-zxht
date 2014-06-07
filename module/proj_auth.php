<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$token = isset($_POST['token'])?$_POST['token']:null;
$uids = isset($_POST['uids'])?$_POST['uids']:"";
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_POST['id'])){
		echo "没有项目id";
		exit;
	}else{
		$proj = new Proj("","","","");
		if(is_json($uids)){
			$uids = json_decode($uids);
		}else{
			$uids = "";
		}
		if($proj->updateUsers($_POST['id'], $uids)){
			echo "更新成功";
		}else{
			echo "更新失败";
			//func_gohome();
		}
	}
}else{
	echo "没有权限!";
}
