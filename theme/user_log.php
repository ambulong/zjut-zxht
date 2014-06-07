<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
if(!isset($_GET['id'])){
	echo "没有选者用户!";
	exit;
}else{
	$user = new User('', '');
	if(!($user->isExistU($user->getUsernameU($_GET['id'])))){
		echo "用户不存在!";
		exit;
	}
}
$title = "用户日志 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);

$user = new User($user->getUsernameU($_GET['id']), '');
$user_logs = $user->getLogs($user->getUsername());
?>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">用户日志 : <?php $user->showUsername(); ?></span>
		</div>
		<div id="nav-operate">
		</div>
		<table class="ctable table table-striped table-hover table-condensed" id="projs">
			<tr>
				<th>时间</th>
				<th>IP</th>
				<th>HTTP_ACCEPT</th>
				<th>HTTP_HOST</th>
				<th>HTTP_REFERER</th>
				<th>HTTP_USER_AGENT</th>
			</tr>
<?php
if(is_array($user_logs)){
	foreach($user_logs as $value) {
		$extend = json_decode($value['extend'], true);
?>
			<tr>
				<td class="time"><?php echo func_htmlhtmlspecialchars($value['time']); ?></td>
				<td class="ip"><?php echo func_htmlhtmlspecialchars($value['ip']); ?></td>
				<td class="HTTP_ACCEPT"><?php echo func_htmlhtmlspecialchars($extend['HTTP_ACCEPT']); ?></td>
				<td class="HTTP_HOST"><?php echo func_htmlhtmlspecialchars($extend['HTTP_HOST']); ?></td>
				<td class="HTTP_REFERER"><?php echo func_htmlhtmlspecialchars($extend['HTTP_REFERER']); ?></td>
				<td class="HTTP_USER_AGENT"><?php echo func_htmlhtmlspecialchars($extend['HTTP_USER_AGENT']); ?></td>
			</tr>
<?php 
	}
}

?>
		</table>
	</div>
</div>
<?php
func_footer();
?>
