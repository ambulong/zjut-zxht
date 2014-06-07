<?php
func_need_login();
$title = "项目设置 - ".$config['site']['sitename'];
func_header($title);
func_nav(0);
$pid = isset($_GET['id'])?intval($_GET['id']):"";
$proj = new Proj("", "", "", "");
if(!$proj->isExist($pid)){
	echo "无效项目ID!";
	exit;
}
$setting = $proj->getSetting($pid);
$params = $proj->getParams($pid);
?>
<div id="main" class="main-projs">
	<div class="panel panel-default panel-block" style="width:100%;">
		<div class="panel-heading">
			<span class="panel-title">项目设置 : <?php $proj->showName($pid);?></span>
		</div>
		<table class="table table-condensed" id="projs">
			<tr>
				<td>
				<form class="form-horizontal" id="form_proj_set" action="<?php echo func_url("do","proj_set");?>" method="POST" role="form">
				  <div class="form-group">
					<label for="inputProjSetPerpage" class="col-sm-2 control-label">每页显示数量</label>
					<div class="col-sm-2">
					  <input type="text" name="proj_set_perpage" class="form-control" id="inputProjSetPerpage" placeholder="" value="<?php echo htmlspecialchars($setting['perpage']);?>">
					  <p class="help-block">值为0时表示不分页</p>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjSetReurl" class="col-sm-2 control-label">跳转地址</label>
					<div class="col-sm-8">
					  <input type="text" name="proj_set_reurl" class="form-control" id="inputProjSetReurl" placeholder="如:http://www.zjut.com/reg/success.html" value="<?php echo htmlspecialchars($setting['reurl']);?>">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjSetErrurl" class="col-sm-2 control-label">出错返回地址</label>
					<div class="col-sm-8">
					  <input type="text" name="proj_set_errurl" class="form-control" id="inputProjSetErrurl" placeholder="如:http://www.zjut.com/reg/error.html" value="<?php echo htmlspecialchars($setting['errurl']);?>">
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjEle" class="col-sm-2 control-label">概况显示字段</label>
					<div class="col-sm-10">
					  <table class="table table-condensed">
					  	<tr>
					  		<td>
								<select multiple id="select-eles-left" class="form-control" style="height:130px;">
<?php
if(is_array($params)){
	foreach($params as $param){
		if($param['default_show'] != 1){
			echo "<option value=\"".htmlspecialchars($param['id'])."\">".htmlspecialchars($param['name'])."</option>";
		}
	}
}
?>
								</select>
					  		</td>
					  		<td	style="width:40px;">
					  			<button type="button"  id="proj-eles-select-right" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-right"></span></button>
					  			<br><br>
					  			<button type="button"  id="proj-eles-select-left" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-left"></span></button>
					  		</td>
					  		<td>
					  			<select multiple id="select-eles-right" class="form-control" style="height:130px;">
<?php
if(is_array($params)){
	foreach($params as $param){
		if($param['default_show'] == 1){
			echo "<option value=\"".htmlspecialchars($param['id'])."\">".htmlspecialchars($param['name'])."</option>";
		}
	}
}
?>
								</select>
							</td>
							<td	style="width:40px;">
					  			<button type="button"  id="proj-eles-select-up" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-up"></span></button>
					  			<br><br>
					  			<button type="button"  id="proj-eles-select-down" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-chevron-down"></span></button>
					  		</td>
					  	</tr>
					  </table>
					  <p class="help-block">右边的是要显示的内容, 显示顺序从上到下, 默认前4字段</p>
					</div>
				  </div>
				  
				  <hr>
				  <div class="form-group">
					<label for="inputProjSetReCaptcha" class="col-sm-2 control-label">ReCaptcha</label>
					<div class="col-sm-8">
					  	<label class="radio-inline">
							<input type="radio" name="optionsReCaptcha" id="optionsReCaptcha1" value="1" <?php echo ($setting['recaptcha_status']==1)?"checked":""; ?>>开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="optionsReCaptcha" id="optionsReCaptcha2" value="0" <?php echo ($setting['recaptcha_status']==0)?"checked":""; ?>>关闭
						</label>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjSetReCaptchaPubKey" class="col-sm-2 control-label">公钥</label>
					<div class="col-sm-8">
					  <textarea name="proj_set_recaptchapubkey" class="form-control" id="inputProjSetReCaptchaPubKey" placeholder="Public Key"><?php echo htmlspecialchars($setting['recaptcha_pubkey']);?></textarea>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjSetReCaptchaPrivKey" class="col-sm-2 control-label">密钥</label>
					<div class="col-sm-8">
					  <textarea name="proj_set_recaptchaprivkey" class="form-control" id="inputProjSetReCaptchaPrivKey" placeholder="Private Key"><?php echo htmlspecialchars($setting['recaptcha_privkey']);?></textarea>
					</div>
				  </div>
				  
				  <hr>
				  <div class="form-group">
					<label for="inputProjSetMailAlert" class="col-sm-2 control-label">邮件提醒</label>
					<div class="col-sm-8">
					  	<label class="radio-inline">
							<input type="radio" name="optionsMail" id="optionsMail1" value="1" <?php echo ($setting['mail_status']==1)?"checked":""; ?>>开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="optionsMail" id="optionsMail2" value="0" <?php echo ($setting['mail_status']==0)?"checked":""; ?>>关闭
						</label>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputProjSetMail" class="col-sm-2 control-label">邮箱</label>
					<div class="col-sm-8">
					  <input type="text" name="proj_set_mail" class="form-control" id="inputProjSetMail" placeholder="如:admin@zjut.com;hr@zjut.com" value="<?php echo htmlspecialchars($setting['mails']);?>">
					  <p class="help-block">多个邮箱请用分号 (";") 隔开</p>
					</div>
				  </div>
				  
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
					  <input type="hidden" name="id" value="<?php echo $pid;?>">
					  <input type="hidden" name="default_show" value="">
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
