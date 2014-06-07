<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$title = "添加项目 - ".$config['site']['sitename'];
func_header($title);
func_nav(2);
?>

<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">添加项目</span>
		</div>
		<table class="table table-condensed" id="projs">
			<tr>
				<td>
				<form class="form-horizontal" id="form_proj_new" action="<?php echo func_url("do","proj_new");?>" method="POST" role="form" >
				  <div class="form-group">
					<label for="inputProjName" class="col-sm-2 control-label">项目名</label>
					<div class="col-sm-8">
					  <input type="text" name="proj_name" class="form-control" id="inputProjName" placeholder="" check-type="required" required="">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjDesc" class="col-sm-2 control-label">项目描述</label>
					<div class="col-sm-8">
					  <textarea name="proj_desc" class="form-control" id="inputProjDesc" placeholder="" check-type="required" required=""></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjEle" class="col-sm-2 control-label">参数配置</label>
					<div class="col-sm-10">
					  <table class="table table-condensed table-hover">
					  	<tr>
					  		<th title="操作">+</th>
					  		<th title="需要这个值来接收提交过来的内容, 如: sex">参数名</th>
					  		<th title="这个参数对应的名字, 如: 性别">显示名</th>
					  		<th title="POST, GET, ...">method</th>
					  		<th title="文本框, 单选, 图片地址, 网址等">类型</th>
					  		<th title="不同的值对应不同的'显示名',json格式, 如: '{&quot;male&quot;:&quot;男&quot;,&quot;female&quot;:&quot;女&quot;}'">case</th>
					  		<th title="此参数是否可以为空">可空</th>
					  		<th title="正则表达">regex</th>
					  		<th title="注释">*</th>
					  	</tr>
					  	<tr class="example tr-add" style="color:grey;">
					  		<td>演示<!--<a href="#" class="add-del">del</a>--></td>
					  		<td>sex</td>
					  		<td>性别</td>
					  		<td>POST</td>
					  		<td>单选</td>
					  		<td title="json格式{&quot;male&quot;:&quot;男&quot;,&quot;female&quot;:&quot;女&quot;}"><div>{&quot;male&quot;:&quot;男&quot;,&quot;female&quot;:&quot;女&quot;}</div></td>
					  		<td>y</td>
					  		<td title="^(male|female)$"><div>^(male|female)$</div></td>
					  		<td title="Example"><div>Example</div></td>
					  	</tr>
					  	<tr id="tr-param-add">
					  		<td><button type="button" id="btn-param-add" class="btn btn-default btn-xs">&nbsp;&nbsp;+&nbsp;&nbsp;</b></button></td>
					  		<td title="只能输入英文字母"><input type="text" name="param-add-name" style="width:60px;height:23px;" placeholder=" name"></td>
					  		<td><input type="text" name="param-add-label" style="width:60px;height:23px;" placeholder=" label"></td>
					  		<td>
					  			<select name="param-add-method" style="width:60px;height:23px;">
					  				<option value="post">POST</option>
					  				<option value="get">GET</option>
					  				<option value="request">REQUEST</option>
					  			</select>
					  		</td>
					  		<td>
					  			<select name="param-add-type" style="width:60px;height:23px;">
					  				<option value="text">文本框</option>
					  				<option value="textarea">文本</option>
					  				<option value="radio">单选</option>
					  				<option value="checkbox">多选</option>
					  				<option value="url">URL</option>
					  			</select>
					  		</td>
					  		<td title="json格式">
					  			<input type="text" name="param-add-case" style="width:100px;height:23px;" placeholder=" json格式">
					  		</td>
					  		<td>
					  			<select name="param-add-allow_null" style="width:40px;height:23px;">
					  				<option value="y">y</option>
					  				<option value="n" selected>n</option>
					  			</select>
					  		</td>
					  		<td title="regex"><input type="text" name="param-add-regex" style="width:100px;height:23px;" placeholder=" regex"></td>
					  		<td title="注释"><input type="text" name="param-add-comment" style="width:80px;height:23px;" placeholder=" 注释"></td>
					  	</tr>
					  </table>
					  <textarea style="display:none;" name="proj_params" class="form-control" id="inputProjParams" check-type="required" required=""></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
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
