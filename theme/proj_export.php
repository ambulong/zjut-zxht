<?php
func_need_login();
$title = "导出内容 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);

$pid = isset($_GET['id'])?intval($_GET['id']):"";
$proj = new Proj("", "", "", "");
if(!$proj->isExist($pid)){
	echo "无效项目ID!";
	exit;
}
$params = $proj->getParams($pid);
?>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">导出内容 : 长期招新</span>
		</div>
		<table class="table table-condensed" id="projs">
			<tr>
				<td>
				<form class="form-horizontal"  id="form_proj_export" action="<?php echo func_url("do","proj_export");?>" method="POST" role="form">
				  <div class="form-group">
					<label for="inputProjEle" class="col-sm-2 control-label">要导出的字段</label>
					<div class="col-sm-10">
					  <table class="table table-condensed">
					  	<tr>
					  		<td>
								<select multiple id="select-eles-left" class="form-control" style="height:130px;">
<?php
if(is_array($params)){
	foreach($params as $param){
			echo "<option value=\"".htmlspecialchars($param['id'])."\">".htmlspecialchars($param['name'])."</option>";
	}
}
?>
								</select>
					  		</td>
					  		<td	style="width:40px;">
					  			<button type="button" id="proj-eles-select-right" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-right"></span></button>
					  			<br><br>
					  			<button type="button"  id="proj-eles-select-left" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button>
					  		</td>
					  		<td>
					  			<select multiple id="select-eles-right" class="form-control" style="height:130px;">
								</select>
							</td>
							<td	style="width:40px;">
					  			<button type="button"  id="proj-eles-select-up" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-up"></span></button>
					  			<br><br>
					  			<button type="button"  id="proj-eles-select-down" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-down"></span></button>
					  		</td>
					  	</tr>
					  </table>
					  <p class="help-block">右边的是要导出的内容, 排列顺序从上到下</p>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjSetReCaptcha" class="col-sm-2 control-label">文件格式</label>
					<div class="col-sm-2">
					  	<select name="type" class="form-control">
									<option value="xls" selected>xls</option>
									<option value="csv">csv</option>
									<option value="json">json</option>
						</select>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
					  <input type="hidden" name="id" value="<?php echo $pid;?>">
					  <input type="hidden" name="export_ids" value="">
					  <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
					  <button type="submit" class="btn btn-primary btn-submit">导出</button>
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
