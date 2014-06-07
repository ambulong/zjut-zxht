<?php
include('./init.php');
$action = @$_GET['action'];
$source = @$_GET['m'];
$actions['items'] = array(
	'show',
	'do'
);
$actions['show'] = array(
	//普通权限
	'index',			//默认首页
	'login',			//登录页
	'msg',				//提示信息页
	'proj_list',		//项目列表
	'proj_item',		//项目内容列表
	'proj_set',			//项目设置
	'proj_export',		//项目内容导出
	'item_view',		//详细内容
	'item_json',		//详细内容(json)
	'user_profile',		//个人资料(修改密码)
	//管理权限
	'users',			//用户管理
	'user_add',			//添加用户
	'user_edit',		//编辑用户
	'user_log',			//用户登录日志
	'proj_profile',		//项目高级设置(参数配置等)
	'proj_auth',		//项目权限分配	
	'proj_new',			//添加项目
	'log'				//登录日志
);
$actions['do'] = array(
	'index',			//跳转到首页
	'login',			//登录操作
	'logout',			//注销操作
	'user_profile',		//个人资料(修改密码)
	'user_add',			//添加用户
	'user_edit',		//编辑用户
	'user_delete',		//删除用户
	'proj_new',			//新建项目		#token
	'proj_set',			//保存项目设置		#token
	'proj_stop',		//停止项目		#token
	'proj_start',		//启动项目		#token
	'proj_export',		//导出项目操作		#token
	'proj_profile',		//保存项目高级设置	#token
	'proj_auth',		//保存权限分配		#token
	'proj_del',			//删除项目		#token
	'param_del',		//删除参数		#token
	'item_del',			//删除记录		#token
);

if(!in_array($action,$actions['items'])) $action = 'show';
if(!in_array($source,$actions[$action])) $source = 'index';

if($action == 'show')
	require(ROOT_PATH.'/theme/'.$source.'.php');
if($action == 'do')
	require(ROOT_PATH.'/module/'.$source.'.php');

//mysql_close($sql_conn);
exit;
?>
