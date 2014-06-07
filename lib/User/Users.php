<?php

/**
* 用户管理操作类
*/
class Users {
	var $users;
	/**
	* 构造函数
	*/
	function __construct() {
		$this->users = new User("","");
	}
	
	/**
	* 获取所有用户信息
	*/
	public function getUsers(){
		$return = null;
		$query = "select * from ".TBPREFIX."users order by `id` desc";
		$index = 0;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		while($row = mysql_fetch_array($result)){
			$return[$index] = $row;
			$index++;
		}
		return $return;
	}
	/**
	* 获得用户ID
	*/
	public function getUID($uid){
		return $uid;
	}
	
	/**
	* 获得用户名
	*/
	public function getName($uid){
		return $this->users->getUsernameU($uid);
	}
	/**
	* 获得角色
	*/
	public function getRole($uid){
		return $this->users->getRole($this->users->getUsernameU($uid));
	}
	/**
	* 获得最后登录IP
	*/
	public function getIP($uid){
		return $this->getLastIP($this->users->getUsernameU($uid));
	}
	
	/**
	* 获得最后登录时间
	*/
	public function getTime($uid){
		return $this->getLastTime($this->users->getUsernameU($uid));
	}
	
	/**
	* 输出用户ID
	*/
	public function showUID($uid){
		echo func_htmlhtmlspecialchars($uid);
	}
	
	/**
	* 输出用户名
	*/
	public function showName($uid){
		echo func_htmlhtmlspecialchars($this->users->getUsernameU($uid));
	}
	
	/**
	* 输出最后登录IP
	*/
	public function showIP($uid){
		echo func_htmlhtmlspecialchars($this->users->getLastIP($this->users->getUsernameU($uid)));
	}
	
	/**
	* 输出最后登录时间
	*/
	public function showTime($uid){
		echo func_htmlhtmlspecialchars($this->users->getLastTime($this->users->getUsernameU($uid)));
	}
}
