<?php
if(func_is_login()) header("location:".func_url("show","index"));	//判断是否登录,已登录则跳转到管理中心

$title = "登录 - ".$config['site']['sitename'];
func_header($title);
?>
<div id="login_panel">
	<div class="panel panel-default">
	<div class="panel-body">
		<form role="form" class="form-signin" id="login_form" action="<?php echo func_url("do","login"); ?>" method="post">
		<p>
			<label for="inputUsername">用户名</label>
			<input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" check-type="required" required="" autofocus="">	
		</p>
		<p>
			<label for="inputPassword">密码</label>
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" check-type="required" required="">
		</p>
				<p style="text-align:center;font-size:9px;color:red;">
				<?php
					if(isset($_GET['err'])){
						switch($_GET['err']){
							case 1:
								echo "帐号或密码错误!";
								break;
							case 2:
								echo "系统错误!";
								break;
							default:
								echo "";
						}
					}
				?>
				</p>
				<hr>
				<p></p>
		<p>
			<button class="btn btn-primary btn-lg btn-block" type="submit">登录</button>
		</p>
		</form>
	</div>
	</div>
</div>
<?php
func_footer();
?>
