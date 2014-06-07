<?php
func_need_login();
$pid = isset($_GET['pid'])?intval($_GET['pid']):"";
$id = isset($_GET['id'])?intval($_GET['id']):"";
$proj = new Proj("", "", "", "");
if(!$proj->isExist($pid)){
	echo "无效项目ID!";
	exit;
}
$item = (new Item($pid, ""))->getData($id);
if($item == null){
	echo "读取记录出错!";
	exit;
}
header('Content-type: application/json');
echo json_encode($item);
