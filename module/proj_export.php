<?php
func_need_login();	/**< 判断用户是否已登录 */
$token = isset($_POST['token'])?$_POST['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_POST['id']) || trim($_POST['id']) == ""){
		echo "无效项目!";
		exit;
	}else if(!isset($_POST['export_ids']) || !isset($_POST['type'])){
		echo "1.填写不完整!";
		exit;
	}else if(trim($_POST['export_ids']) == "" || trim($_POST['type']) == ""){
		echo "2.填写不完整!";
		exit;
	}else if(!is_json(trim($_POST['export_ids']))){
		echo "参数数据错误";
		exit;
	}else{
		$pid	= intval($_POST['id']);
		$type	= strtolower($_POST['type']);
		if($type != "xls" && $type != "csv" && $type != "json"){
			echo "导出格式错误";
			exit;
		}
		$proj = new Proj('', '', '', '');
		if(!($proj->isExist($pid))){
			echo "项目不存在!";
			exit;
		}
		$params = json_decode(trim($_POST['export_ids']), true);
		if(count($params) > 0){
			$proj->export($pid, $params, $type);
		}else{
			echo " 没有选择要导出的字段";
		}
	}
}else{
	echo "没有权限!";
}
