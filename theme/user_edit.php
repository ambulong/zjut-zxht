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
$title = "编辑用户 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);
?>
<script type="text/javascript">
$(function(){
	$("#form_user_edit").submit(function(){
		if($("input[name='user_new_pwd']").val() == $("input[name='user_new_pwd2']").val()){
			return true;
		}else{
			alert("两次输入密码不同");
			return false;
		}
	});
})
</script>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">编辑用户</span>
		</div>
		<table class="table table-condensed" id="projs">
			<tr>
				<td>
				<form class="form-horizontal" action="<?php echo func_url("do","user_edit");?>" method="POST" id="form_user_edit" role="form">
				  <div class="form-group">
					<label for="inputUserName" class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-5">
					  <input type="text" name="user_name" class="form-control" id="inputUserName" value="<?php echo $user->showUsernameU($_GET['id']);?>" disabled>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputUserNewPwd" class="col-sm-2 control-label">新密码</label>
					<div class="col-sm-8">
					  <input type="password" name="user_new_pwd" class="form-control" id="inputUserNewPwd" check-type="required" required="">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputUserNewPwd2" class="col-sm-2 control-label">重复新密码</label>
					<div class="col-sm-8">
					  <input type="password" name="user_new_pwd2" class="form-control" id="inputUserNewPwd2" check-type="required" required="">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
					  <input type="hidden" name="uid" value="<?php echo func_intintval($_GET['id']);?>">
					  <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
					  <button type="submit" class="btn btn-primary">保存</button>
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
