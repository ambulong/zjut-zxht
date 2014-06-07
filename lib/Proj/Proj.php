<?php

/**
* 单个项目操作类
*/
class Proj {
	var $name;
	var $desc;
	var $params;
	var $setting;
	var $projid;	/**< $this->add()后这个值才有效 */
	
	/**
	* 构造函数
	* @param name 项目名
	* @param desc 项目描述
	* @param params array项目参数
	* @param setting array项目设置
	*/
	function __construct($name, $desc, $params, $setting) {
		$this->name = trim($name);
		$this->desc = trim($desc);
		$this->params = $params;
		$this->setting = $setting;
		$this->projid = null;
	}
	
	/**
	* 设置项目名
	* @params name 项目名
	*/
	public function setName($name){
		$this->name = trim($name);
	}
	/**
	* 设置项目描述
	* @params desc 项目描述
	*/
	public function setDesc($desc){
		$this->desc = trim($desc);
	}
	
	/**
	* 设置项目参数
	* @params params array项目参数
	*/
	public function setParams($params){
		$this->params = $params;
	}
	
	/**
	* 设置项目设置
	* @params setting 项目设置
	*/
	public function setSetting($setting){
		$this->setting = $setting;
	}
	
	/**
	* 添加到数据库
	* @return boolean
	*/
	public function add(){
		if($this->projid != null){
			throw new Exception("Project has been existed.");
		}else if($this->name == "" || $this->desc == null){
			throw new Exception("Name or Desc is null.");
		}else if(!($this->validateParams()) || !($this->validateSetting())){
			throw new Exception("Params or Setting is invalid.");
		}else{
			//mysql_insert_id();
			$name	= $this->name;
			$status	= 1;
			$desc	= $this->desc;
			$perpage	= isset($this->setting["perpage"])?$this->setting["perpage"]:23;
			$reurl	= isset($this->setting["reurl"])?$this->setting["reurl"]:"";
			$errurl	= isset($this->setting["errurl"])?$this->setting["errurl"]:"";
			$recaptcha_status	= isset($this->setting["recaptcha_status"])?$this->setting["recaptcha_status"]:0;
			$recaptcha_pubkey	= isset($this->setting["recaptcha_pubkey"])?$this->setting["recaptcha_pubkey"]:"";
			$recaptcha_privkey	= isset($this->setting["recaptcha_privkey"])?$this->setting["recaptcha_privkey"]:"";
			$mail_status	= isset($this->setting["mail_status"])?$this->setting["mail_status"]:0;
			$mails	= isset($this->setting["mails"])?$this->setting["mails"]:"";//split(';', $this->setting["mails"]);
			$query	= "insert into ".TBPREFIX."projs(`name`,`status`,`desc`,`perpage`,`reurl`,`errurl`,`recaptcha_status`,`recaptcha_pubkey`,`recaptcha_privkey`,`mail_status`,`mails`) values('".func_addaddslashes($name)."','".func_intintval($status)."','".func_addaddslashes($desc)."','".func_intintval($perpage)."','".func_addaddslashes($reurl)."','".func_addaddslashes($errurl)."','".func_addaddslashes($recaptcha_status)."','".func_addaddslashes($recaptcha_pubkey)."','".func_addaddslashes($recaptcha_privkey)."','".func_addaddslashes($mail_status)."','".func_addaddslashes($mails)."')";
			//echo $query;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			$this->projid = mysql_insert_id();
			//echo $this->projid;
			if(!$result || $this->projid == null){
				throw new Exception("Add setting is failed.");
				return 0;
				exit;
			}
			$this->createItemsTable($this->projid);
			var_dump($this->params);
			foreach($this->params as $value){
				$param	= new Param($this->projid, $value);
				echo 1;
				//var_dump($value);
				if(!($param->add())){
					throw new Exception("Fail to add param ".htmlspecialchars($value['name']).".");
					exit;
				}
				
			}
			return 1;
		}
	}
	/**
	* 添加表
	* @return boolean
	*/
	public function createItemsTable($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$item = null;
		$query_add	= "";
		$index	= 0;
		foreach($this->params as $value){
			$item[$index]['name']	= func_addaddslashes($value['name']);
			if($value['type'] == "text"){
				$item[$index]['type']	= "varchar(200)";
			}else if($value['type'] == "url"){
				$item[$index]['type']	= "varchar(200)";
			}else if($value['type'] == "textarea"){
				$item[$index]['type']	= "text";
			}else if($value['type'] == "radio"){
				$item[$index]['type']	= "varchar(100)";
			}else if($value['type'] == "checkbox"){
				$item[$index]['type']	= "varchar(100)";
			}
			$query_add .= ",`".$item[$index]['name']."` ".$item[$index]['type']." COLLATE utf8_bin NOT NULL";
			$index++;
		}
		$query = "CREATE TABLE IF NOT EXISTS `".TBPREFIX."items_".$id."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,`ei` text COLLATE utf8_bin NOT NULL
				  {$query_add},
				  PRIMARY KEY (`id`),
				  KEY `id` (`id`)
				)";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 更新表
	* @return boolean
	*/
	public function updateItemsTable($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$this->deleteItems($id);
		$this->createItemsTable($id);
		return 1;
	}
	/**
	* 检查Params是否合法
	* @return boolean
	*/
	private function validateParams(){
		if(!is_array($this->params)){	/**< 先检查是否为数组 */
			throw new Exception("Params is not a array.");
			return 0;
		}else{
			foreach($this->params as $value){	/**< 检查每一个二级数组 */
				if(!is_array($value)){	/**< 检查是否为数组 */
					throw new Exception("Params->Param is not a array.");
					return 0;
					break;
				}else if(	!isset($value['name']) || 
							!isset($value['label']) || 
							!isset($value['method']) || 
							!isset($value['type']) || 
							!isset($value['case']) || 
							!isset($value['allow_null']) || 
							!isset($value['regex']) || 
							!isset($value['comment'])
				){
					throw new Exception("some index unset");
					return 0;
					break;
				}else if(	trim($value['name']) == "" || 
							trim($value['label']) == "" || 
							trim($value['method']) == "" || 
							trim($value['type']) == "" || 
							trim($value['allow_null']) == ""
				){
					throw new Exception("some index is empty");
					return 0;
					break;
				}else if(!preg_match("/^[A-Za-z]+$/", trim($value['name']))){	/**< name只允许为应为字母 */
					throw new Exception("name[".htmlspecialchars(trim($value['name']))."] is invalid");
					return 0;
					break;
				}else if(	!strcasecmp($value['method'], "post") && 
							!strcasecmp($value['method'], "get") && 
							!strcasecmp($value['method'], "request")
				){	/**< 检查method */
					throw new Exception("method is invalid");
					return 0;
					break;
				}else if(	!strcasecmp($value['type'], "text") &&
							!strcasecmp($value['type'], "textarea") &&
							!strcasecmp($value['type'], "radio") &&
							!strcasecmp($value['type'], "checkbox") &&
							!strcasecmp($value['type'], "url")
				){	/**< 检查type */
					throw new Exception("type is invalid");
					return 0;
					break;
				}else if(	!strcasecmp($value['allow_null'], "y") && 
							!strcasecmp($value['allow_null'], "n")
				){	/**< 检查allow_null */
					throw new Exception("allow_null is invalid");
					return 0;
					break;
				}else{
					return 1;
				}
			}
		}
	}
	
	/**
	* 检查Setting是否合法
	* @return boolean
	*/
	private function validateSetting(){
		if(!is_array($this->setting)){	/**< 先检查是否为数组 */
			echo __LINE__;
			return 0;
		}else if(	!(intval($this->setting["perpage"]) >= 0) || !is_json($this->setting["default_show"])){
			echo __LINE__;
			return 0;
		}else if(	$this->setting["recaptcha_status"] != 1 && $this->setting["recaptcha_status"] != 0){
			echo __LINE__;
			return 0;
		}else if(	$this->setting["mail_status"] != 1 && $this->setting["mail_status"] != 0){
			echo __LINE__;
			return 0;
		}else{
			return 1;
		}
	}
	/**
	* 项目是否存在
	* @return boolean
	*/
	public function isExist($id){
		$id = intval($id);
		$query = "select * from ".TBPREFIX."projs where `id` = '".intval($id)."'";
		$return = 0;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			if($row['id'] != null)
				$return = 1;
			else
				$return = 0;
		}
		return $return;
	}
	/**
	* 更新用户
	* @param id 项目ID
	* @param uid 授权用户ID(array)
	* @return boolean
	*/
	public function updateUsers($id, $uids){
		$id	= intval($id);
		$uids = func_intintval($uids);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		if(is_array($uids)){
			$user	= new User("","");
			foreach($uids as $value){
				if(!($user->isExistU($user->getUsernameU($value)))){
					throw new Exception("User {$value} is not existed.");
				}
			}
			$uids = json_encode($uids);
		}else{
			$uids = "";
		}
		$query	= "update ".TBPREFIX."projs set `users` = '".func_addaddslashes($uids)."' where `id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 添加用户
	* @return boolean
	*/
	public function addUser($id, $uid){
		$id	= intval($id);
		$uid = intval($uid);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$user	= new User("","");
		if(!($user->isExistU($user->getUsernameU($uid)))){
			throw new Exception("User is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$users = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if(!$result){
			return 0;
		}
		if($row = mysql_fetch_array($result)){
			$users = trim($row['users']);
		}
		if(is_json($users)){
			$users = json_decode($users, true);
			$users = array_unique($users);
			if(!in_array($uid, $users)){
				$users[] = $uid;
			}
		}else{
			$users = array($uid);
		}
		$users = json_encode($users);
		$query = "update ".TBPREFIX."projs set `users` = '".func_addaddslashes($users)."' where `id` = ".intval($id)."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 删除用户
	* @return boolean
	*/
	public function deleteUser($id, $uid){
		$id	= intval($id);
		$uid = intval($uid);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$user	= new User("","");
		if(!($user->isExistU($user->getUsernameU($uid)))){
			throw new Exception("User is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$users = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if(!$result){
			return 0;
		}
		if($row = mysql_fetch_array($result)){
			$users = trim($row['users']);
		}
		if(is_json($users)){
			$users = json_decode($users, true);
			$users = array_unique($users);
			if(in_array($uid, $users)){
				$users_temp = $users;
				$users	= array();
				foreach($users_temp as $value){
					if($value != $uid){
						$users[] = $value;
					}
				}
			}
			$users = json_encode($users);
		}else{
			$users = "";
		}
		$query = "update ".TBPREFIX."projs set `users` = '".func_addaddslashes($users)."' where `id` = ".intval($id)."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 更新项目
	* @params id 项目ID
	*/
	public function update($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		if($this->updateParams($id)){
			throw new Exception("Update params failed");
		}
		if($this->updateSetting($id)){
			throw new Exception("Update setting failed");
		}
		return 1;
	}
	/**
	* 更新项目名
	* @params id 项目ID
	*/
	public function updateName($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "update ".TBPREFIX."projs set `name` = '".func_addaddslashes($this->name)."' where `id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 更新项目描述
	* @params id 项目ID
	*/
	public function updateDesc($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "update ".TBPREFIX."projs set `desc` = '".func_addaddslashes($this->desc)."' where `id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 更新项目参数
	* @params id 项目ID
	*/
	public function updateParams($id){	/**< 参数只能增加和减少,内容不会改变 */
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}else if(!($this->validateParams())){
			throw new Exception("Params is invalid.");
		}
		$oldparams = $this->getParams($id);
		$newparams_names = array();
		$oldparams_names = array();
		foreach($this->params as $value2){
			$newparams_names[] = $value2['name'];
		}
		foreach($oldparams as $value3){
			$oldparams_names[] = $value3['name'];
			if(!in_array($value3['name'], $newparams_names)){
				$param	= new Param($id, "");
				$param->delete($value3['id']);
				unset($param);
			}
		}
		foreach($this->params as $value){
			$param	= new Param($id, $value);
			if(!in_array($value['name'], $oldparams_names)){
				$param->add();
				//var_dump($value);
			}
			/*if(!($param->update())){ //直接整条删除或者添加,无需更新
				throw new Exception("Fail to add param ".htmlspecialchars($value['name']).".");
				exit;
			}*/
		}
		return 1;
	}
	
	/**
	* 更新项目设置
	* @params id 项目ID
	*/
	public function updateSetting($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}else if($this->name == "" || $this->desc == null){
			throw new Exception("Name or Desc is null.");
		}else if(!($this->validateSetting())){
			throw new Exception("Setting is invalid.");
		}
		$query = "update ".TBPREFIX."projs set `name` = '".func_addaddslashes($this->name)."',`desc` = '".func_addaddslashes($this->desc)."',`perpage` = '".intval($this->setting['perpage'])."',`reurl` = '".func_addaddslashes($this->setting['reurl'])."',`errurl` = '".func_addaddslashes($this->setting['errurl'])."',`recaptcha_status` = '".intval($this->setting['recaptcha_status'])."',`recaptcha_pubkey` = '".func_addaddslashes($this->setting['recaptcha_pubkey'])."',`recaptcha_privkey` = '".func_addaddslashes($this->setting['recaptcha_privkey'])."',`mail_status` = '".intval($this->setting['mail_status'])."',`mails` = '".func_addaddslashes($this->setting['mails'])."' where `id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if(!$result){
			return 0;
		}
		if(is_json($this->setting['default_show'])){	/**< 设置默认显示的参数 */
			$default_show	= json_decode($this->setting['default_show'], true);
			if(!is_array($default_show)){
				throw new Exception("Default_show is invalid.");
			}
			if(!$this->clearDefaultShow($id)){	/**< 先清空再写入 */
				throw new Exception("Couldn't clear DefaultShow.");
			}
			if(!$this->clearIndex($id)){	/**< 先清空再写入 */
				throw new Exception("Couldn't clear Index.");
			}
			$default_show	= array_unique($default_show);	/**< 避免重复 */
			$default_show	= func_intintval($default_show);
			$index = 0;
			foreach($default_show as $value){
				$param	= new Param($id, "");
				$param->defaultShow($value);
				$param->setIndex($value, $index++);
			}
		}
		return 1;
	}
	
	/**
	* 清除项目中参数的默认显示
	* @params id 项目ID
	*/
	public function clearDefaultShow($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "update ".TBPREFIX."params set `default_show` = '0' where `proj_id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 清除项目中参数的索引
	* @params id 项目ID
	*/
	public function clearIndex($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "update ".TBPREFIX."params set `jindex` = '0' where `proj_id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* 删除项目
	* @params id 项目ID
	*/
	public function delete($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$params	= $this->getParams($id);
		if(is_array($params)){
			$this->deleteParams($id);
		}
		$this->deleteItems($id);
		$query = "delete from ".TBPREFIX."projs where `id` = ".func_intintval($id)."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 删除项目参数
	* @params id 项目ID
	*/
	public function deleteParams($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$params	= $this->getParams($id);
		if(is_array($params)){
			foreach($params as $value){
				$p = new Param("","");
				$p->delete($value['id']);
				unset($p);
			}
		}
		return 1;
	}/**
	* 删除项目内容
	* @params id 项目ID
	*/
	public function deleteItems($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "DROP TABLE IF EXISTS `".TBPREFIX."items_".$id."`";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 停止新项目
	* @params id 项目ID
	*/
	public function stop($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "update ".TBPREFIX."projs set `status` = '0' where `id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* 开始项目
	* @params id 项目ID
	*/
	public function start($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "update ".TBPREFIX."projs set `status` = '1' where `id` = ".$id."";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 获得ID
	* @return id
	*/
	public function getID(){
		if($this->projid == null){
			throw new Exception("Project hasn't added.");
		}
		return $this->projid;
	}
	/**
	* 显示ID
	* @return id
	*/
	public function showID(){
		if($this->projid == null){
			throw new Exception("Project hasn't added.");
		}
		echo htmlspecialchars(intval($this->projid));
	}
	/**
	* 获得项目名
	* @params id 项目ID
	*/
	public function getName($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['name'];
		}
		return $return;
	}
	
	/**
	* 显示项目名
	* @params id 项目ID
	*/
	public function showName($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['name'];
		}
		echo htmlspecialchars($return);
	}
	
	/**
	* 获得项目描述
	* @params id 项目ID
	*/
	public function getDesc($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['desc'];
		}
		return $return;
	}
	
	/**
	* 显示项目描述
	* @params id 项目ID
	*/
	public function showDesc($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['desc'];
		}
		echo htmlspecialchars($return);
	}
	
	/**
	* 获得参数列表
	* @params id 项目ID
	*/
	public function getParams($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "select * from ".TBPREFIX."params where `proj_id` = '".$id."' order by `jindex`,`id`";
		$index = 0;
		$return = array();
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		while($row = mysql_fetch_array($result)){
			$return[$index] = $row;
			$index++;
		}
		return $return;
	}
	
	/**
	* 获得设置
	* @params id 项目ID
	*/
	public function getSetting($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row;
		}
		return $return;
	}
	
	/**
	* 获得权限用户
	* @params id 项目ID
	*/
	public function getAuth($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['users'];
		}
		return $return;
	}
	
	/**
	* 获得状态
	* @params id 项目ID
	*/
	public function getStatus($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['status'];
		}
		return $return;
	}
	
	/**
	* 获得reurl
	* @params id 项目ID
	*/
	public function getReurl($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['reurl'];
		}
		return $return;
	}
	
	/**
	* 获得errurl
	* @params id 项目ID
	*/
	public function getErrurl($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['errurl'];
		}
		return $return;
	}
	
	/**
	* 获得每页数量
	* @params id 项目ID
	*/
	public function getPerpage($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['perpage'];
		}
		return $return;
	}
	
	/**
	* 获得内容
	* @params id 项目ID
	*/
	public function getItems($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "select * from ".TBPREFIX."items_".$id."";
		$index = 0;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		while($row = mysql_fetch_array($result)){
			$return[$index] = $row;
			$index++;
		}
		return $return;
	}
	/**
	* 获得用户
	* @params id 项目ID
	* @return array UID
	*/
	public function getUsers($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query = "select * from ".TBPREFIX."projs where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['users'];
		}
		if(!is_json($return)){
			return array();
		}
		$return = json_decode($return);
		return $return;
	}
	
	/**
	* 获得内容数量
	* @params id 项目ID
	*/
	public function getItemsNum($id){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$query	= "select * from ".TBPREFIX."items_".$id."";
		$index = 0;
		$return = array();
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($result){
			while($row = mysql_fetch_array($result)){
				$return[$index] = $row;
				$index++;
			}
			return count($return);
		}else{
			return 0;
		}
	}
	
	/**
	* 导出项目
	* @params id 项目ID
	*/
	public function export($id, $params, $type){
		$id	= intval($id);
		if(!$this->isExist($id)){
			throw new Exception("Project[".$id."] is not existed.");
		}
		$items	= $this->getItems($id);
		$data	= array();
		foreach($items as $item){
			$data_item = array();
			foreach($params as $param){
				$param_name = (new Param($id, ""))->getName($param);
				if(isset($item[$param_name])){
					$data_item[$param_name] = $item[$param_name];
				}
			}
			$data[] = $data_item;
		}
		$filename = urlencode($this->getName($id).".".$type);
		$filename = str_replace("+", "%20", $filename);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		if($type == "csv"){
			$outputBuffer = fopen("php://output", 'w');
			foreach($data as $value){
				foreach($value as $key => $value2){
					$value[$key] = iconv('utf-8', 'gbk', $value2);
				}
				fputcsv($outputBuffer, $value);
			}
			 fclose($outputBuffer);
		}else if($type == "json"){
			echo json_encode($data);
		}else{
			$pname = $this->getName($id);
			$pdesc = $this->getDesc($id);
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("Ambulong")
							 ->setLastModifiedBy("Ambulong")
							 ->setTitle($pname)
							 ->setSubject($pname)
							 ->setDescription($pdesc)
							 ->setKeywords("zjut jinghong Ambulong")
							 ->setCategory("zjut");
			$c = "A";
			foreach($params as $value){
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue($c."1", (new Param($id, ""))->getName($value));
				$c++;
			}
			$i = 2;
			foreach($data as $value){
				$c = "A";
				foreach($value as $key => $value2){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($c.$i, $value[$key]);
					$c++;
				}
				$i++;
			}
			$objPHPExcel->getActiveSheet()->setTitle($pname);
			$objPHPExcel->setActiveSheetIndex(0);
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
		}
	}
}
