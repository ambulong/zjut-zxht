<?php func_need_login(); ?>
<script type="text/javascript">
	$(function(){
		$("#nav_item_<?php echo "{$active}"; ?>").addClass("active");
	})
</script>
<div id="div-navbar">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-content">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo URL_ROOT;?>">精弘网络</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-content">
				<ul class="nav navbar-nav">
					<li id="nav_item_1"><a href="<?php echo func_url("show","proj_list"); ?>">项目列表</a></li>
					<?php if($_SESSION['user']['role'] == 1){ ?>
					<li id="nav_item_2"><a href="<?php echo func_url("show","proj_new"); ?>">添加项目</a></li>
					<li id="nav_item_3"><a href="<?php echo func_url("show","users"); ?>">用户管理</a></li>
					<?php } ?>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo func_htmlhtmlspecialchars($_SESSION['user']['username']);?><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo func_url("show","user_profile"); ?>">修改密码</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo func_url("do","logout&token=".$_SESSION['token']); ?>">退出</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</div>
