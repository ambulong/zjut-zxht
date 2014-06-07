<?php
func_need_login();
$title = "项目内容 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);
$pid	= isset($_GET['id'])?intval($_GET['id']):"";
$page	= isset($_GET['page'])?intval($_GET['page']):"1";
if($page <= 0) $page = 1;
$proj	= new Proj("", "", "", "");
if(!$proj->isExist($pid)){
	echo "无效项目ID!";
	exit;
}
$items	= new Items($pid);
$items_data	= $items->getItems($pid);
$show_params	= $items->getShowParams($pid);
$perpage	= $proj->getPerpage($pid);
$items_num	= $proj->getItemsNum($pid);
$prev_page	= 0;
$next_page	= 0;
$index	= 0;
$stop_mark	= $items_num;
$start	= 1;
$end	= $items_num;

if($perpage != 0){
	$max_page = (($items_num%$perpage)==0)?$items_num/$perpage:$items_num/$perpage+1;
	if($page > $max_page) $page = 1;
	$prev_page = $page - 1;
	$next_page = $page + 1;
	if($next_page > $max_page) $next_page = 0;
	
	$index = $prev_page*$perpage;
	$stop_mark = $page*$perpage;
	if($stop_mark > $items_num) $stop_mark = $items_num;
	
	$start	= $index + 1;
	$end	= $stop_mark;
}
?>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">项目内容 : <?php $proj->showName($pid);?></span>
		</div>
		<div id="nav-operate">
			<button type="button" class="btn btn-default btn-xs btn-checkall" status="unchecked"><span class="glyphicon glyphicon-check"></span> 全部</button>
			<button type="button" class="btn btn-default btn-xs btn-delete-item" data-toggle="modal" data-target="#delProj"><span class="glyphicon glyphicon-remove"></span> 删除</button>
			<div id="nav-pagination">
				<span><small>第 <?php echo ($start != $end)?$start." - ".$end:$start;?> 条, 共 <?php echo $items_num;?> 条 </small></span>
				<a type="button" class="btn btn-default btn-xs btn-page" <?php echo ($prev_page == 0)?"disabled=\"disabled\"":""; ?> href="<?php echo ($prev_page == 0)?"":func_url("show","proj_item")."&id=".$pid."&page=".$prev_page; ?>"><span class="glyphicon glyphicon-chevron-left"></span> 上一页</a>
				<a type="button" class="btn btn-default btn-xs btn-page" <?php echo ($next_page == 0)?"disabled=\"disabled\"":""; ?>  href="<?php echo ($next_page == 0)?"":func_url("show","proj_item")."&id=".$pid."&page=".$next_page; ?>">下一页 <span class="glyphicon glyphicon-chevron-right"></span></a>
			</div>
		</div>
		<table class="ctable table table-striped table-hover table-condensed" id="projs">
<?php
if($items_num > 0){
?>
			<tr>
				<th>+</th>
<?php
if(count($show_params) > 0){
foreach($show_params as $param){
?>
				<th class="param" title="<?php echo htmlspecialchars($param['name'])." ".htmlspecialchars($param['jcase']);?>"><?php echo htmlspecialchars($param['label']);?></th>
<?php
}}
?>
			</tr>
<?php
for(;$index<$stop_mark;$index++){
$item = $items_data[$index];
?>
			<tr>
				<td class="item_td_operate">
					<input type="checkbox" class="s_checkbox">
					<div class="main-content-operate">
						<a href="<?php echo func_url("do","item_del")."&pid=".$pid."&id=".$item['id']."&token=".$_SESSION['token']; ?>" class="s_del_item link_delete" onclick="return confirm('确定删除ID为 <?php echo $item['id'];?> 的项目吗?');">删除</a>
						<a target="_blank" href="<?php echo func_url("show","item_json")."&pid=".$pid."&id=".$item['id']; ?>" class="s_json_item">json</a>
						<a target="_blank" href="<?php echo func_url("show","item_view")."&pid=".$pid."&id=".$item['id']; ?>" class="s_detail_item">详细</a>
					</div>
				</td>
<?php
if(count($show_params) > 0){
foreach($show_params as $param){
?>
				<td class="item_name" title="<?php echo htmlspecialchars($item[$param['name']]);?>"><?php
if(is_json(trim($param['jcase']))){
	$case = json_decode(trim($param['jcase']), true);
	if(count($case) > 0){
		//var_dump($case);
		if(isset($case[$item[$param['name']]])){
			echo htmlspecialchars($case[$item[$param['name']]]);
		}else{
			echo htmlspecialchars($item[$param['name']]);
		}
	}else{
		echo htmlspecialchars($item[$param['name']]);
	}
}else{
	echo htmlspecialchars($item[$param['name']]);
}
				?></td>
<?php
}}
?>
			</tr>
<?php
}
?>

<?php
}else{
?>
			<tr>
				<td>
					<center>无记录</center>
				</td>
			</tr>
<?php
}
?>
		</table>
	</div>
</div>
<?php
func_footer();
?>
