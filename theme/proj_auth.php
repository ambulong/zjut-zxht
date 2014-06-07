<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$title = "项目权限 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);
$pid = isset($_GET['id'])?intval($_GET['id']):"";
$users = new Users();
$proj = new Proj("", "", "", "");
if(!$proj->isExist($pid)){
	echo "项目不存在";
	exit;
}
$users_list = $users->getUsers();
//var_dump($users_list);
$uid_list = array();
foreach($users_list as $value){
	$uid_list[] = $value['id'];
}
//var_dump($uid_list);
$uid_list = array_unique($uid_list);	/**< 所有用户UID数组 */
$uid_list_temp = $uid_list;				/**< 临时储存所有UID数组 */
$uid_list = array();					/**< 用来储存排除项目UID数组 */
$proj_uid_list = (count($proj->getUsers($pid))>1)?array_unique($proj->getUsers($pid)):$proj->getUsers($pid);	/**< 用来储存项目UID数组 */
if(count($proj_uid_list) > 0){
	foreach($uid_list_temp as $value){
		if(!in_array($value, $proj_uid_list)){
			$uid_list[] = $value;
		}
	}
}else{
	$uid_list = $uid_list_temp;
}
//var_dump($uid_list);
//var_dump($proj_uid_list);
?>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">权限 : <?php $proj->showName($pid);?></span>
		</div>
		<table class="table table-condensed" id="projs">
			<tr>
				<td>
				<form class="form-horizontal" id="form_proj_auth" action="<?php echo func_url("do","proj_auth");?>" method="post" role="form">
				  <div class="form-group">
					<label for="inputProjEle" class="col-sm-2 control-label">用户</label>
					<div class="col-sm-10">
					  <table class="table table-condensed">
					  	<tr>
					  		<td>
								<select multiple class="form-control" id="select_users" style="height:130px;">
<?php
if(count($uid_list) > 0){
foreach($uid_list as $value){
?>
									<?php if(($users->getRole($value)) != 1){ ?>
										<option value="<?php echo htmlspecialchars($value);?>"><?php $users->showName($value); ?></option>
<?php }}} ?>
								</select>
					  		</td>
					  		<td	style="width:40px;">
					  			<button type="button" id="proj_auth_select_right" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-right"></span></button>
					  			<br><br>
					  			<button type="button" id="proj_auth_select_left" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button>
					  		</td>
					  		<td>
					  			<select multiple class="form-control" id="select_auths" style="height:130px;">
<?php
if(count($proj_uid_list) > 0){
foreach($proj_uid_list as $value){
?>
									<option value="<?php echo htmlspecialchars($value);?>"><?php $users->showName($value); ?></option>
<?php }} ?>
								</select>
							</td>
					  	</tr>
					  </table>
					  <p class="help-block">右边的是拥有管理此项目权限用户</p>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
					  <input type="hidden" name="id" value="<?php echo $pid;?>">
					  <input type="hidden" name="uids" value="<?php echo htmlspecialchars(json_encode($proj_uid_list));?>">
					  <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
					  <button type="submit" class="btn btn-primary btn-submit">保存</button>
					</div>
				  </div>
				</form>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php
func_footer();
?>
