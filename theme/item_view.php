<?php
func_need_login();
$title = "记录详情 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);
$pid = isset($_GET['pid'])?intval($_GET['pid']):"";
$id = isset($_GET['id'])?intval($_GET['id']):"";
$proj = new Proj("", "", "", "");
if(!$proj->isExist($pid)){
	echo "无效项目ID!";
	exit;
}
$params = $proj->getParams($pid);
$item = (new Item($pid, ""))->getData($id);
if($item == null){
	echo "读取记录出错!";
	exit;
}
?>
<div id="main" class="main-item-view">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title"><?php $proj->showName($pid);?> > ID<?php echo intval($item['id']);?></span>
		</div>
		<table class="table table-condensed" id="item_view">
			<tr>
				<td>
					<table style="margin:13px;" class="table table-condensed table-bordered" id="item_view">
						<tr>
							<td><b>id</b></td>
							<td><?php echo intval($item['id']);?></td>
						</tr>
<?php
if(is_array($params)){
foreach($params as $param){
?>
						<tr>
							<td><b><?php echo htmlspecialchars($param['label']);?> (<?php echo htmlspecialchars($param['name']);?>)</b><?php echo htmlspecialchars($param['jcase']);?></td>
							<td><?php echo htmlspecialchars($item[$param['name']]);?></td>
						</tr>
<?php
}}
?>
<?php
if(is_json(trim($item['ei']))){
$ei = json_decode($item['ei'], true);
?>
						<tr>
							<td><b>IP</b></td>
							<td><?php echo htmlspecialchars($ei["ip"]);?></td>
						</tr>
						<tr>
							<td><b>time</b></td>
							<td><?php echo htmlspecialchars($ei["time"]);?></td>
						</tr>
						<tr>
							<td><b>HTTP_ACCEPT</b></td>
							<td><?php echo htmlspecialchars($ei["HTTP_ACCEPT"]);?></td>
						</tr>
						<tr>
							<td><b>HTTP_HOST</b></td>
							<td><?php echo htmlspecialchars($ei["HTTP_HOST"]);?></td>
						</tr>
						<tr>
							<td><b>HTTP_REFERER</b></td>
							<td><?php echo htmlspecialchars($ei["HTTP_REFERER"]);?></td>
						</tr>
						<tr>
							<td><b>HTTP_USER_AGENT</b></td>
							<td><?php echo htmlspecialchars($ei["HTTP_USER_AGENT"]);?></td>
						</tr>
<?php
}
?>
					</table>
				</td>
			</tr>
		</table>
	</div>
</div>
<?php
func_footer();
?>
