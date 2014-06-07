<?php

/**
* 单个参数操作类
*/
class Param {
	var $id;
	var $projid;
	var $param;
	/**
	* 构造函数
	* @param value	array参数内容
	*/
	function __construct($projid, $param) {
		$this->projid	= $projid;
		$this->param	= $param;
	}
	/**
	* 添加参数
	* 添加到表params和为item_*添加字段
	* @return boolean
	*/
	public function add(){
		if(!($this->isExistProj($this->projid))){
			throw new Exception("Proj is not existed.");
			return 0;
		}
		if(!($this->validateParam())){
			throw new Exception("Param is invalid.");
			return 0;
		}
		$item['name']	= func_addaddslashes($this->param['name']);
		if($this->param['type'] == "text"){
			$item['type']	= "varchar(200)";
		}else if($this->param['type'] == "url"){
			$item['type']	= "varchar(200)";
		}else if($this->param['type'] == "textarea"){
			$item['type']	= "text";
		}else if($this->param['type'] == "radio"){
			$item['type']	= "varchar(100)";
		}else if($this->param['type'] == "checkbox"){
			$item['type']	= "varchar(100)";
		}
		$query	= "insert into ".TBPREFIX."params(`proj_id`,`default_show`,`jindex`,`name`,`label`,`method`,`type`,`jcase`,`allow_null`,`regex`,`comment`) values('".intval($this->projid)."','".intval($this->param['default_show'])."','".intval($this->param['index'])."','".func_addaddslashes($this->param['name'])."','".func_addaddslashes($this->param['label'])."','".func_addaddslashes($this->param['method'])."','".func_addaddslashes($this->param['type'])."','".func_addaddslashes($this->param['case'])."','".func_addaddslashes($this->param['allow_null'])."','".func_addaddslashes($this->param['regex'])."','".func_addaddslashes($this->param['comment'])."');";
		$result2 = 1;
		if(!($this->isExistCol($item['name'], TBPREFIX."items_".intval($this->projid)))){
			$query2 =  "alter table `".TBPREFIX."items_".intval($this->projid)."` ADD `".$item['name']."` ".$item['type'].";";
			
			$result2 = mysql_query($query2) or die(__LINE__.":".mysql_errno().":".mysql_error());//报错1060:Duplicate column name '*' 不知原因
			
		}
		if(($this->isExistCol($item['name'], TBPREFIX."items_".intval($this->projid)))){//处理以上不明报错
			$result2 = 1;
			//echo "222222";
		}
		//echo $query."<br>";
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		$this->id	= mysql_insert_id();
		if($result && $result2){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 更新参数
	* @return boolean
	*/
	public function update(){
		if(!($this->isExistProj($this->projid))){
			throw new Exception("Proj is not existed.");
			return 0;
		}
		if(!($this->isExist($this->id))){
			throw new Exception("Param is not existed.(Maybe you haven't setID.)");
			return 0;
		}
		if(!($this->validateParam())){
			throw new Exception("Param is invalid.");
			return 0;
		}
		$query	= "update ".TBPREFIX."params set `name` = '".func_addaddslashes($this->param['name'])."',`label` = '".func_addaddslashes($this->param['label'])."',`method` = '".func_addaddslashes($this->param['method'])."',`type` = '".func_addaddslashes($this->param['type'])."',`jcase` = '".func_addaddslashes($this->param['jcase'])."',`allow_null` = '".func_addaddslashes($this->param['allow_null'])."',`regex` = '".func_addaddslashes($this->param['regex'])."',`comment` = '".func_addaddslashes($this->param['comment'])."' where `id` = ".$this->id.";";
		//echo $query;
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		if($result){
			return 1;
		}else{
			return 0;
		}
	}
	/**
	* 设置ID
	* @return void
	*/
	public function setID($id){
		$this->id	= intval($id);
	}
	/**
	* 设置PID
	* @return void
	*/
	public function setPID($pid){
		$this->pid	= intval($pid);
	}
	/**
	* 删除参数
	* 从表params删除和为item_*删除字段
	* @return boolean
	*/
	public function delete($id){
		if(!($this->isExist($id))){
			throw new Exception("Param is not existed.");
		}else{
			$query = "delete from ".TBPREFIX."params where `id` = ".func_intintval($id).";";
			$result2 = 1;
			if($this->isExistCol($this->getName($id), TBPREFIX."items_".intval($this->getPID($id)))){
				$query2 = "ALTER TABLE `".TBPREFIX."items_".intval($this->getPID($id))."` DROP COLUMN `".func_addaddslashes($this->getName($id))."`;";
				$result2 = mysql_query($query2) or die(__LINE__.":".mysql_errno().":".mysql_error());
			}
			$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
			if($result && $result2){
				return 1;
			}else{
				return 0;
			}
		}
	}
	/**
	* 默认显示
	* @return boolean
	*/
	public function defaultShow($id){
		if(!($this->isExist($id))){
			throw new Exception("Param is not existed.");
		}else{
			$query = "update ".TBPREFIX."params set `default_show` = '1' where `id` = ".intval($id)."";
			$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	/**
	* 获取所属项目ID
	* @return 所属项目ID
	*/
	public function getPID($id){
		if(!($this->isExist($id))){
			throw new Exception("Param is not existed.");
		}
		$query = "select * from ".TBPREFIX."params where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['proj_id'];
		}
		return $return;
	}
	/**
	* 获取name
	* @return name
	*/
	public function getName($id){
		if(!($this->isExist($id))){
			throw new Exception("Param is not existed.");
		}
		$query = "select * from ".TBPREFIX."params where `id` = '".$id."'";
		$return = null;
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['name'];
		}
		return $return;
	}
	/**
	* 设置索引
	* @return boolean
	*/
	public function setIndex($id, $index){
		if(!($this->isExist($id))){
			throw new Exception("Param is not existed.");
		}else{
			$query = "update ".TBPREFIX."params set `jindex` = '".intval($index)."' where `id` = ".intval($id)."";
			$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	/**
	* 项目是否存在
	* @return boolean
	*/
	public function isExistProj($pid){
		$pid = intval($pid);
		$query = "select * from ".TBPREFIX."projs where `id` = '".intval($pid)."'";
		$return = 0;
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			if($row['id'] != null)
				$return = 1;
			else
				$return = 0;
		}
		return $return;
	}
	/**
	* 参数是否存在
	* @return boolean
	*/
	public function isExist($id){
		$id = intval($id);
		$query = "select * from ".TBPREFIX."params where `id` = '".intval($id)."'";
		$return = 0;
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			if($row['id'] != null)
				$return = 1;
			else
				$return = 0;
		}
		return $return;
	}
	/**
	* 字段是否存在
	* @return boolean
	*/
	public function isExistCol($column, $table){
		$query = "SHOW COLUMNS FROM ".func_addaddslashes($table)."";
		//echo $query;
		$result = mysql_query($query) or die(__LINE__.":".mysql_errno().":".mysql_error());
		$array = array();
		if($result){
			while($row = mysql_fetch_array($result))   {
				$array[] = $row['Field'];
				//var_dump($row);
			}
		}
		if(in_array($column,$array))
			return 1;
		else
			return 0;
		
	}
	/**
	* 检查参数是否合法
	* @return boolean
	*/
	public function validateParam(){
		$value	= $this->param;
		if(!is_array($value)){	/**< 检查是否为数组 */
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
			return 0;
			break;
		}else if(	trim($value['name']) == "" || 
					trim($value['label']) == "" || 
					trim($value['method']) == "" || 
					trim($value['type']) == "" || 
					trim($value['allow_null']) == ""
		){
			return 0;
			break;
		}else if(!preg_match("/[a-z]$/", trim($value['name']))){	/**< name只允许为应为字母 */
			return 0;
			break;
		}else if(	!strcasecmp($value['method'], "post") && 
					!strcasecmp($value['method'], "get") && 
					!strcasecmp($value['method'], "request")
		){	/**< 检查method */
			return 0;
			break;
		}else if(	!strcasecmp($value['type'], "text") &&
					!strcasecmp($value['type'], "textarea") &&
					!strcasecmp($value['type'], "radio") &&
					!strcasecmp($value['type'], "checkbox") &&
					!strcasecmp($value['type'], "url")
		){	/**< 检查type */
			return 0;
			break;
		}else if(	!strcasecmp($value['allow_null'], "y") && 
					!strcasecmp($value['allow_null'], "n")
		){	/**< 检查allow_null */
			return 0;
			break;
		}else{
			return 1;
		}
	}
	
}
