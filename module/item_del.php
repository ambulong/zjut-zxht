<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$token = isset($_GET['token'])?$_GET['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_GET['id']) || !isset($_GET['pid'])){
		echo "缺少参数";
		exit;
	}else{
		$pid = isset($_GET['pid'])?intval($_GET['pid']):"";
		$id = isset($_GET['id'])?intval($_GET['id']):"";
		$proj = new Proj("", "", "", "");
		if(!$proj->isExist($pid)){
			echo "无效项目ID!";
			exit;
		}
		$item = new Item($pid, "");
		if($item->delete($id)){
			echo "删除成功";
		}else{
			echo "删除失败";
		}
	}
}else{
	echo "没有权限!";
}
