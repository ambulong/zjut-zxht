<?php

/**
* 用户登录操作类
* 用户操作函数都无权限认证(除了auth()其它函数在password为任意值下都可操作), 使用时请注意使用者权限, 或者auth()后再操作
*/
class User {
	var $username;		/**< 用户名 */
	var $password;		/**< 用户密码 */
	var $hasher;		/**< phpass对象 */
	var $hash;			/**< 密码hash */
	var $hash_verify;	/**< 用来校验的hash */
	
	/**
	* 构造函数
	* @param username 用户名
	* @param password 密码
	*/
	function __construct($username, $password) {
		$this->username = trim($username);
		$this->password = trim($password);
		$this->hasher	= new PasswordHash(8, FALSE);
		$this->hash		= $this->hasher->HashPassword($password);
	}
	
	/**
	* 析构函数
	*/
	public function __destruct() {
		if(isset($this->hasher))
			unset($this->hasher);
	}
	
	/**
	* 设置用户名
	*/
	public function setUsername($username){
		$this->username = trim($username);
	}
	
	/**
	* 设置密码
	*/
	public function setPassword($password){
		$this->password = trim($password);
		$this->hasher	= new PasswordHash(8, FALSE);
		$this->hash	= $this->hasher->HashPassword($password);
	}
	
	/**
	* 登录认证
	* @return true认证成功 false认证失败
	*/
	public function auth() {
		if($this->isExist()){
			$this->hash_verify = $this->getPassword();
			if($this->hasher->CheckPassword($this->password, $this->hash_verify)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
		
	}
	
	/**
	* 用户是否已存在
	* @return true存在 false不在存在
	*/
	public function isExist() {
		$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($this->username)."'";
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
	* 用户是否已存在
	* @param username 用户名
	* @return true存在 false不在存在
	*/
	public function isExistU($username) {
		$username = trim($username);
		$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($username)."'";
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
	* 更新用户资料
	* @return true成功 false失败
	*/
	public function update() {
		if(!($this->isExist())){
			throw new Exception("Username has not existed.");
		}else if($this->username == null || $this->hash == null){
			throw new Exception("Username or Password is null.");
		}else{
			$query = "update ".TBPREFIX."users set `password` = '".func_addaddslashes($this->hash)."' where `id` = ".$this->getUID()."";
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	/**
	* 把用户添加到数据库
	* @return true成功 false失败
	*/
	public function add() {
		if($this->isExist()){
			throw new Exception("Username has been existed.");
		}else if($this->username == null || $this->password == null){
			throw new Exception("Username or Password is null.");
		}else{
			$query = "insert into ".TBPREFIX."users(`username`,`password`,`last_ip`,`last_time`,`role`) values('".func_addaddslashes($this->username)."','".func_addaddslashes($this->hash)."','0.0.0.0','0000-00-00 00:00:00','0')";
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	/**
	* 删除用户
	* @return true成功 false失败
	*/
	public function delete() {
		if(!($this->isExist())){
			throw new Exception("User is not existed.");
		}else if($this->getRole($this->username) == 1){
			throw new Exception("Admin couldn't be deleted.");
		}else{
			$uid = $this->getUID();
			$query = "delete from ".TBPREFIX."users where `id` = ".func_intintval($uid)." and `role` = 0";
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	/**
	* 是否已登录
	* @return true false
	*/
	public function isLogin() {
		if(isset($_SESSION['isLogin'])){
			if($_SESSION['isLogin'] == 1){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	/**
	* 是不是管理员
	* @return true false
	*/
	public function isAdmin() {
		if(getRole($this->username) == 1)
			return 1;
		else
			return 0;
	}
	
	/**
	* 登录操作
	* @return true成功 false失败
	*/
	public function login() {
		if($this->auth()){
			$_SESSION['isLogin']	= 1;
			$_SESSION['user']['uid']		= $this->getUID();
			$_SESSION['user']['role']		= $this->getRole($this->username);
			$_SESSION['user']['username']	= $this->username;
			$_SESSION['user']['password']	= $this->password;
			func_set_token();
			$query = "update ".TBPREFIX."users set `last_ip` = '".func_addaddslashes(func_IP())."',`last_time` = '".func_addaddslashes(func_TIME())."' where `id` = ".$this->getUID()."";
			mysql_query($query) or die(mysql_errno().":".mysql_error());
			$this->log();
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* 登出操作
	* @return true成功 false失败
	*/
	public function logout() {
		if(session_unset()){
			return 1;
		}else{
			return 0;
		}
	}
	
	/**
	* 记录到登录日志
	* @return true成功 false失败
	*/
	public function log() {
		if(!$this->isLogin()){
			throw new Exception("Hasn't logined.");
		}else{
			$extend = array(
				"HTTP_ACCEPT"	=>	$_SERVER["HTTP_ACCEPT"],
				"HTTP_HOST"		=>	$_SERVER["HTTP_HOST"],
				"HTTP_REFERER"	=>	$_SERVER["HTTP_REFERER"],
				"HTTP_USER_AGENT"	=>	$_SERVER["HTTP_USER_AGENT"]
			);
			$extend = func_addaddslashes(json_encode($extend));
			$query = "insert into ".TBPREFIX."users_log(`uid`,`ip`,`time`,`extend`) values('".$this->getUID()."','".func_IP()."','".func_TIME()."','{$extend}')";
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}
	
	/**
	* 获取用户名
	* @return 用户名
	*/
	public function getUsername() {
		return $this->username;
	}
	/**
	* 输出用户名
	* @return 用户名
	*/
	public function showUsername() {
		echo htmlspecialchars($this->username);
	}
	
	/**
	* 获取用户名
	* @params uid 用户ID
	* @return 用户名
	*/
	public function getUsernameU($uid) {
		$query = "select * from ".TBPREFIX."users where `id` = '".func_intintval($uid)."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['username'];
		}
		if($return == null){
			throw new Exception("Username is null.");
		}else
			return $return;
	}
	/**
	* 输出用户名
	* @params uid 用户ID
	* @return 用户名
	*/
	public function showUsernameU($uid) {
		$query = "select * from ".TBPREFIX."users where `id` = '".func_intintval($uid)."'";
		$return = null;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		if($row = mysql_fetch_array($result)){
			$return = $row['username'];
		}
		if($return == null){
			throw new Exception("Username is null.");
		}else
			echo htmlspecialchars($return);
	}
	
	/**
	* 获取用户密码hash
	* @return hash
	*/
	public function getPassword() {
		if(!($this->isExistU($this->username))){
			throw new Exception("User hasn't existed.");
		}else{
			$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($this->username)."'";
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row['password'];
			}
			if($return == null){
				throw new Exception("Hash is null.");
			}else
				return $return;
		}
	}
	
	/**
	* 获取用户ID
	* @return 用户ID
	*/
	public function getUID() {
		if(!($this->isExist())){
			throw new Exception("User hasn't existed.");
		}else{
			$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($this->username)."'";
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row['id'];
			}
			if($return == null)
				throw new Exception("UID is null.");
			else
				return $return;
		}
	}
	
	/**
	* 获取用户ID
	* @param username 用户名
	* @return 用户ID
	*/
	public function getUIDU($username) {
		if(!isset($username)){
			throw new Exception("unset username.");
		}
		$username = trim($username);
		if(!($this->isExistU($username))){
			throw new Exception("User hasn't existed.");
		}else{
			$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($username)."'";
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row['id'];
			}
			if($return == null)
				throw new Exception("UID is null.");
			else
				return $return;
		}
	}
	
	/**
	* 获取用户最后登录IP
	* @return 最后登录IP
	*/
	public function getLastIP($username) {
		if(!isset($username)){
			throw new Exception("unset username.");
		}
		$username = trim($username);
		if(!($this->isExistU($username))){
			throw new Exception("User($username) hasn't existed.");
		}else{
			$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($username)."'";
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row['last_ip'];
			}
			return $return;
		}
	}
	
	/**
	* 获取用户最后登录时间
	* @return 最后登录时间
	*/
	public function getLastTime($username) {
		if(!isset($username)){
			throw new Exception("unset username.");
		}
		$username = trim($username);
		if(!($this->isExistU($username))){
			throw new Exception("User hasn't existed.");
		}else{
			$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($username)."'";
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row['last_time'];
			}
			return $return;
		}
	}
	
	/**
	* 获取用户角色
	* @return 用户角色 0普通用户 1管理员
	*/
	public function getRole($username) {
		if(!isset($username)){
			throw new Exception("unset username.");
		}
		$username = trim($username);
		if(!($this->isExistU($username))){
			throw new Exception("User hasn't existed.");
		}else{
			$query = "select * from ".TBPREFIX."users where `username` = '".func_addaddslashes($username)."'";
			$return = null;
			$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
			if($row = mysql_fetch_array($result)){
				$return = $row['role'];
			}
			return $return;
		}
	}
	
	/**
	* 获取用户的日志
	* @return array日志
	*/
	public function getLogs($username) {
		$return = null;
		$uid = $this->getUID(trim($username));
		$query = "select * from ".TBPREFIX."users_log where `uid` = '".func_intintval($uid)."' order by `id` desc limit 0,23";
		$index = 0;
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		while($row = mysql_fetch_array($result)){
			$return[$index] = $row;
			$index++;
		}
		return $return;
	}
	
}
