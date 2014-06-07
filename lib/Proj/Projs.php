<?php
/**
* 项目管理操作类
*/
class Projs {
	var $proj;
	var $uid;
	var $urole;
	/**
	* 构造函数
	*/
	function __construct($uid) {
		$user	= new User("","");
		if(!($user->isExistU($user->getUsernameU($uid)))){
			throw new Exception("User is not existed.");
		}
		if(($user->getRole($user->getUsernameU($uid))) == 1){
			$this->urole = 1;
		}else{
			$this->urole = 0;
		}
		$this->proj = new Proj("","","","");
		$this->uid	= intval($uid);
	}
	
	/**
	* 获取用户项目信息
	*/
	public function getProjs(){
		$projs = array();
		$return = array();
		$query = "select * from ".TBPREFIX."projs order by `id` desc";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		while($row = mysql_fetch_array($result)){
			$projs[] = $row;
		}
		if($this->urole != 1){
			foreach($projs as $value){
				$users	= trim($value['users']);
				if(is_json($users))
					$users	= json_decode($users);
				if(is_array($users)){
					$users	= array_unique($users);
					if(in_array($this->uid, $users)){
						$return[] = $value;
					}
				}
			}
		}else{
			$return = $projs;
		}
		return $return;
	}
	
	/**
	* 获得项目ID
	*/
	public function getPID($pid){
		return intval($pid);
	}
	
	/**
	* 获得项目名
	*/
	public function getName($pid){
		return $this->proj->getName($pid);
	}
	
	/**
	* 获得项目状态
	*/
	public function getStatus($pid){
		return $this->proj->getStatus($pid);
	}
	
	/**
	* 获得项目数量
	*/
	public function getItemsNum($pid){
		return $this->proj->getItemsNum($pid);
	}
	
	/**
	* 显示项目ID
	*/
	public function showPID($pid){
		echo htmlspecialchars($pid);
	}
	
	/**
	* 显示项目名
	*/
	public function showName($pid){
		echo htmlspecialchars($this->proj->getName($pid));
	}
	
	/**
	* 显示项目状态
	*/
	public function showStatus($pid){
		echo htmlspecialchars($this->proj->getStatus($pid));
	}
	
	/**
	* 显示项目状态
	*/
	public function showStatusC($pid){
		echo htmlspecialchars(($this->proj->getStatus($pid)==0)?"停止":"使用中");
	}
	/**
	* 显示项目数量
	*/
	public function showItemsNum($pid){
		echo htmlspecialchars($this->proj->getItemsNum($pid));
	}
}
