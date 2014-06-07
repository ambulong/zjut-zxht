<?php
func_need_login();
$title = "项目列表 - ".$config['site']['sitename'];
func_header($title);
func_nav(1);
?>
<script type="text/javascript">
	$(function(){
		$.each($("#projs .status"),function(index,item){
			if($(item).attr("status") == 1){
				$(item).children("span").css("color","green");
			}else{
				$(item).children("span").css("color","red");
			}
		});
	})
</script>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">项目列表</span>
		</div>
		<div id="nav-operate">
			<button type="button" class="btn btn-default btn-xs btn-checkall" status="unchecked"><span class="glyphicon glyphicon-check"></span> 全部</button>
			<button type="button" class="btn btn-default btn-xs btn-delete-proj" data-toggle="modal" data-target="#delProj" <?php if($_SESSION['user']['role'] != 1) echo "disabled=\"disabled\""; ?>><span class="glyphicon glyphicon-remove"></span> 删除</button>
		</div>
		<table class="mtable table table-striped table-hover table-condensed" id="projs">
<?php
$projs = new Projs($_SESSION['user']['uid']);
$projs_list = $projs->getProjs();
if(!is_array($projs_list) || count($projs_list) == 0) echo "<tr><td><center>无项目</center></td></tr>";
foreach($projs_list as $proj){
?>
			<tr>
				<td class="projs_td_operate">
					<input type="checkbox" class="s_checkbox_proj s_checkbox">
					<div class="main-content-operate">
						<?php if($_SESSION['user']['role'] == 1){?>
						<a class="link_delete" href="<?php func_proj_url('del',$projs->getPID($proj['id'])."&token=".$_SESSION['token']); ?>" class="s_del_proj"  onclick="return confirm('确定删除ID为 <?php echo $projs->getPID($proj['id']) ?> 的项目吗?');">删除</a>
						<?php } ?>
						<?php if($projs->getStatus($proj['id']) == 1){ ?>
						<a href="<?php func_proj_url('stop',$projs->getPID($proj['id'])."&token=".$_SESSION['token']); ?>" class="s_stop_proj">停用</a>
						<?php }else{ ?>
						<a href="<?php func_proj_url('start',$projs->getPID($proj['id'])."&token=".$_SESSION['token']); ?>" class="s_stop_proj">开始</a>
						<?php } ?>
						<a href="<?php func_proj_url('export',$projs->getPID($proj['id'])); ?>" class="s_export_proj">导出</a>
						<a href="<?php func_proj_url('set',$projs->getPID($proj['id'])); ?>" class="s_set_proj">设置</a>
						<a href="<?php func_proj_url('profile',$projs->getPID($proj['id'])); ?>" class="s_profile_proj" title="参数设置等">配置</a>
						<?php if($_SESSION['user']['role'] == 1){?>
						<a href="<?php func_proj_url('auth',$projs->getPID($proj['id'])); ?>" class="s_auth_proj">权限</a>
						<?php } ?>
					</div>
				</td>
				<td class="title"><a href="<?php func_proj_url('view',$projs->getPID($proj['id'])); ?>"><?php $projs->showName($proj['id']);?></a></td>
				<td class="api"><a href="#">API</a></td>
				<td class="id"><?php echo intval($proj['id']);?></td>
				<td class="status" status="<?php $projs->showStatus($proj['id']);?>">状态: <span><?php $projs->showStatusC($proj['id']);?></span></td>
				<td class="num">数量:<?php $projs->showItemsNum($proj['id']);?></td>
			</tr>
<?php
}
?>
		</table>
	</div>
</div>
<div id="modal-proj-api" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">API : <span id="modal-proj-name">测试</span></h4>
      </div>
      <div class="modal-body">
        <p>JSON : <?php echo URL_ROOT;?>/api.php?id=<span id="modal-proj-id"></span></p>
        <p>跳转 : <?php echo URL_ROOT;?>/api.php?id=<span id="modal-proj-id"></span>&open301=1</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php
func_footer();
?>
