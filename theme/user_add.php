<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$title = "添加用户 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);
?>
<script type="text/javascript">
$(function(){
	$("#form_user_add").submit(function(){
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
			<span class="panel-title">添加用户</span>
		</div>
		<table class="table table-condensed" id="projs">
			<tr>
				<td>
				<form class="form-horizontal" id="form_user_add" action="<?php echo func_url("do","user_add");?>" method="POST" role="form">
				  <div class="form-group">
					<label for="inputUserName" class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-5">
					  <input type="text" name="user_name" class="form-control" id="inputUserName" check-type="required" required="">
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
