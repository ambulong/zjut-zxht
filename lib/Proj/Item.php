<?php

/**
* 数据操作类
*/
class Item {
	var $projid;
	var $data;
	/**
	* 构造函数
	* @param value	array数据内容
	*/
	function __construct($projid, $data) {
		$this->projid	= $projid;
		$this->data	= $data;
	}
	/**
	* 添加数据
	* @return boolean
	*/
	public function add(){
		$table	= TBPREFIX."items_".$this->projid;
		if(is_array($this->data)){
			$i = 0;
			//var_dump($this->data);
			foreach($this->data as $value){
				//var_dump($value);
				if($i == 0){
					$q_name = "`".func_addaddslashes($value['name'])."`";
					$q_value = "'".func_addaddslashes($value['value'])."'";
					$i = 1;
				}else{
					$q_name = $q_name.",`".func_addaddslashes($value['name'])."`";
					$q_value = $q_value.",'".func_addaddslashes($value['value'])."'";
				}
			}
			$query = "insert into {$table}({$q_name}) values({$q_value})";
			//echo $query;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	/**
	* 删除记录
	* @return true成功 false失败
	*/
	public function delete($id) {
		$table	= TBPREFIX."items_".$this->projid;
		if(!($this->isExist($id))){
			throw new Exception("Item is not existed.");
		}else{
			$query = "delete from {$table} where `id` = ".intval($id);
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	/**
	* 记录是否已存在
	* @return true存在 false不在存在
	*/
	public function isExist($id) {
		$table	= TBPREFIX."items_".$this->projid;
		$query = "select * from {$table} where `id` = '".intval($id)."'";
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
	* 获取数据
	*/
	public function getData($id) {
		$table	= TBPREFIX."items_".$this->projid;
		if(!($this->isExist($id))){
			throw new Exception("Item is not existed.");
		}else{
			$query = "select * from {$table} where `id` = ".intval($id);
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row;
			}
			return $return;
		}
	}
}
