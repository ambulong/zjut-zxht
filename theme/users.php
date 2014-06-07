<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$title = "用户管理 - ".$config['site']['sitename'];
func_header($title);
func_nav(3);

$users = new Users();
$users_array = $users->getUsers();
?>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">用户管理</span>
		</div>
		<div id="nav-operate">
			<button type="button" class="btn btn-default btn-xs btn-checkall" status="unchecked"><span class="glyphicon glyphicon-check"></span> 全部</button>
			<button type="button" class="btn btn-default btn-xs btn-delete-user" data-toggle="modal" data-target="#delUser"><span class="glyphicon glyphicon-remove"></span> 删除</button>
			<a class="btn btn-default btn-xs btn-add-user" href="<?php echo func_url("show","user_add");?>"><span class="glyphicon glyphicon-plus"></span> 添加用户</a>
		</div>
		<table class="ctable table table-striped table-hover table-condensed" id="projs">
<?php foreach($users_array as $value) {?>
			<tr>
				<td class="users_td_operate">
					<input type="checkbox" class="s_checkbox s_checkbox_user">
					<div class="main-content-operate">
						<a class="link_delete" href="<?php echo func_url("do","user_delete&token=".$_SESSION['token']."&uid=");$users->showUID($value['id']);?>" class="s_del_user" onclick="return confirm('确定删除用户 <?php $users->showName($value['id']); ?> 吗?');">删除</a>
						<a href="<?php echo func_url("show","user_edit&id=");$users->showUID($value['id']);?>" class="s_edit_user">编辑</a>
						<a href="<?php echo func_url("show","user_log&id=");$users->showUID($value['id']);?>" class="s_logs_user">日志</a>
					</div>
				</td>
				<td class="username"><b><?php $users->showName($value['id']); ?></b></td>
				<td class="ip" status="1"><?php $users->showIP($value['id']); ?></td>
				<td class="time"><?php $users->showTime($value['id']); ?></td>
			</tr>
<?php } ?>
		</table>
	</div>
</div>
<?php
func_footer();
?>
